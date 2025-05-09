<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $price = isset($_POST['price']) ? $_POST['price'] : '';
    $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : 0;
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $sale = isset($_POST['sale']) ? (int)$_POST['sale'] : 0;
    $remark = isset($_POST['remark']) ? $_POST['remark'] : '';

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

    $price = (float)$price;

    // Kiểm tra mô tả
    if (empty($description)) {
        echo "<script>alert('Mô tả không được để trống!'); window.location.href='product.php';</script>";
        exit();
    }

    // Kiểm tra danh mục
    if (empty($category_id) || (int)$category_id <= 0) {
        echo "<script>alert('Phải chọn danh mục sản phẩm hợp lệ!'); window.location.href='product.php';</script>";
        exit();
    }

    // Kiểm tra nổi bật
    if ($remark === '') {
        echo "<script>alert('Vui lòng chọn sản phẩm có nổi bật hay không!'); window.location.href='product.php';</script>";
        exit();
    }

    // Xử lý nếu có ảnh
    $hasImage = isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK;
    if ($hasImage) {
        $image = $_FILES['image']['name'];
        $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            echo "<script>alert('Định dạng ảnh không hợp lệ! Chỉ chấp nhận JPG, JPEG, PNG, GIF.'); window.location.href='product.php';</script>";
            exit();
        }

        $target_path = "../uploads/" . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            echo "<script>alert('Lỗi khi tải ảnh lên!'); window.location.href='product.php';</script>";
            error_log("Upload file failed: " . print_r($_FILES['image'], true));
            exit();
        }

        $sql = "UPDATE products SET product_name=?, image=?, description=?, price=?, sale=?, stock=?, category_id=?, remark=? WHERE id=?";
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param("sssdiisii", $name, $image, $description, $price, $sale, $stock, $category_id, $remark, $id);
    } else {
        $sql = "UPDATE products SET product_name=?, description=?, price=?, sale=?, stock=?, category_id=?, remark=? WHERE id=?";
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param("ssdiisii", $name, $description, $price, $sale, $stock, $category_id, $remark, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Sửa sản phẩm thành công!'); window.location.href='product.php';</script>";
    } else {
        $error = addslashes($stmt->error);
        echo "<script>alert('Lỗi khi sửa sản phẩm: $error'); window.location.href='product.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href='product.php';</script>";
}
