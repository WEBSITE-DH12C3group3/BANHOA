<?php
if (isset($_GET['act']) && $_GET['act'] == 'logout') {
    session_unset();
    session_destroy();
    header('Location: /BANHOA/Front-end/Customer/dangnhap.php');
    exit();
}

// Kiểm tra đăng nhập và role *trước* khi chuyển hướng
if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
    // Đã đăng nhập với quyền admin, chuyển hướng đến trang admin
} else {
    // Chưa đăng nhập hoặc không phải admin, chuyển hướng đến trang đăng nhập
    header('Location: /BANHOA/Front-end/Customer/dangnhap.php');
    exit();
}
