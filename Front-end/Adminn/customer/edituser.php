<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

function containsScript($input)
{
    return preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $input);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = trim($_POST['customerID'] ?? '');
    $name = trim($_POST['customerName'] ?? '');
    $email = trim($_POST['customerEmail'] ?? '');
    $phone = trim($_POST['customerPhone'] ?? '');
    $address = trim($_POST['customerAddress'] ?? '');
    $role = trim($_POST['role'] ?? '');

    // Kiểm tra rỗng
    if (empty($id) && empty($name) && empty($email) && empty($phone) && empty($address) && empty($role)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location.href = 'ctm.php';</script>";
        exit();
    }
    if (empty($name)) {
        echo "<script>alert('Tên khách hàng không được để trống!'); window.location.href = 'ctm.php';</script>";
        exit();
    }
    // Kiểm tra tên
    if (strlen($name) > 220) {
        echo "<script>alert('Tên quá dài, tối đa 220 ký tự!'); window.location.href = 'ctm.php';</script>";
        exit();
    }
    if (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $name)) {
        echo "<script>alert('Tên chỉ được chứa chữ cái, số và khoảng trắng!'); window.location.href = 'ctm.php';</script>";
        exit();
    }
    if (containsScript($name) || containsScript($address) || containsScript($email)) {
        echo "<script>alert('Dữ liệu không hợp lệ!'); window.location.href = 'ctm.php';</script>";
        exit();
    }

    // Kiểm tra email
    if (empty($email)) {
        echo "<script>alert('Email không được để trống!'); window.location.href = 'ctm.php';</script>";
        exit();
    }
    if (strlen($email) > 220) {
        echo "<script>alert('Email không được dài quá 220 ký tự!'); window.location.href = 'ctm.php';</script>";
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match('/[\sà-ỹÀ-Ỵ]|[^a-zA-Z0-9@._-]/u', $email)) {
        echo "<script>alert('Email sai định dạng!'); window.location.href = 'ctm.php';</script>";
        exit();
    }

    if (preg_match('/^\d/', $email)) {
        echo "<script>alert('Email không được bắt đầu bằng số!'); window.location.href = 'ctm.php';</script>";
        exit();
    }


    // Kiểm tra số điện thoại
    if (empty($phone)) {
        echo "<script>alert('Số điện thoại không được để trống!'); window.location.href = 'ctm.php';</script>";
        exit();
    }
    if (!preg_match('/^\d{10}$/', $phone)) {
        if (strlen($phone) !== 10) {
            echo "<script>alert('Số điện thoại phải 10 ký tự!'); window.location.href = 'ctm.php';</script>";
        } else {
            echo "<script>alert('Số điện thoại không hợp lệ!'); window.location.href = 'ctm.php';</script>";
        }
        exit();
    }

    // Kiểm tra địa chỉ
    if (empty($address)) {
        echo "<script>alert('Địa chỉ không được để trống!'); window.location.href = 'ctm.php';</script>";
        exit();
    }

    if (preg_match('/[#\$%\^&\*\(\)=\+\[\]\{\}@;:\'\"<>,\?\/\\\\|]/', $address)) {
        echo "<script>alert('Địa chỉ không được chứa ký tự đặc biệt!'); window.location.href = 'ctm.php';</script>";
        exit();
    }

    // An toàn trước SQL injection
    $name = mysqli_real_escape_string($db->conn, $name);
    $email = mysqli_real_escape_string($db->conn, $email);
    $phone = mysqli_real_escape_string($db->conn, $phone);
    $address = mysqli_real_escape_string($db->conn, $address);
    $role = mysqli_real_escape_string($db->conn, $role);
    $id = mysqli_real_escape_string($db->conn, $id);

    $stmt = $db->conn->prepare("UPDATE users SET fullname=?, email=?, phone=?, address=?, role=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $email, $phone, $address, $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href = 'ctm.php';</script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi cập nhật: $error'); window.location.href = 'ctm.php';</script>";
    }

    $stmt->close();
}
