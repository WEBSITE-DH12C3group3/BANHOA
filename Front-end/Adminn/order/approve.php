<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

// Kiểm tra xem ID sinh viên có tồn tại trong GET hay không
if (isset($_GET['id']) && isset($_GET['order_code'])) {
    $id = $_GET['id'];
    $order_code = $_GET['order_code'];

    // Tính tổng tiền cho mỗi đơn hàng dựa trên các sản phẩm trong order_items
    $item_query = "SELECT p.price_sale, oi.quantity 
                       FROM order_items oi
                       JOIN products p ON oi.product_id = p.id
                       WHERE oi.order_code = ?";
    $stmt2 = $db->conn->prepare($item_query);
    $stmt2->bind_param("s", $order_code);
    $stmt2->execute();
    $item_result = $stmt2->get_result();

    $total = 0;
    if ($item_result) {
        while ($item = $item_result->fetch_assoc()) {
            $total += $item['price_sale'] * $item['quantity'];
        }
    }

    // Cập nhật tổng tiền cho đơn hàng hiện tại trong bảng orders
    $update_query = "UPDATE orders SET total = ? WHERE id = ? AND order_code = ?";
    $update_stmt = $db->conn->prepare($update_query);
    $update_stmt->bind_param("dis", $total, $id, $order_code);
    $update_stmt->execute();

    $stmt = $db->conn->prepare("UPDATE orders SET status='Đã duyệt' WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Duyệt thành công!'); window.location.href = 'order.php';</script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi duyệt: ' + '$error'); window.location.href = 'order.php';</script>";
    }

    $stmt->close();
}
