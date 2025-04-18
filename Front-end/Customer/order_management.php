<?php
include 'header.php';
include_once '/xampp/htdocs/BANHOA/database/sendmailreset.php';
include_once '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

// Lấy thông tin đơn hàng của khách hàng đang đăng nhập (giả sử đã có session người dùng)
$user_id = $_SESSION['users_id'];

// Truy vấn tất cả đơn hàng của khách hàng
$query = "SELECT id, order_code, user_id, order_date, total, status, payment_method
          FROM orders 
          WHERE user_id = $user_id
          ORDER BY order_date DESC";
$result = $db->select($query);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        /* CSS cho trang Quản lý đơn hàng */

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: center;
        }

        th {
            background-color: #f8f8f8;
            color: #555;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        .status {
            padding: 5px 10px;
            border-radius: 4px;
            color: #fff;
            font-size: 0.9em;
        }

        .status.approved {
            background-color: #4CAF50;
            border: #4CAF50 1px solid;
        }

        .status.pending {
            background-color: #FFC107;
            border: #FFC107 1px solid;
        }

        .status.paid {
            /*  Thêm trạng thái đã thanh toán*/
            background-color: #2196F3;
            border: #2196F3 1px solid;
            /* Blue - Đã thanh toán */
        }

        .status.canceled {
            background-color: #F44336;
            border: #F44336 1px solid;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            /* Bỏ gạch chân */
        }

        a:hover {
            text-decoration: none;
            /* Bỏ gạch chân */
        }

        button.status.paid:hover {
            background-color: #007CFF;
            border: #007CFF 1px solid;
            /* Blue - Đã thanh toán */
        }
    </style>
</head>

