<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? mysqli_real_escape_string($db->conn, $_POST['id']) : '';
    $productName = isset($_POST['product_name']) ? mysqli_real_escape_string($db->conn, $_POST['product_name']) : '';
    $image = isset($_POST['image']) ? mysqli_real_escape_string($db->conn, $_POST['image']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($db->conn, $_POST['description']) : '';
    $price = isset($_POST['price']) ? mysqli_real_escape_string($db->conn, $_POST['price']) : '';
    $stock = isset($_POST['stock']) ? mysqli_real_escape_string($db->conn, $_POST['stock']) : '';
    $categoryID = isset($_POST['category_id']) ? mysqli_real_escape_string($db->conn, $_POST['category_id']) : '';

    if (empty($id) || empty($productName) || empty($price) || empty($stock) || empty($categoryID)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin cần thiết!'); window.location.href = 'product.php';</script>";
        exit();
    }

    $stmt = $db->conn->prepare("UPDATE products SET product_name=?, image=?, description=?, price=?, stock=?, category_id=? WHERE id=?");
    $stmt->bind_param("sssdisi", $productName, $image, $description, $price, $stock, $categoryID, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href = 'product.php';</script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi cập nhật: ' + '$error'); window.location.href = 'product.php';</script>";
    }

    $stmt->close();
}
