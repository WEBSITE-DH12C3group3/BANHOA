<?php
session_start();
require '/xampp/htdocs/BANHOA/database/connect.php'; // Kết nối với cơ sở dữ liệu
$error = '';
    if (isset($_POST['btn-login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        // Sử dụng prepared statement để tránh SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? ");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        // Kiểm tra nếu có kết quả
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Lưu thông tin người dùng vào session
            if($password==$row['password']) {
                $_SESSION['users_id'] = $row['id'];
                $_SESSION['role'] = $row['role'];
                // Chuyển hướng đến giao diện khách hàng hoặc admin
                if ($row['role'] == 'admin') {
                    header("Location: http://localhost/BANHOA/Front-end/Adminn/index.php"); // Giao diện dành cho admin
                } else {
                    header("Location: http://localhost/BANHOA/Front-end/Customer/index.php"); // Giao diện dành cho khách hàng
                }
                exit();
            }
            else{
                $_SESSION['error'] ="Mật khẩu không chính xác, hãy thử lại!";
            }
        }
        else {
            $_SESSION['error'] = "Email không tồn tại, hãy thử lại!";
        }
        $stmt->close();
        $conn->close();
    }
header("Location: /BANHOA/Front-end/Customer/dangnhap.php");
exit();
?>
