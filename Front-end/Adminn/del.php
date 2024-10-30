<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
// Kiểm tra xem masv có tồn tại trong $_POST hay không
$masv = $_GET['id'];

if (isset($_GET['id'])) {
    // Thực hiện chuẩn bị câu lệnh SQL
    $del = "DELETE FROM users WHERE id = $id";
    mysqli_query($conn, $del);
    header("Location: /BANHOA/Front-end/Adminn/index.php");
} else {
    // Xử lý khi masv không được gửi
    echo "Mã sinh viên không được xác định.";
}
