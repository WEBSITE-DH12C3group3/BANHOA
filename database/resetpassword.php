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
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Kiểm tra mật khẩu khớp hay không
    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Mật khẩu không khớp. Vui lòng thử lại!";
        header("Location: /BANHOA/database/updatepassword.php");
        exit();
    }

    $resetPassword = new ResetPassword();
    $userId = $_SESSION['users_id'];

    if ($resetPassword->updatePassword($userId, $newPassword)) {
        $_SESSION['error'] = "Đặt lại mật khẩu thành công. Vui lòng đăng nhập!";
        header("Location: /BANHOA/Front-end/Customer/dangnhap.php");
        // session_unset();
        // session_destroy();
    } else {
        $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại!";
        header("Location: /BANHOA/database/updatepassword.php");
    }
    exit();
}
?>
