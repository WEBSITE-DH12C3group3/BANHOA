<?php
require '/BANHOA/database/connect.php';
// echo "<pre>";
// print_r($_POST);
if (isset($_POST['btn-reg'])) {
    $fullname = $_POST['fullname'];
    $user = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    if (!empty($fullname) && !empty($user) && !empty($email) && !empty($password) && !empty($phone) && !empty($address)) {

        echo '<pre>';
        print_r($_POST);

        $sql = "INSERT INTO `users` (`fullname`, `user`, `email`, `password`, `phone`, `address`) VALUES('$fullname', '$user', '$email', '$password', '$phone', '$address') ";
        if ($conn->query($sql) === TRUE) {
            echo "lưu dữ liệu thành công ";
            header("Location: /BANHOA/Front-end/Customer/dangnhap.php ");
        } else {
            echo "Lỗi" . $conn->error;
        };
    } else {
        echo 'nhap het thong tin vao';
    }
}
