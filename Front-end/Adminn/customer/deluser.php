<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

// Kiểm tra xem ID sinh viên có tồn tại trong GET hay không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM users WHERE id = $id";
    if ($db->delete($query)) {
        // Hiển thị thông báo thành công bằng JavaScript
        header("Location: ctm.php?status=success&title=Thành công!&message=" . urlencode('Xóa thành công!'));
    } else {
        // Hiển thị thông báo lỗi bằng JavaScript
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi xóa!'));
    }
} else {
    header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Mã khách không được xác định.'));
}
