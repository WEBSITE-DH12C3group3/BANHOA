<?php
include 'header.php';
include_once '/xampp/htdocs/BANHOA/database/sendmailreset.php';
include_once '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

// Lấy mã đơn hàng từ URL
if (isset($_GET['order_code'])) {
    $order_code = $_GET['order_code'];

    // Truy vấn thông tin chi tiết đơn hàng
    $query = "SELECT o.order_code, p.product_name, p.price_sale AS price, oi.quantity
              FROM order_items oi
              JOIN orders o ON oi.order_code = o.order_code
              JOIN products p ON oi.product_id = p.id
              WHERE o.order_code = '$order_code'";
    $result = $db->select($query);
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
        /* CSS cho toàn bộ trang */
/* CSS cho toàn bộ trang */
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
    text-decoration: underline;
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
    </div>
</body>
</html>

<?php
include 'footer.php';
?>
