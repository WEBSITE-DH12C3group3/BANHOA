<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['cateid']) ? mysqli_real_escape_string($db->conn, $_POST['cateid']) : '';
    $name = isset($_POST['catename']) ? mysqli_real_escape_string($db->conn, $_POST['catename']) : '';

    if (empty($id) || empty($name)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location.href = 'category.php';</script>";
        exit();
    }

    $stmt = $db->conn->prepare("UPDATE categories SET category_name=? WHERE id=?");
    $stmt->bind_param("ss", $name, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href = 'category.php';</script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi cập nhật: ' + '$error'); window.location.href = 'category.php';</script>";
    }

    $stmt->close();
}
