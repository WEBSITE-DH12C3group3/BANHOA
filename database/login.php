<?php
session_start();
require 'connect.php';
$conn = new Database();
$error = '';

if (isset($_POST['btn-login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    // Tách phần trước @
    $localPart = substr($email, 0, strpos($email, '@'));

    if (empty($email) && empty($password)) {
        $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin";
    } else {
        $email = trim($email);
        $password = trim($password);
        $localPart = substr($email, 0, strpos($email, '@'));
        $forbiddenCharsPattern = '/[#\$%\^&\*\(\)=\+\[\]\{\};:\'\"<>,\?\/\\\\|]/'; // dùng regex

        if (empty($email) && empty($password)) {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin";
        } elseif (empty($email)) {
            $_SESSION['error'] = "Email không được để trống";
        } elseif ($email !== strip_tags($email)) {
            $_SESSION['error'] = "Email không hợp lệ (chứa mã script)";
        } elseif (strlen($email) > 220) {
            $_SESSION['error'] = "Email quá dài (tối đa 220 ký tự)";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match($forbiddenCharsPattern, $localPart) || !preg_match('/^[\x20-\x7E]+$/', $localPart)) {
            $_SESSION['error'] = "Email sai định dạng";
        } elseif (ctype_digit($localPart)) {
            $_SESSION['error'] = "Email không được là chuỗi số hoàn toàn trước dấu @";
        } elseif (is_numeric($localPart[0])) {
            $_SESSION['error'] = "Email không được bắt đầu bằng số";
        } elseif (empty($password)) {
            $_SESSION['error'] = "Mật khẩu không được để trống";
        } elseif (strlen($password) < 6 || strlen($password) > 20) {
            $_SESSION['error'] = "Mật khẩu phải từ 6 đến 20 ký tự";
        }


        if (!isset($_SESSION['error'])) {
            // Truy vấn người dùng
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = $conn->select($query);

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_logged_in'] = true;
                    $_SESSION['users_id'] = $row['id'];
                    $_SESSION['role'] = $row['role'];
                    $_SESSION['fullname'] = $row['fullname'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['success'] = "Đăng nhập thành công! Chào mừng bạn, " . $row['fullname'];

                    if (isset($_SESSION['cart']) && $_SESSION['cart'] != null) {
                        header("Location: ../Front-end/Customer/cart.php");
                        exit();
                    }
                    header("Location: ../Front-end/Customer/index.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Email hoặc mật khẩu không đúng";
                }
            } else {
                $_SESSION['error'] = "Email chưa được đăng ký";
            }
        }

        // Quay lại trang đăng nhập nếu có lỗi
        header("Location: ../Front-end/Customer/dangnhap.php");
        exit();
    }
}
