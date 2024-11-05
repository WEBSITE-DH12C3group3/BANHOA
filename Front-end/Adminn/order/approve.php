<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

// Kiểm tra xem ID sinh viên có tồn tại trong GET hay không
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $db->conn->prepare("UPDATE orders SET status='Đã duyệt' WHERE id=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Duyệt thành công!'); window.location.href = 'order.php';</script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi duyệt: ' + '$error'); window.location.href = 'order.php';</script>";
    }

    $stmt->close();
}
