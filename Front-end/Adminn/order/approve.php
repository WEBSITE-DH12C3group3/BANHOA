<?php
include_once '/xampp/htdocs/BANHOA/database/sendmailreset.php';
include_once '../baidautot.php';
$db = new Database();
$mailer = new Mailer();

if (isset($_GET['id']) && isset($_GET['order_code'])) {
    $id = $_GET['id'];
    $order_code = $_GET['order_code'];

    // Tính tổng tiền cho đơn hàng dựa trên sản phẩm trong order_items
    $item_query = "SELECT p.price_sale, oi.quantity 
                   FROM order_items oi
                   JOIN products p ON oi.product_id = p.id
                   WHERE oi.order_code = ?";
    $stmt2 = $db->conn->prepare($item_query);
    $stmt2->bind_param("s", $order_code);
    $stmt2->execute();
    $item_result = $stmt2->get_result();

    $total = 0;
    while ($item = $item_result->fetch_assoc()) {
        $total += $item['price_sale'] * $item['quantity'];
    }

    // Cập nhật tổng tiền và trạng thái đơn hàng trong bảng orders
    $update_query = "UPDATE orders SET total = ?, status = 'Đã duyệt' WHERE id = ? AND order_code = ?";
    $update_stmt = $db->conn->prepare($update_query);
    $update_stmt->bind_param("dis", $total, $id, $order_code);

    if ($update_stmt->execute()) {
        // Lấy thông tin email khách hàng
        $email_query = "SELECT u.email FROM users u 
                        JOIN orders o ON u.id = o.user_id 
                        WHERE o.id = ? AND o.order_code = ?";
        $email_stmt = $db->conn->prepare($email_query);
        $email_stmt->bind_param("is", $id, $order_code);
        $email_stmt->execute();
        $email_result = $email_stmt->get_result();

        if ($email_result->num_rows > 0) {
            $email_row = $email_result->fetch_assoc();
            $customer_email = $email_row['email'];

            // Gửi email xác nhận duyệt đơn hàng
            $title = "Xác nhận đơn hàng #$order_code đã được duyệt";
            $content = "<p>Xin chào,</p>
                        <p>Đơn hàng của bạn với mã <strong>$order_code</strong> đã được duyệt thành công.</p>
                        <p>Tổng tiền: <strong>" . number_format($total, 0, ',', '.') . " VND</strong></p>
                        <p>Cảm ơn bạn đã mua hàng tại Shop Hoa Tươi EDEN!</p>";
            $mailer->sendMail($title, $content, $customer_email);
        }

        // Chuyển hướng về trang order.php sau khi duyệt đơn hàng
        echo "<script>window.location.href = 'order.php';</script>";
        exit(); // Đảm bảo rằng không còn mã PHP nào chạy sau khi chuyển hướng
    } else {
        echo "<script>alert('Lỗi khi duyệt đơn hàng!'); window.location.href = 'order.php';</script>";
    }

    // Đóng các kết nối
    $stmt2->close();
    $update_stmt->close();
    $email_stmt->close();
}
?>
