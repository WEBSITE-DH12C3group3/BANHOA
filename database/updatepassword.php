<?php
require 'resetpassword.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt Lại Mật Khẩu</title>
    <link rel="icon" type="image/png" href="../Front-end/public/Eden.png">

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
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            height: 20px;
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

        .error {
            color: red;
            text-align: center;
        }
    </style>
    <script>
        function validatePassword() {
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            const errorMessage = document.getElementById("errorMessage");

            if (password !== confirmPassword) {
                errorMessage.textContent = "Mật khẩu không khớp. Vui lòng thử lại!";
                return false;
            } else {
                errorMessage.textContent = "";
                return true;
            }
        }
    </script>
</head>

<body>

    <div class="container">
        <h2>Đặt Lại Mật Khẩu</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="message error"><?= htmlspecialchars($_SESSION['error']) ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="resetpassword.php" onsubmit="return validatePassword()">
            <?php if (isset($_SESSION['user_logged_in'])): // Trường hợp người dùng đã đăng nhập 
            ?>
                <div class="form-group">
                    <label for="oldPassword">Mật khẩu cũ</label>
                    <input type="password" class="form-control" name="old_password" id="oldPassword" placeholder="Nhập mật khẩu cũ" required>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="password">Mật khẩu mới</label>
                <input type="password" class="form-control" name="new_password" id="password" placeholder="Nhập mật khẩu mới" required>
            </div>

            <div class="form-group">
                <label for="confirmPassword">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" name="confirm_password" id="confirmPassword" placeholder="Nhập lại mật khẩu mới" required>
            </div>

            <div id="errorMessage" class="error"></div>

            <button type="submit" name="updatePassword">Đặt lại mật khẩu</button>
        </form>

    </div>

</body>

</html>