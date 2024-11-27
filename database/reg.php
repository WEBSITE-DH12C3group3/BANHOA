<?php
require 'connect.php'; // Đảm bảo yêu cầu file chứa lớp Database

// Khởi tạo đối tượng Database
$db = new Database();

if (isset($_POST['btn-reg'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $password = $_POST['password'];
    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    // Kiểm tra xem tất cả các trường đều không rỗng
    if (!empty($fullname) && !empty($email) && !empty($hash_password) && !empty($phone) && !empty($address)) {
        // Kiểm tra email trước khi thêm
        $stmt = $db->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Hiển thị alert và quay lại trang đăng ký
            echo "<script>
                    alert('Email đã tồn tại!');
                    window.location.href = '/BANHOA/Front-end/Customer/dangky.php';
                  </script>";
            exit;
        }

        // Tạo truy vấn INSERT
        $sql = "INSERT INTO `users` (`fullname`, `email`, `password`, `phone`, `address`) VALUES('$fullname', '$email', '$hash_password', '$phone', '$address')";

        // Sử dụng phương thức insert của đối tượng Database
        if ($db->insert($sql)) {
            // Hiển thị thông báo đăng ký thành công và chuyển hướng
            echo "<script>
                    alert('Đăng ký thành công!');
                    window.location.href = '/BANHOA/Front-end/Customer/dangnhap.php';
                  </script>";
            exit; // Dừng thực thi script sau khi chuyển hướng
        } else {
            echo "<script>
                    alert('Lỗi khi thêm dữ liệu vào cơ sở dữ liệu!');
                    window.location.href = '/BANHOA/Front-end/Customer/dangky.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Vui lòng nhập đầy đủ thông tin!');
                window.location.href = '/BANHOA/Front-end/Customer/dangky.php';
              </script>";
    }
}
