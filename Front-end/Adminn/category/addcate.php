<?php
ob_start(); // Rất quan trọng để tránh lỗi headers already sent
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
    $name = isset($_POST['Name']) ? trim($_POST['Name']) : '';

    // --- VALIDATION CHO MÃ DANH MỤC ---
    if (empty($id)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục không được để trống!'));
        exit();
    }
    if (strpos($id, ' ') !== false) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục không được chứa khoảng trắng!'));
        exit();
    }
    if (!preg_match('/^[A-Za-z0-9]+$/', $id)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục chỉ được chứa chữ cái và số, không có ký tự đặc biệt hay khoảng trắng!'));
        exit();
    }
    if (!preg_match('/[A-Za-z]/', $id) || !preg_match('/[0-9]/', $id)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục phải bao gồm ít nhất một chữ cái và một số!'));
        exit();
    }

    // Kiểm tra mã danh mục đã tồn tại
    $checkStmt = $db->conn->prepare("SELECT id FROM categories WHERE id = ?");
    $checkStmt->bind_param("s", $id);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục đã tồn tại!'));
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();

    // --- VALIDATION CHO TÊN DANH MỤC ---
    if (empty($name)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục không được để trống!'));
        exit();
    }
    if (preg_match('/^\\s+$/', $name) || !preg_match('/[a-zA-ZÀ-ỹ0-9]/u', $name)) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục sai định dạng!'));
        exit();
    }
    if (strlen($name) > 29) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục quá dài, tối đa 29 ký tự!'));
        exit();
    }
    $check_sql = "SELECT COUNT(*) as count FROM categories WHERE category_name = ? AND id != ?";
    $st = $db->conn->prepare($check_sql);
    $st->bind_param("ss", $name, $id);
    $st->execute();
    $result = $st->get_result();
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Tên danh mục đã tồn tại!'));
        $st->close();
        exit();
    }

    $stmt = $db->conn->prepare("INSERT INTO categories (id, category_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $id, $name);
    if ($stmt->execute()) {
        header("Location: category.php?status=success&title=Thành công!&message=" . urlencode('Thêm danh mục thành công!'));
    } else {
        $error = addslashes($stmt->error);
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi thêm danh mục: ' . $error));
    }
    $stmt->close();
    $db->conn->close();
} else {
    header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Yêu cầu không hợp lệ!'));
    exit();
}
ob_end_flush(); // Đẩy buffer ra trình duyệt
