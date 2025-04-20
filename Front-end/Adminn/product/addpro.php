<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $stock = isset($_POST['stock']) ? trim($_POST['stock']) : '';
    $category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';
    $sale = isset($_POST['sale']) ? trim($_POST['sale']) : '';
    $remark = isset($_POST['remark']) ? trim($_POST['remark']) : '';

    // Kiểm tra tên sản phẩm
    if (empty($name)) {
        echo "<script>alert('Tên sản phẩm không được để trống!'); window.location.href='product.php';</script>";
        exit();
    } elseif (strlen($name) > 220) {
        echo "<script>alert('Tên quá dài, tối đa 220 ký tự!'); window.location.href='product.php';</script>";
        exit();
    } elseif (!preg_match('/^[\p{L}\p{N} ]+$/u', $name)) {
        echo "<script>alert('Tên chỉ được chứa chữ cái, số và khoảng trắng!'); window.location.href='product.php';</script>";
        exit();
    }

    // Kiểm tra giá
    if (empty($price)) {
        echo "<script>alert('Giá không được để trống!'); window.location.href='product.php';</script>";
        exit();
    } elseif (!is_numeric($price)) {
        echo "<script>alert('Giá phải là số hợp lệ!'); window.location.href='product.php';</script>";
        exit();
    } elseif ((float)$price <= 0) {
        echo "<script>alert('Giá sản phẩm phải lớn hơn 0!'); window.location.href='product.php';</script>";
        exit();
    }

    // Kiểm tra mô tả
    if (empty($description)) {
        echo "<script>alert('Mô tả không được để trống!'); window.location.href='product.php';</script>";
        exit();
    }

    // Kiểm tra danh mục
    if (empty($category_id)) {
        echo "<script>alert('Phải chọn danh mục sản phẩm!'); window.location.href='product.php';</script>";
        exit();
    }

    // Kiểm tra nổi bật
    if ($remark === '') {
        echo "<script>alert('Vui lòng chọn sản phẩm có nổi bật hay không!'); window.location.href='product.php';</script>";
        exit();
    }

    // Kiểm tra ảnh
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        echo "<script>alert('Phải chọn ảnh sản phẩm!'); window.location.href='product.php';</script>";
        exit();
    }

    $image = $_FILES['image']['name'];
    $file_type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_type, $allowed_types)) {
        echo "<script>alert('Định dạng ảnh không hợp lệ!'); window.location.href='product.php';</script>";
        exit();
    }

    // Upload ảnh
    $target_path = "../uploads/" . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
        // Chuẩn bị thêm dữ liệu
        $stmt = $db->conn->prepare("INSERT INTO products (product_name, image, description, price, sale, stock, category_id, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiisi", $name, $image, $description, $price, $sale, $stock, $category_id, $remark);

        if ($stmt->execute()) {
            if ($remark == 1) {
                echo "<script>alert('Thêm sản phẩm thành công và được gắn cờ nổi bật!'); window.location.href='product.php';</script>";
            } else {
                echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href='product.php';</script>";
            }
        } else {
            echo "<script>alert('Lỗi khi thêm sản phẩm!'); window.location.href='product.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Lỗi khi tải ảnh lên!'); window.location.href='product.php';</script>";
    }
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href='product.php';</script>";
}
