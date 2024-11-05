<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

// Kiểm tra xem ID sinh viên có tồn tại trong GET hay không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM orders WHERE id = $id";
    if ($db->delete($query)) {
        // Hiển thị thông báo thành công bằng JavaScript
        echo "<script>alert('Xóa thành công!'); window.location.href = 'order.php';</script>";
    } else {
        // Hiển thị thông báo lỗi bằng JavaScript
        echo "<script>alert('Lỗi khi xóa!'); window.location.href = 'order.php';</script>";
    }
} else {
    echo "<script>alert('Mã khách không được xác định.'); window.location.href = 'order.php';</script>";
}
