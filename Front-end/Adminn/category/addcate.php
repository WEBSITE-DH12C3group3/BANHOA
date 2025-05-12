<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['ID']) ? trim($_POST['ID']) : '';
    $name = isset($_POST['Name']) ? trim($_POST['Name']) : '';

    // --- VALIDATION CHO MÃ DANH MỤC ---
    if (empty($id)) {
        echo "<script>alert('Mã danh mục không được để trống!'); window.location.href='category.php';</script>";
        exit();
    }
    if (strpos($id, ' ') !== false) {
        echo "<script>alert('Mã danh mục không được chứa khoảng trắng!'); window.location.href='category.php';</script>";
        exit();
    }
    if (!preg_match('/^[A-Za-z0-9]+$/', $id)) {
        echo "<script>alert('Mã danh mục chỉ được chứa chữ cái và số, không có ký tự đặc biệt hay khoảng trắng!'); window.location.href='category.php';</script>";
        exit();
    }
    if (!preg_match('/[A-Za-z]/', $id) || !preg_match('/[0-9]/', $id)) {
        echo "<script>alert('Mã danh mục phải bao gồm ít nhất một chữ cái và một số!'); window.location.href='category.php';</script>";
        exit();
    }

    if (is_numeric($id[0])) {
        echo "<script>alert('Mã danh mục không được bắt đầu bằng số!'); window.location.href='category.php';</script>";
        exit();
    }
    if (strlen($id) > 29) {
        echo "<script>alert('Mã danh mục quá dài, tối đa 29 ký tự!'); window.location.href='category.php';</script>";
        exit();
    }

    // Kiểm tra trùng mã danh mục
    $checkStmt = $db->conn->prepare("SELECT id FROM categories WHERE id = ?");
    $checkStmt->bind_param("s", $id);
    $checkStmt->execute();
    $checkStmt->store_result();
    if ($checkStmt->num_rows > 0) {
        echo "<script>alert('Mã danh mục đã tồn tại!'); window.location.href='category.php';</script>";
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();

    // --- VALIDATION CHO TÊN DANH MỤC ---
    if (empty($name)) {
        echo "<script>alert('Tên danh mục không được để trống!'); window.location.href='category.php';</script>";
        exit();
    }
    if (preg_match('/^\s+$/', $name) || !preg_match('/[a-zA-ZÀ-ỹ0-9]/u', $name)) {
        echo "<script>alert('Tên danh mục sai định dạng!'); window.location.href='category.php';</script>";
        exit();
    }
    if (strlen($name) > 29) {
        echo "<script>alert('Tên danh mục quá dài, tối đa 29 ký tự!'); window.location.href='category.php';</script>";
        exit();
    }

    // --- CHÈN DỮ LIỆU ---
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
