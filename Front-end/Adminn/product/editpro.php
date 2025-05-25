<?php
ob_start(); // Thêm ob_start() để tránh lỗi header already sent
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

function containsScript($input)
{
    return preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $stock = isset($_POST['stock']) ? trim($_POST['stock']) : '';
    $category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';
    $sale = isset($_POST['sale']) ? trim($_POST['sale']) : '';
    $remark = isset($_POST['remark']) ? (int)$_POST['remark'] : 0; // Đảm bảo remark là số nguyên, 0 nếu không có

    // Kiểm tra mã script
    if (containsScript($name) || containsScript($description) || containsScript($price)) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Dữ liệu không hợp lệ!'));
        exit();
    }

    // Kiểm tra tên sản phẩm
    if (empty($name)) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Tên sản phẩm không được để trống!'));
        exit();
    } elseif (strlen($name) > 220) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Tên sản phẩm quá dài, tối đa 220 ký tự!'));
        exit();
    } elseif (preg_match('/[^a-zA-Z0-9\s]/', $name)) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Tên sản phẩm chỉ được chứa chữ cái, số và khoảng trắng!'));
        exit();
    }
    $check_sql = "SELECT COUNT(*) as count FROM products WHERE product_name = ? AND id != ?";
    $st = $db->conn->prepare($check_sql);
    $st->bind_param("si", $name, $id);
    $st->execute();
    $result = $st->get_result();
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Tên sản phẩm đã tồn tại!'));
        $st->close();
        exit();
    }

    // Kiểm tra giá
    if (empty($price)) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Giá không được để trống!'));
        exit();
    }
    if (!is_numeric($price) || $price <= 0) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Giá phải là số dương!'));
        exit();
    }
    if ($price > 100000000) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Giá không được lớn hơn 100 triệu đồng!'));
        exit();
    }
    $price = (float)$price;

    // Kiểm tra mô tả
    if (empty($description)) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Mô tả không được để trống!'));
        exit();
    } elseif (strlen($description) > 220) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Mô tả quá dài, tối đa 220 ký tự!'));
        exit();
    }

    // Kiểm tra số lượng tồn kho
    if (empty($stock) && $stock !== "0") {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Số lượng không được để trống!'));
        exit();
    }
    if (!is_numeric($stock) || $stock < 0) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Số lượng tồn kho phải là số không âm!'));
        exit();
    }
    $stock = (int)$stock;

    // Kiểm tra giảm giá
    if (empty($sale) && $sale !== "0") {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Giảm giá không được để trống!'));
        exit();
    }
    if (!is_numeric($sale) || $sale < 0 || $sale > 100) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Giảm giá phải là số từ 0 đến 100!'));
        exit();
    }
    $sale = (int)$sale;

    // Kiểm tra danh mục
    if (empty($category_id)) {
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục không được để trống!'));
        exit();
    }

    $image = $_FILES['image']['name'];
    $file_tmp = $_FILES['image']['tmp_name'];

    if (!empty($image)) {
        $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Định dạng ảnh không hợp lệ!'));
            exit();
        }

        $target_path = "../uploads/" . basename($image);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            error_log("Upload file failed: " . print_r($_FILES['image'], true));
            header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi tải ảnh lên!'));
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
        header("Location: product.php?status=success&title=Thành công!&message=" . urlencode('Sửa sản phẩm thành công!'));
    } else {
        $error = addslashes($stmt->error);
        header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi sửa sản phẩm: ' . $error));
    }
    $stmt->close();
    $db->conn->close();
} else {
    header("Location: product.php?status=error&title=Lỗi!&message=" . urlencode('Yêu cầu không hợp lệ!'));
    exit();
}
ob_end_flush(); // Đẩy buffer ra trình duyệt
