<?php
include 'header.php';
include_once '/xampp/htdocs/BANHOA/database/sendmailreset.php';
include_once '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

// Lấy thông tin đơn hàng của khách hàng đang đăng nhập (giả sử đã có session người dùng)
$user_id = $_SESSION['users_id'];

// Truy vấn tất cả đơn hàng của khách hàng
$query = "SELECT id, order_code, user_id, order_date, total, status 
          FROM orders 
          WHERE user_id = $user_id";
$result = $db->select($query);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <style>
        /* CSS cho trang Quản lý đơn hàng */

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            /* background: #fff; */
            padding: 5px;
            border-radius: 5px;
        }

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

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
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
        }

        .status.pending {
            background-color: #FFC107;
        }

        .status.canceled {
            background-color: #F44336;
        }

        a {
            color: #007BFF;
            text-decoration: none;  /* Bỏ gạch chân */
        }

        a:hover {
            text-decoration: none;  /* Bỏ gạch chân */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản lý đơn hàng của tôi</h1>
        <table>
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result) {
                    while ($order = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $order['order_code']; ?></td>    
                        <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
                        <td>
                            <?php 
                            if ($order['status'] == 'Đã duyệt') {
                                echo '<span class="status approved">Đã duyệt</span>';
                            } else if ($order['status'] == 'chờ duyệt') {
                                echo '<span class="status pending">Chờ duyệt</span>';
                            } else {
                                echo '<span class="status canceled">Đã hủy</span>';
                            }
                            ?>
                        </td>
                        <td><?php echo date('d/m/Y', strtotime($order['order_date'])); ?></td>
                        <td><a href="order_detail.php?order_code=<?php echo $order['order_code']; ?>">Xem chi tiết</a></td>
                    </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5">Không có đơn hàng nào.</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php include 'footer.php'; ?> 
