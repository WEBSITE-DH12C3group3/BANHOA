<?php
session_start();
require '/xampp/htdocs/BANHOA/database/connect.php'; // Kết nối với cơ sở dữ liệu
$conn = new Database();

if (isset($_POST['resetpassword'])) {
    $email = trim($_POST['email']);
    $token = md5(rand());
    
    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email không hợp lệ, vui lòng thử lại!";
        header("Location: /BANHOA/Front-end/Customer/dangnhap.php");
        exit();
    }

    // Truy vấn thông tin người dùng từ bảng users
    $query = "SELECT id FROM users WHERE email = '$email'";
    $result = $conn->select($query);

    // Kiểm tra nếu có kết quả
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['users_id'] = $row['id'];
        $_SESSION['error'] = "Mã xác nhận đã được gửi đến email của bạn.";
        $uodate = " UPDATE users SET ";
        
    } else {
        $_SESSION['error'] = "Email chưa được đăng ký, hãy thử lại!";
    }
}

header("Location: /BANHOA/Front-end/Customer/forgotpassword.php");
exit();
?>
