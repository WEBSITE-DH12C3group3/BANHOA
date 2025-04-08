<?php
session_start();
require 'connect.php';

$db = new Database();

function contains_script_or_tags($input)
{
    return $input !== strip_tags($input);
}

if (isset($_POST['btn-reg'])) {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // ❗ Xử lý XSS
    if (contains_script_or_tags($fullname) || contains_script_or_tags($email) || contains_script_or_tags($address)) {
        $_SESSION['error'] = "Dữ liệu không hợp lệ!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }
    if (empty($password) || empty($confirmPassword) || empty($phone) || empty($address)) {
        if (empty($password)) {
            $_SESSION['error'] = "Vui lòng nhập mật khẩu!";
        } elseif (empty($phone)) {
            $_SESSION['error'] = "Số điện thoại không được để trống!";
        } elseif (empty($address)) {
            $_SESSION['error'] = "Địa chỉ không được để trống!";
        } elseif (empty($confirmPassword)) {
            $_SESSION['error'] = "Vui lòng nhập lại mật khẩu!";
        } else {
            $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
        }
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }
    if (empty($fullname)) {
        $_SESSION['error'] = "Họ và tên không được để trống!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }
    if (empty($email)) {
        $_SESSION['error'] = "Email không được để trống!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }

    if (strlen($fullname) > 220) {
        $_SESSION['error'] = "Họ và tên quá dài, tối đa 220 ký tự!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email sai định dạng!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Mật khẩu không khớp!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }

    if (strlen($password) < 6 || strlen($password) > 20) {
        $_SESSION['error'] = "Mật khẩu phải từ 6 đến 20 ký tự!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }

    if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
        $_SESSION['error'] = "Số điện thoại không hợp lệ!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }
    if (!(strlen($phone) == 10)) {
        $_SESSION['error'] = "Số điện thoại phải 10 ký tự!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }


    // Kiểm tra email đã tồn tại
    $stmt = $db->conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email đã tồn tại!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }

    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (fullname, email, password, phone, address) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->conn->prepare($sql);
    $stmt->bind_param("sssss", $fullname, $email, $hash_password, $phone, $address);

    if ($stmt->execute()) {
        echo "<script>
                    alert('Đăng ký thành công!');
                    window.location.href = '../Front-end/Customer/dangnhap.php';
                  </script>";
        exit; // Dừng thực thi script sau khi chuyển hướng
    } else {
        $_SESSION['error'] = "Lỗi khi thêm dữ liệu vào cơ sở dữ liệu!";
        header("Location: ../Front-end/Customer/dangky.php");
        exit;
    }
}
