<?php
session_start();
include '/xampp/htdocs/BANHOA/database/connect.php'; // Đường dẫn đến file Database.php
$db = new Database();

// Kiểm tra nếu form được gửi qua phương thức POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateuser'])) {
    // Lấy user_id từ session
    $user_id = $_SESSION['users_id'];
    
    // Lấy dữ liệu từ form và xử lý an toàn
    $fullname = $db->conn->real_escape_string($_POST['fullname']);
    $email = $db->conn->real_escape_string($_POST['email']);
    $phone = $db->conn->real_escape_string($_POST['phone']);
    $address = $db->conn->real_escape_string($_POST['address']);

    // Câu lệnh SQL để cập nhật thông tin người dùng
    $query = "UPDATE users SET fullname='$fullname', email='$email', phone='$phone', address='$address' WHERE id = $user_id";

    // Thực thi câu lệnh cập nhật
    $update = $db->update($query);

    // Kiểm tra kết quả
    if ($update) {
        // Cập nhật thành công, chuyển hướng về trang cá nhân với thông báo thành công
        header("Location: /BANHOA/Front-end/Customer/trangcanhan.php?status=success");
        exit();
    } else {
        echo "Cập nhật thông tin thất bại.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
?>
