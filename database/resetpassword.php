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

    public function requestReset($email) {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = "Email không hợp lệ, vui lòng thử lại!";
            header("Location: /BANHOA/Front-end/Customer/dangnhap.php");
            exit();
        }

        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
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

    public function checkCode($inputCode) {
        if ($inputCode === $_SESSION["code"]) {
            $_SESSION['error'] = "Mã xác nhận chính xác. Bạn có thể đặt lại mật khẩu.";
            header("Location: /BANHOA/database/updatepassword.php"); // Chuyển đến trang đặt lại mật khẩu
        } else {    
            $_SESSION['error'] = "Mã xác nhận không hợp lệ, hãy thử lại!";
            header("Location: /BANHOA/Front-end/Customer/forgotpassword.php"); // Quay lại trang nhập mã
        }
        exit();
    }
}

// Kiểm tra nếu người dùng yêu cầu gửi mã xác nhận
if (isset($_POST['resetpassword'])) {
    $resetPassword = new ResetPassword();
    $resetPassword->requestReset($_POST['email']);
}

// Kiểm tra mã xác nhận khi người dùng nhập mã
if (isset($_POST['checkCode'])) {
    $resetPassword = new ResetPassword();
    $resetPassword->checkCode($_POST['code']);
}
?>
