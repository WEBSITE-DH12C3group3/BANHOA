<?php
require 'connect.php'; // Đảm bảo yêu cầu file chứa lớp Database

// Khởi tạo đối tượng Database
$db = new Database();

if (isset($_POST['btn-reg'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Kiểm tra xem tất cả các trường đều không rỗng
    if (!empty($fullname) && !empty($email) && !empty($password) && !empty($phone) && !empty($address)) {
        echo '<pre>';
        print_r($_POST);

        // Tạo truy vấn INSERT
        $sql = "INSERT INTO `users` (`fullname`, `email`, `password`, `phone`, `address`) VALUES('$fullname', '$email', '$password', '$phone', '$address') ";
        
        // Sử dụng phương thức insert của đối tượng Database
        if ($db->insert($sql)) {
            echo "Lưu dữ liệu thành công ";
            header("Location: /BANHOA/Front-end/Customer/dangnhap.php");
            exit(); // Dừng thực thi script sau khi chuyển hướng
        } else {
            echo "Lỗi: " . $db->conn->error; // Xử lý lỗi
        }
    } else {
        echo 'Nhập đầy đủ thông tin.';
    }
}
