<?php
// Bắt đầu session
session_start();

// Hủy toàn bộ session
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc trang chủ
header("Location: /BANHOA/Front-end/Customer/index.php");
exit();
?>
