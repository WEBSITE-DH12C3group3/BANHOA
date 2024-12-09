<?php
include '../baidautot.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $contact_id = $_POST['contact_id'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Ví dụ gửi email phản hồi
    $subject = "Phản hồi từ EDEN Shop";
    $headers = "From: admin@edenshop.com";
    if (mail($email, $subject, $message, $headers)) {
        echo "Phản hồi đã được gửi thành công!";
    } else {
        echo "Gửi phản hồi thất bại!";
    }
}
?>
