<?php
include 'header.php';
include_once '/xampp/htdocs/BANHOA/database/sendmailreset.php';
include_once '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

// Kiểm tra xem có yêu cầu cập nhật trạng thái không (thông qua POST)
if (isset($_POST['order_code']) && isset($_POST['status'])) {
    $order_code = $_POST['order_code'];
    $status = $_POST['status'];

    // Cập nhật trạng thái trong cơ sở dữ liệu
    $update_query = "UPDATE orders SET status = ? WHERE order_code = ?";
    $update_stmt = $db->conn->prepare($update_query);
    $update_stmt->bind_param("ss", $status, $order_code); // s cho chuỗi
    if ($update_stmt->execute()) {
        echo "<script>alert('Cập nhật trạng thái thành công!');</script>";
    } else {
        echo "Có lỗi xảy ra khi cập nhật trạng thái.";
    }
}

// Lấy mã đơn hàng từ URL
if (isset($_GET['order_code'])) {
    $order_code = $_GET['order_code'];

    // Truy vấn thông tin chi tiết đơn hàng và trạng thái
    $query = "SELECT o.order_code, o.status, p.id, p.image, p.product_name, p.price_sale AS price, oi.quantity
              FROM order_items oi
              JOIN orders o ON oi.order_code = o.order_code
              JOIN products p ON oi.product_id = p.id
              WHERE o.order_code = '$order_code'";
    $result = $db->select($query);

    // Lấy trạng thái đơn hàng
    $order_status_query = "SELECT status FROM orders WHERE order_code = '$order_code'";
    $order_status_result = $db->select($order_status_query);
    $order_status = $order_status_result ? $order_status_result->fetch_assoc()['status'] : '';
} else {
    echo "Mã đơn hàng không hợp lệ!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?php echo $order_code; ?></title>
    <link rel="stylesheet" href="/BANHOA/mycss/order_manage.css">
    <style>
        h1 {
            font-size: 24px;
            color: #444;
            margin-bottom: 30px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
            font-size: 16px;
        }

        th {
            background-color: #f1f1f1;
            color: #444;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        h3 {
            margin-top: 20px;
            font-size: 18px;
            color: #444;
            font-weight: bold;
        }

        button {
            background-color: #F44336;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #D32F2F;
        }

        .code {
            color: #007BFF;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .left {
            text-align: left;
        }

        .right {
            text-align: right;
            margin-bottom: 0px;
        }
    </style>
</head>

<body style="margin-top: 200px;">
    <div class="container">
        <h1>Chi tiết đơn hàng <span class="code">#<?php echo $order_code; ?></span></h1>
        <table>
            <thead>
                <tr>
                    <th>Hình ảnh sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng tiền</th>
                    <?php if ($order_status === 'Đã nhận') { ?> <!-- Chỉ hiển thị cột đánh giá nếu trạng thái đơn hàng là 'Đã nhận' -->
                        <th>Đánh giá</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_amount = 0;
                if ($result) {
                    while ($item = $result->fetch_assoc()) {
                        $total_price = $item['price'] * $item['quantity'];
                        $total_amount += $total_price;
                ?>
                        <tr>
                            <td><img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $item['image']; ?>" alt="" width="100"></td>
                            <td><a href="hoa.php?id=<?php echo $item['id']; ?>"><?php echo $item['product_name']; ?></a></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                            <td><?php echo number_format($total_price, 0, ',', '.'); ?> VND</td>
                            <?php if ($order_status === 'Đã nhận') { ?> <!--khi click vao dnh gia se dan den phan danh gia tai trang hoa.php -->
                                <td><a href="hoa.php?id=<?php echo $item['id']; ?>&show_comments=true#comments" class="review-button" data-target="comments">Đánh giá</a></td>
                            <?php } ?>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5">Không có sản phẩm nào trong đơn hàng này.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3 class="left">Tổng cộng: <?php echo number_format($total_amount, 0, ',', '.'); ?> VND</h3>

        <?php if ($order_status == 'Đã duyệt') { ?>
            <!-- Nút để khách hàng xác nhận đã nhận hàng -->
            <form class="right" id="receiveOrderForm" method="POST" onsubmit="return confirmFinish();">
                <input type="hidden" name="order_code" value="<?php echo $order_code; ?>">
                <input type="hidden" name="status" value="Đã nhận">
                <button type="submit" name="finish">
                    Đã nhận hàng
                </button>
            </form>
        <?php } ?>
        <script>
                function confirmFinish() {
                    const confirmResult = confirm("Xác nhận rằng bạn đã nhận được đơn hàng này?");
                    
                    if (confirmResult) {
                        alert("Bạn đã xác nhận đã nhận hàng. Cảm ơn bạn!");
                        return true;
                    } else {
                        alert("Bạn chưa xác nhận đơn hàng.");
                    }

                    // Trả về false để ngăn biểu mẫu gửi đi và ở lại trang
                    return false;
                }

                
            </script>

        <?php if ($order_status === 'Chờ duyệt') { ?>
            <!-- Nút Hủy đơn hàng với JavaScript xác nhận -->
            <form class="right" id="cancelOrderForm" action="/BANHOA/database/cancel_order.php" method="post" onsubmit="return confirmCancel();">
                <input type="hidden" name="order_code" value="<?php echo $order_code; ?>">
                <button type="submit" name="cancel_order">
                    Hủy đơn hàng
                </button>
            </form>
        <?php } ?>
    </div>

    <script>
        function confirmCancel() {
            if (confirm("Bạn có chắc chắn muốn hủy đơn hàng này không?")) {
                alert("Đơn hàng đã được hủy thành công!");
                return true; // Gửi biểu mẫu
            } else {
                return false; // Hủy hành động gửi biểu mẫu
            }
        }
    </script>
</body>

</html>

<?php include 'footer.php'; ?> 
