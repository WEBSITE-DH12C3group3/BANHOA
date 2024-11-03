<?php
function checkuser($user, $pass)
{
    $conn = connectdb();
    // Sử dụng truy vấn đã chuẩn bị để tránh SQL Injection
    $stmt = $conn->prepare("SELECT role FROM tbl_user WHERE user = :user AND pass = :pass");
    $stmt->bindParam(':user', $user);
    $stmt->bindParam(':pass', $pass);
    $stmt->execute();
    // Lấy kết quả truy vấn
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    // Kiểm tra xem dữ liệu người dùng có tồn tại hay không
    if ($userData) {
        return $userData['role'];
    } else {
        return null; // Trả về null nếu tài khoản hoặc mật khẩu không đúng
    }
}
