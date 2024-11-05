<?php
session_start();
require '/xampp/htdocs/BANHOA/database/connect.php';

class ResetPasswordProcess {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function updatePassword($userId, $newPassword) {
        // Không mã hóa mật khẩu
        $query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $this->db->conn->prepare($query);
        $stmt->bind_param("si", $newPassword, $userId);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}

if (isset($_POST['resetPassword'])) {
    if (!isset($_SESSION['users_id'])) {
        $_SESSION['error'] = "Bạn chưa xác nhận mã. Vui lòng thử lại!";
        header("Location: /BANHOA/Front-end/Customer/forgotpassword.php");
        exit();
    }

    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Mật khẩu không khớp. Vui lòng thử lại!";
        header("Location: /BANHOA/Front-end/Customer/resetpassword.php");
        exit();
    }

    $resetPasswordProcess = new ResetPasswordProcess();
    $userId = $_SESSION['users_id'];

    if ($resetPasswordProcess->updatePassword($userId, $newPassword)) {
        $_SESSION['success'] = "Đặt lại mật khẩu thành công. Vui lòng đăng nhập!";
        header("Location: /BANHOA/Front-end/Customer/dangnhap.php");
        session_unset();
        session_destroy();
    } else {
        $_SESSION['error'] = "Có lỗi xảy ra. Vui lòng thử lại!";
        header("Location: /BANHOA/Front-end/Customer/resetpassword.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 400px;
            width: 100%;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Đặt Lại Mật Khẩu</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="message" style="color: red;"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="">
        <!-- Password -->
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control" name="new_password" id="password" placeholder="Nhập mật khẩu" required>
        </div>
        
        <!-- Confirm Password -->
        <div class="form-group">
            <label for="confirmPassword">Nhập lại mật khẩu</label>
            <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
        </div>

        <button type="submit" name="resetPassword">Đặt lại mật khẩu</button>
    </form>
</div>

</body>
</html>
