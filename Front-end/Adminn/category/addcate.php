<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['ID']) ? mysqli_real_escape_string($db->conn, $_POST['ID']) : '';
    $name = isset($_POST['Name']) ? mysqli_real_escape_string($db->conn, $_POST['Name']) : '';
    $stmt = $db->conn->prepare("INSERT INTO categories (id, category_name) VALUES (?,?)");
    $stmt->bind_param("ss", $id, $name);

    if ($stmt->execute()) {
        echo "<script>alert('Thêm danh mục thành công!'); window.location.href = 'category.php';</script>";
    } else {
        echo "<script>alert('Lỗi khi xóa danh mục!'); window.location.href = 'category.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href = 'category.php';</script>";
}
