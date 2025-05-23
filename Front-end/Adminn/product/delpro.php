<?php
ob_start(); // Thêm ob_start() để tránh lỗi header already sent
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use parameterized query to prevent SQL injection
    $stmt = $db->conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id); // 'i' specifies that $id is an integer

    if ($stmt->execute()) {
        header("Location: product.php?status=success&title=Thành công!&message=" . urlencode('Xóa sản phẩm thành công!'));
    } else {
        $error = addslashes($stmt->error);
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi xóa sản phẩm: ' . $error));
    }
    $stmt->close();
} else {
    header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Mã sản phẩm không được xác định.'));
}
$db->conn->close();
ob_end_flush(); // Đẩy buffer ra trình duyệt
