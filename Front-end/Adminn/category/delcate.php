<?php
ob_start(); // Rất quan trọng để tránh lỗi headers already sent
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Start a transaction to ensure both operations succeed or fail together
        $db->conn->begin_transaction();

        // Delete related products
        $deleteProductsStmt = $db->conn->prepare("DELETE FROM products WHERE category_id = ?");
        $deleteProductsStmt->bind_param("s", $id);
        if (!$deleteProductsStmt->execute()) {
            throw new Exception("Error deleting products: " . $deleteProductsStmt->error);
        }
        $deleteProductsStmt->close();

        // Delete the category
        $deleteCategoryStmt = $db->conn->prepare("DELETE FROM categories WHERE id = ?");
        $deleteCategoryStmt->bind_param("s", $id);
        if (!$deleteCategoryStmt->execute()) {
            throw new Exception("Error deleting category: " . $deleteCategoryStmt->error);
        }
        $deleteCategoryStmt->close();

        // Commit the transaction
        $db->conn->commit();
        header("Location: category.php?status=success&title=Thành công!&message=" . urlencode('Xóa danh mục thành công!'));
    } catch (Exception $e) {
        // Rollback the transaction if an error occurred
        $db->conn->rollback();
        header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi xóa: ' . $e->getMessage()));
    } finally {
        $db->conn->close();
    }
} else {
    header("Location: category.php?status=error&title=Lỗi!&message=" . urlencode('Mã danh mục không được xác định.'));
}
ob_end_flush(); // Đẩy buffer ra trình duyệt
