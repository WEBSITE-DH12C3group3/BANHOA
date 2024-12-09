<?php
include_once '/xampp/htdocs/BANHOA/database/sendmailreset.php';
include '../baidautot.php';

$db = new Database(); // $db không được sử dụng, có thể xóa
$mailer = new Mailer();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Kiểm tra định dạng email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Địa chỉ email không hợp lệ.";
        exit;
    }

    // Kiểm tra nội dung tin nhắn (có thể thêm kiểm tra độ dài, ký tự đặc biệt,...)
    if (empty($message)) {
        echo "Nội dung tin nhắn không được để trống.";
        exit;
    }

    $subject = "Phản hồi từ EDEN Shop";

    // Gửi email sử dụng Mailer class
    if ($mailer->sendMail($subject, $message, $email)) {
        echo "Phản hồi đã được gửi thành công!";
         // Redirect after success
        exit;
        // Xử lý lỗi chi tiết hơn, ví dụ: in ra lỗi từ Mailer class
    }
    echo "<script>alert('Phản hồi đã được gửi thành công!'); window.location.href = 'display_contact.php';</script>";
    exit;
}
?>