<body style="margin-top: 200px;">
    <div class="container">
        <h1>Quản lý đơn hàng của tôi</h1>
        <table>
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hình thức</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result) {
                    while ($order = $result->fetch_assoc()) {
                        $q = "SELECT p.price_sale, oi.quantity
                            FROM order_items oi
                            JOIN orders o ON oi.order_code = o.order_code
                            JOIN products p ON oi.product_id = p.id
                            WHERE o.order_code = '$order[order_code]'";
                        $rs = $db->select($q);
                        if ($rs) {
                            $total_amount = 0;
                            while ($item = $rs->fetch_assoc()) {
                                $total_price = $item['price_sale'] * $item['quantity'];
                                $total_amount += $total_price;
                            }
                        }
                ?>
                        <tr>
                            <td><?php echo $order['order_code']; ?></td>
                            <td><?php echo number_format($total_amount, 0, ',', '.'); ?> VND</td>
                            <td>
                                <?php
                                if ($order['status'] == 'Đã duyệt') {
                                    echo '<span class="status approved">Đã duyệt</span>';
                                } else if ($order['status'] == 'Chờ duyệt') {
                                    echo '<span class="status pending">Đang xử lý</span>';
                                } else if ($order['status'] == 'Đã nhận') {
                                    echo '<span class="status pending">Đã nhận</span>';
                                } else if ($order['status'] == 'Đã thanh toán') {
                                    echo '<span class="status paid">Đã thanh toán</span>';
                                } else {
                                    echo '<span class="status canceled">Đã hủy</span>';
                                }
                                ?>
                            </td>
                            <td><?php echo date('h:i:s A d/m/Y', strtotime($order['order_date'])); ?></td>

                            <?php
                            if ($order['payment_method'] == 'momo' || $order['payment_method'] == 'momo_atm' || $order['payment_method'] == 'vnpay') {
                                $pmquery = $db->select("SELECT * FROM momo WHERE order_code = '$order[order_code]'");

                            ?>
                                <td><button type="button" class="btn btn-primary status paid"
                                        data-bs-toggle="modal" data-bs-target="#Modal"
                                        data-order-code="<?php echo $order['order_code']; ?>"
                                        data-payment-method="<?php echo $order['payment_method']; ?>">
                                        <span class="text-uppercase"><?php echo $order['payment_method']; ?></span>
                                    </button></td>
                            <?php } else { ?>
                                <td><button type="button" class="btn btn-primary status paid" disabled>
                                        <?php if ($order['payment_method'] == 'bank') {
                                            echo 'Banking';
                                        } elseif ($order['payment_method'] == 'cash') {
                                            echo 'COD';
                                        }
                                        ?></button></td>
                            <?php } ?>

                            <td><a href="order_detail.php?order_code=<?php echo $order['order_code']; ?>">Xem chi tiết</a></td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="6">Không có đơn hàng nào.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h1 style="margin-top: 50px;"></h1>
    </div>
</body>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Chi tiết thanh toán qua cổng thanh toán</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    <!-- Dữ liệu từ server sẽ được tải ở đây -->
                    <p>Đang tải dữ liệu...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById('Modal');

        modal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget; // Button that triggered the modal
            var orderCode = button.getAttribute('data-order-code');
            var paymentMethod = button.getAttribute('data-payment-method');

            // Gửi dữ liệu qua AJAX
            var modalContent = document.getElementById('modalContent');
            modalContent.innerHTML = "<p>Đang tải dữ liệu...</p>";

            fetch('fetch_order_details.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order_code: orderCode,
                        payment_method: paymentMethod
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const details = data.details;
                        // Nội dung hiển thị cơ bản
                        let content = `
                        <p><strong>Mã đơn hàng:</strong> ${details.order_code}</p>
                        <p><strong>Thông tin chi tiết:</strong> ${details.order_info}</p>
                        <p><strong>Mã giao dịch:</strong> ${details.trans_id}</p>
                        <p><strong>Kiểu thanh toán:</strong> ${details.pay_type}</p>
                        `;

                        // Hiển thị các trường bổ sung nếu có
                        if (details.amount) {
                            const formattedAmount = formatCurrency(details.amount);
                            content += `<p><strong>Số tiền:</strong> ${formattedAmount}</p>`;
                        }
                        if (details.vnpay_amount) {
                            amount = details.vnpay_amount / 100;
                            const formattedAmount = formatCurrency(amount);
                            content += `<p><strong>Số tiền:</strong> ${formattedAmount}</p>`;
                        }
                        if (details.vnpay_paydate) {
                            const formattedDate = formatDate(details.vnpay_paydate);
                            content += `<p><strong>Ngày thanh toán:</strong> ${formattedDate}</p>`;
                        }
                        if (details.vnpay_bankcode) {
                            content += `<p><strong>Mã ngân hàng:</strong> ${details.vnpay_bankcode}</p>`;
                        }
                        if (details.vnpay_banktranno) {
                            content += `<p><strong>Mã giao dịch ngân hàng:</strong> ${details.vnpay_banktranno}</p>`;
                        }
                        if (details.vnpay_tmncode) {
                            content += `<p><strong>Mã điểm giao dịch:</strong> ${details.vnpay_tmncode}</p>`;
                        }

                        modalContent.innerHTML = content;
                    } else {
                        modalContent.innerHTML = `<p>${data.message}</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error fetching order details:', error);
                    modalContent.innerHTML = `<p>Lỗi: Không thể tải thông tin chi tiết. Vui lòng thử lại.</p>`;
                });
        });
    });

    function parseDate(dateString) {
        const year = dateString.slice(0, 4);
        const month = dateString.slice(4, 6);
        const day = dateString.slice(6, 8);
        const hour = dateString.slice(8, 10);
        const minute = dateString.slice(10, 12);
        const second = dateString.slice(12, 14);

        return new Date(year, month - 1, day, hour, minute, second);
    }

    function formatDate(dateString) {
        const date = parseDate(dateString);
        return new Intl.DateTimeFormat('vi-VN', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
        }).format(date);
    }

    function formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    }
</script>

</html>
<?php include 'footer.php'; ?>