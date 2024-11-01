<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['ID']) ? mysqli_real_escape_string($db->conn, $_POST['ID']) : '';
    $name = isset($_POST['Name']) ? mysqli_real_escape_string($db->conn, $_POST['Name']) : '';

    if (empty($id) || empty($name)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location.href = 'category.php';</script>";
        exit();
    }

    $stmt = $db->conn->prepare("UPDATE categories SET category_name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href = 'category.php';</script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi cập nhật: ' + '$error'); window.location.href = 'category.php';</script>";
    }

    $stmt->close();
}
