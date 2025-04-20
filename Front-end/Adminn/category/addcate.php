<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
    $name = isset($_POST['Name']) ? trim($_POST['Name']) : '';

    // RÀNG BUỘC DỮ LIỆU
    if (empty($id)) {
        echo "<script>alert('Mã danh mục không được để trống!'); window.location.href='category.php';</script>";
        exit();
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $id)) {
        echo "<script>alert('Mã danh mục chỉ được chứa chữ và số, không có ký tự đặc biệt!'); window.location.href='category.php';</script>";
        exit();
    }

    if (empty($name)) {
        echo "<script>alert('Tên danh mục không được để trống!'); window.location.href='category.php';</script>";
        exit();
    } elseif (strlen($name) > 29) {
        echo "<script>alert('Tên danh mục quá dài, tối đa 29 ký tự!'); window.location.href='category.php';</script>";
        exit();
    }

    // CHÈN DỮ LIỆU
    $id = mysqli_real_escape_string($db->conn, $id);
    $name = mysqli_real_escape_string($db->conn, $name);

    $stmt = $db->conn->prepare("INSERT INTO categories (id, category_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $id, $name);

    if ($stmt->execute()) {
        echo "<script>alert('Thêm danh mục thành công!'); window.location.href = 'category.php';</script>";
    } else {
        $error = addslashes($stmt->error);
        echo "<script>alert('Lỗi khi thêm danh mục: $error'); window.location.href = 'category.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href = 'category.php';</script>";
}
