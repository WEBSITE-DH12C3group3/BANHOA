<?php
session_start();
require 'connect.php'; // Kết nối với cơ sở dữ liệu
$conn = new Database();
$error = '';

if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Truy vấn thông tin người dùng từ bảng users
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->select($query);

    // Kiểm tra nếu có kết quả
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $row['password'])) {
            // Mật khẩu chính xác, tiến hành xác thực người dùng (ví dụ: lưu thông tin vào session, cookie, ...)
            // Lưu thông tin người dùng vào session
            $_SESSION['user_logged_in'] = true;
            $_SESSION['users_id'] = $row['id'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['fullname'] = $row['fullname'];
            $_SESSION['email'] = $row['email'];
            // Chuyển hướng đến giao diện khách hàng hoặc admin
            if (isset($_SESSION['cart']) && $_SESSION['cart'] != null) {
                header("Location: ../Front-end/Customer/cart.php"); // Giao diện dành cho khách hàng
                exit();
            }
            header("Location: ../Front-end/Customer/index.php"); // Giao diện dành cho khách hàng
            exit();
        } else {
            $_SESSION['error'] = "Mật khẩu không chính xác, hãy thử lại!";
        }
    } else {
        $_SESSION['error'] = "Email không tồn tại, hãy thử lại!";
    }
}

header("Location: ../Front-end/Customer/dangnhap.php");
exit();
