<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['cateid']) ? trim($_POST['cateid']) : '';
    $name = isset($_POST['catename']) ? trim($_POST['catename']) : '';
    $forbiddenCharsPattern = '/[#\$%\^&\*\(\)=\+\[\]\{\};:\'\"<>,\?\/\\\\|]/'; // dùng regex

    // RÀNG BUỘC DỮ LIỆU
    if (empty($id)) {
        echo "<script>alert('Mã danh mục không được để trống!'); window.location.href = 'category.php';</script>";
        exit();
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $id)) {
        echo "<script>alert('Mã danh mục chỉ được chứa chữ và số, không có ký tự đặc biệt!'); window.location.href='category.php';</script>";
        exit();
    }
    if (empty($name)) {
        echo "<script>alert('Tên danh mục không được để trống!'); window.location.href = 'category.php';</script>";
        exit();
    } elseif (strlen($name) > 29) {
        echo "<script>alert('Tên danh mục quá dài, tối đa 29 ký tự!'); window.location.href = 'category.php';</script>";
        exit();
    } elseif (preg_match($forbiddenCharsPattern, $name)) {
        echo "<script>alert('Tên danh mục không được chứa ký tự đặc biệt!'); window.location.href = 'category.php';</script>";
        exit();
    }

    $stmt = $db->conn->prepare("UPDATE categories SET category_name=? WHERE id=?");
    $stmt->bind_param("ss", $name, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật danh mục thành công!'); window.location.href = 'category.php';</script>";
    } else {
        $error = addslashes($stmt->error);
        echo "<script>alert('Lỗi khi cập nhật: $error'); window.location.href = 'category.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href = 'category.php';</script>";
}
