<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? mysqli_real_escape_string($db->conn, $_POST['id']) : '';
    $name = isset($_POST['product_name']) ? mysqli_real_escape_string($db->conn, $_POST['product_name']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($db->conn, $_POST['description']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($db->conn, $_POST['price']) : '';
    $stock = isset($_POST['stock']) ? mysqli_real_escape_string($db->conn, $_POST['stock']) : '';
    $category_id = isset($_POST['category_id']) ? mysqli_real_escape_string($db->conn, $_POST['category_id']) : '';


    if (empty($name) || empty($price) || empty($stock) || empty($category_id) || empty($id)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin cần thiết!'); window.location.href = 'product.php'; </script>";
        exit();
    }

    // Kiểm tra nếu có ảnh mới được upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK && is_array($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $target_path = "../uploads/" . basename($image);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $sql = "UPDATE products SET product_name=?, image=?, description=?, price=?, stock=?, category_id=? WHERE id=?";
            $stmt = $db->conn->prepare($sql);
            $stmt->bind_param("sssdisi", $name, $image, $description, $price, $stock, $category_id, $id);
        } else {
            echo "<script>alert('Lỗi khi tải ảnh lên!'); window.location.href = 'product.php'; </script>";
            error_log("Upload file failed: " . print_r($_FILES['image'], true));
            exit(); // Dừng xử lý nếu upload ảnh thất bại
        }
    } else { // Không có ảnh mới, giữ nguyên ảnh cũ
        $sql = "UPDATE products SET product_name=?, description=?, price=?, stock=?, category_id=? WHERE id=?";
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param("ssdisi", $name, $description, $price, $stock, $category_id, $id);
    }


    if ($stmt->execute()) {
        echo "<script>alert('Sửa sản phẩm thành công!'); window.location.href = 'product.php'; </script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi sửa sản phẩm: " . $error . "!'); window.location.href = 'product.php'; </script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href = 'product.php'; </script>";
}
