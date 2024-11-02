<?php
if (isset($_SESSION['role']) && ($_SESSION['role'] == "admin")) {
    if (isset($_GET['act'])) {
        switch ($_GET['act']) {
            case 'logout':
                // Xóa session role và điều hướng về trang đăng nhập
                unset($_SESSION['role']);
                header('Location: /BANHOA/database/login.php?message=Đăng xuất thành công!'); // Thêm thông báo
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
