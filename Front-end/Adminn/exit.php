<?php
if (isset($_SESSION['role']) && ($_SESSION['role'] == "admin")) {
    if (isset($_GET['act'])) {
        switch ($_GET['act']) {
            case 'logout':
                session_unset(); // Xóa tất cả biến session
                session_destroy(); // Hủy session hiện tại
                header('Location: /BANHOA/database/login.php?message=Đăng xuất thành công'); // Chuyển đến trang đăng nhập với thông báo                
                exit(); // Kết thúc script để đảm bảo không có gì chạy tiếp
            default:
                // Trường hợp không có hành động hợp lệ
                echo "Hành động không hợp lệ!";
                break;
        }
    }
} else {
    // Nếu không phải admin, điều hướng về trang đăng nhập
    header('Location: /BANHOA/database/login.php');
    exit(); // Kết thúc script
}