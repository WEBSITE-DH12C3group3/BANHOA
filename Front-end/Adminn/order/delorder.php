<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

// Kiểm tra xem ID sinh viên có tồn tại trong GET hay không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM orders WHERE id = $id";
    if ($db->delete($query)) {
        // Hiển thị thông báo thành công bằng JavaScript
        header("Location: order.php?status=success&title=Thành công!&message=" . urlencode('Xóa đơn hàng thành công!'));
    } else {
        // Hiển thị thông báo lỗi bằng JavaScript
        header("Location: order.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi xóa đơn hàng.'));
    }
} else {
    header("Location: order.php?status=error&title=Lỗi!&message=" . urlencode('Mã đơn hàng không được xác định.'));
}
