<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Kiểm tra nếu file ảnh được upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        // Đường dẫn lưu trữ

        $target_path = "../uploads/" . basename($image);

        // Di chuyển file ảnh
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $name = isset($_POST['product_name']) ? mysqli_real_escape_string($db->conn, $_POST['product_name']) : '';
            $description = isset($_POST['description']) ? mysqli_real_escape_string($db->conn, $_POST['description']) : '';
            $price = isset($_POST['price']) ? mysqli_real_escape_string($db->conn, $_POST['price']) : '';
            $stock = isset($_POST['stock']) ? mysqli_real_escape_string($db->conn, $_POST['stock']) : '';
            $category_id = isset($_POST['category_id']) ? mysqli_real_escape_string($db->conn, $_POST['category_id']) : '';

            if (empty($name) || empty($price) || empty($stock) || empty($category_id)) {
                echo "<script>alert('Vui lòng điền đầy đủ thông tin cần thiết!'); window.location.href = 'product.php';</script>";
                exit();
            }

            // Chuẩn bị câu lệnh SQL
            $stmt = $db->conn->prepare("INSERT INTO products (product_name, image, description, price, stock, category_id) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdis", $name, $image, $description, $price, $stock, $category_id);

            // Thực thi câu lệnh
            if ($stmt->execute()) {
                echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href = 'product.php';</script>";
            } else {
                echo "<script>alert('Lỗi khi thêm sản phẩm!'); window.location.href = 'product.php';</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Lỗi khi tải ảnh lên!'); window.location.href = 'product.php';</script>";
            error_log("Upload file failed: " . print_r($_FILES['image'], true)); // Ghi log chi tiết
        }
    } else {
        $error_code = $_FILES['image']['error'];
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                echo "<script>alert('File quá lớn! Vui lòng chọn file nhỏ hơn.'); window.location.href = 'product.php';</script>";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "<script>alert('Bạn chưa chọn file!'); window.location.href = 'product.php';</script>";
                break;
            default:
                echo "<script>alert('Lỗi không xác định: $error_code'); window.location.href = 'product.php';</script>";
                break;
        }
    }
} else {
    echo "<script>alert('Yêu cầu không hợp lệ!'); window.location.href = 'product.php';</script>";
}
