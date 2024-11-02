<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

// Kiểm tra xem ID sinh viên có tồn tại trong GET hay không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use parameterized query to prevent SQL injection
    $stmt = $db->conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("s", $id); // 'i' specifies that $id is an integer

    if ($stmt->execute()) {
        // Hiển thị thông báo thành công bằng JavaScript
        echo "<script>alert('Xóa thành công!'); window.location.href = 'product.php';</script>";
    } else {
        // Hiển thị thông báo lỗi bằng JavaScript
        echo "<script>alert('Lỗi khi xóa!'); window.location.href = 'product.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Mã sản phẩm không được xác định.'); window.location.href = 'product.php';</script>";
}
