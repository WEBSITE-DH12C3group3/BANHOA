<?php
session_start();
require '/xampp/htdocs/BANHOA/database/connect.php';
require '/xampp/htdocs/BANHOA/database/sendmailreset.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ResetPassword {
    private $db;
    private $mailer;

    public function __construct() {
        $this->db = new Database();
        $this->mailer = new Mailer();
    }
    // Kiểm tra mật khẩu cũ (dành cho trường hợp người dùng đã đăng nhập)
    public function checkOldPassword($userId, $oldPassword) {
        $query = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Kiểm tra mật khẩu cũ có đúng không
        if ($row['password'] === $oldPassword) {
            return true;
        }
        return false;
    }

    // Yêu cầu đặt lại mật khẩu
    public function requestReset($email) {
        $email = trim($email);

        // Kiểm tra định dạng email hợp lệ
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ, vui lòng thử lại!";
            header("Location: /BANHOA/Front-end/Customer/forgotpassword.php");
            exit();
        }

        // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            // Lưu ID người dùng vào session và gửi mã xác nhận
            $row = $result->fetch_assoc();
            $_SESSION['users_id'] = $row['id'];
            $_SESSION['error'] = "Mã xác nhận đã được gửi đến email của bạn.";

            // Tạo mã xác nhận
            $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $title = "Quên mật khẩu";
            $content = "Mã xác nhận của bạn là: <span style='color:green'>" . $code . "</span>";

            // Gửi mã xác nhận qua email
            $this->mailer->sendMail($title, $content, $email);
            $_SESSION["mail"] = $email;
            $_SESSION["code"] = $code;
            header('Location: /BANHOA/Front-end/Customer/forgotpassword.php');
        } else {
            $_SESSION['error'] = "Email chưa được đăng ký, hãy thử lại!";
            header("Location: /BANHOA/Front-end/Customer/forgotpassword.php");
            exit();
        }
    }

    // Kiểm tra mã xác nhận
    public function checkCode($inputCode) {
        if ($inputCode === $_SESSION["code"]) {
            $_SESSION['error'] = "Mã xác nhận chính xác. Bạn có thể đặt lại mật khẩu.";
            header("Location: /BANHOA/database/updatepassword.php");
        } else {
            $_SESSION['error'] = "Mã xác nhận không hợp lệ, hãy thử lại!";
            header("Location: /BANHOA/Front-end/Customer/forgotpassword.php");
        }
        exit();
    }


    // Cập nhật mật khẩu mới
    public function updatePassword($userId, $newPassword) {
        // Lưu mật khẩu dưới dạng plaintext (không mã hóa)
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("si", $newPassword, $userId);
        return $stmt->execute();
    }
}

// Đoạn mã xử lý yêu cầu đặt lại mật khẩu (gửi mã xác nhận)
if (isset($_POST['resetpassword'])) {
    $resetPassword = new ResetPassword();
    $resetPassword->requestReset($_POST['email']);
}

// Đoạn mã xử lý kiểm tra mã xác nhận
if (isset($_POST['checkCode'])) {
    $resetPassword = new ResetPassword();
    $resetPassword->checkCode($_POST['code']);
}

// Đoạn mã xử lý cập nhật mật khẩu
if (isset($_POST['updatePassword'])) {
    $resetPassword = new ResetPassword();
    $userId = $_SESSION['users_id']; // ID người dùng đã đăng nhập

    if (isset($_POST['old_password'])) {
        $oldPassword = $_POST['old_password'];
        if (!$resetPassword->checkOldPassword($userId, $oldPassword)) {
            $_SESSION['error'] = "Mật khẩu cũ không chính xác!";
            header("Location: /BANHOA/database/updatepassword.php");
            exit();
        }
    }

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Kiểm tra mật khẩu mới và mật khẩu xác nhận có khớp không
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Mật khẩu không khớp. Vui lòng thử lại!";
        header("Location: /BANHOA/database/updatepassword.php");
        exit();
    }

    // Cập nhật mật khẩu mới
    if ($resetPassword->updatePassword($userId, $newPassword)) {
        header("Location: /BANHOA/Front-end/Customer/trangcanhan.php?status=success");  // Chuyển đến trang cá nhân
    } else {
        $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại!";
        header("Location: /BANHOA/database/updatepassword.php");
    }
    exit();
}
?>
