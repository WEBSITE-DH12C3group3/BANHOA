<?php
ob_start(); // Rất quan trọng để tránh lỗi headers already sent
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['cateid']) ? trim($_POST['cateid']) : '';
    $name = isset($_POST['catename']) ? trim($_POST['catename']) : '';
    $forbiddenCharsPattern = '/[#\$%\^&\*\(\)=\+\[\]\{\};:\'\"<>,\?\/\\\\|]/'; // dùng regex

    // RÀNG BUỘC DỮ LIỆU
    if (empty($id)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục không được để trống!'));
        exit();
    } elseif (!preg_match('/^[A-Za-z0-9]+$/', $id)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục chỉ được chứa chữ và số, không có ký tự đặc biệt!'));
        exit();
    }
    if (empty($name)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục không được để trống!'));
        exit();
    } elseif (strlen($name) > 29) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục quá dài, tối đa 29 ký tự!'));
        exit();
    } elseif (preg_match($forbiddenCharsPattern, $name)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục không được chứa ký tự đặc biệt!'));
        exit();
    }
    $check_sql = "SELECT COUNT(*) as count FROM categories WHERE category_name = ? AND id != ?";
    $st = $db->conn->prepare($check_sql);
    $st->bind_param("ss", $name, $id);
    $st->execute();
    $result = $st->get_result();
    $row = $result->fetch_assoc();
    $st = $db->conn->prepare("INSERT INTO categories (id, category_name) VALUES (?, ?)");
    $st->bind_param("ss", $id, $name);
    if ($row['count'] > 0) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục đã tồn tại!'));
        $st->close();
        exit();
    }
    $stmt = $db->conn->prepare("UPDATE categories SET category_name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id); // Sửa 'ss' thành 'si' nếu id là số nguyên

    if ($stmt->execute()) {
        header("Location: category.php?status=success&title=Thành công!&message=" . urlencode('Cập nhật danh mục thành công!'));
    } else {
        $error = addslashes($stmt->error);
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi cập nhật: ' . $error));
    }
    $stmt->close();
    $db->conn->close();
} else {
    header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Yêu cầu không hợp lệ!'));
    exit();
}
ob_end_flush(); // Đẩy buffer ra trình duyệt
