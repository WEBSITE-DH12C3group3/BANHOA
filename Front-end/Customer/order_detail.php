<?php
include 'header.php';
include_once '/xampp/htdocs/BANHOA/database/sendmailreset.php';
include_once '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

// Lấy mã đơn hàng từ URL
if (isset($_GET['order_code'])) {
    $order_code = $_GET['order_code'];

    // Truy vấn thông tin chi tiết đơn hàng và trạng thái
    $query = "SELECT o.order_code, o.status, p.product_name, p.price_sale AS price, oi.quantity
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
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    color: #333;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    margin: 40px auto;
    padding: 5px;
    border-radius: 8px;
    text-align: center;
}

h1 {
    font-size: 24px;
    color: #444;
    margin-bottom: 30px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
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

a {
    color: #007BFF;
    text-decoration: none;  /* Bỏ gạch chân */
    font-size: 16px;
}

a:hover {
    color: #0056b3;
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Chi tiết đơn hàng #<?php echo $order_code; ?></h1>
        <table>
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Tổng tiền</th>
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
                    <td><?php echo $item['product_name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo number_format($total_price, 0, ',', '.'); ?> VND</td>
                </tr>
                <?php } } else { ?>
                <tr>
                    <td colspan="4">Không có sản phẩm nào trong đơn hàng này.</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <h3>Tổng cộng: <?php echo number_format($total_amount, 0, ',', '.'); ?> VND</h3>

        <?php if ($order_status === 'chờ duyệt') { ?>
            <!-- Nút Hủy đơn hàng với JavaScript xác nhận -->
            <form id="cancelOrderForm" action="/BANHOA/database/cancel_order.php" method="post" onsubmit="return confirmCancel();">
                <input type="hidden" name="order_code" value="<?php echo $order_code; ?>">
                <button type="submit" name="cancel_order" style="background-color: #F44336; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">
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
