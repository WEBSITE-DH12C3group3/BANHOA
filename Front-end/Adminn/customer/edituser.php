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
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Vui lòng điền đầy đủ thông tin!'));
        exit();
    }
    if (empty($name)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Tên khách hàng không được để trống!'));
        exit();
    }
    // Kiểm tra tên
    if (strlen($name) > 220) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Tên quá dài, tối đa 220 ký tự!'));
        exit();
    }
    if (!preg_match("/^[a-zA-ZÀ-ỹ\s]+$/u", $name)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Tên chỉ được chứa chữ cái, số và khoảng trắng!'));
        exit();
    }
    if (containsScript($name) || containsScript($address) || containsScript($email)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Dữ liệu không hợp lệ!'));
        exit();
    }

    // Kiểm tra email
    if (empty($email)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Email không được để trống!'));
        exit();
    }
    if (strlen($email) > 220) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Email không được dài quá 220 ký tự!'));
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || preg_match('/[\sà-ỹÀ-Ỵ]|[^a-zA-Z0-9@._-]/u', $email)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Email sai định dạng!'));
        exit();
    }

    if (preg_match('/^\d/', $email)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Email không được bắt đầu bằng số!'));
        exit();
    }


    // Kiểm tra số điện thoại
    if (empty($phone)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Số điện thoại không được để trống!'));
        exit();
    }
    if (!preg_match('/^\d{10}$/', $phone)) {
        if (strlen($phone) !== 10) {
            header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Số điện thoại phải 10 ký tự!'));
        } else {
            header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Số điện thoại không hợp lệ!'));
        }
        exit();
    }

    // Kiểm tra địa chỉ
    if (empty($address)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Địa chỉ không được để trống!'));
        exit();
    }

    if (preg_match('/[#\$%\^&\*\(\)=\+\[\]\{\}@;:\'\"<>,\?\/\\\\|]/', $address)) {
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Địa chỉ không được chứa ký tự đặc biệt!'));
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
        header("Location: ctm.php?status=success&title=Thành công!&message=" . urlencode('Cập nhật thành công!'));
        exit();
    } else {
        $error = $stmt->error;
        header("Location: ctm.php?status=error&title=Lỗi!&message=" . urlencode('Lỗi khi cập nhật: ' . $error));
        exit();
    }

    $stmt->close();
}
