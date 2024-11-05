<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Xóa thông báo lỗi sau khi hiển thị
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
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

        p {
            text-align: center;
            color: #666;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="email"],
        input[type="text"] {
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

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
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
        <h2>Quên Mật Khẩu</h2>
        <p>Vui lòng nhập email của bạn để nhận mã xác nhận.</p>

        <!-- Hiển thị thông báo lỗi nếu có -->
        <?php if (!empty($error)): ?>
            <div class="message" style="color: red;"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Bước 1: Nhập Email -->
        <form id="emailForm" method="POST" action="/BANHOA/database/resetpassword.php">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="email@example.com" required>
            <button type="submit" name="resetpassword">Gửi mã xác nhận</button>
        </form>

        <!-- Bước 2: Nhập mã xác nhận (ẩn mặc định) -->
        <form id="codeForm" style="display: none;">
            <label for="code">Mã xác nhận</label>
            <input type="text" id="code" name="code" placeholder="Nhập mã xác nhận" required>
            <button type="submit">Xác nhận mã</button>
        </form>

        <a href="login.html" class="back-link">Quay lại trang đăng nhập</a>
        <div class="message" id="message"></div>
    </div>

    <script>
        // // Kiểm tra nếu có thông báo từ PHP
        // const phpMessage = "<?= isset($error) ? htmlspecialchars($error) : '' ?>";
        // const messageDiv = document.getElementById("message");

        if (phpMessage.includes("Mã xác nhận đã được gửi")) {
            // Nếu email được gửi thành công, hiển thị form nhập mã
            messageDiv.innerText = phpMessage;
            messageDiv.style.color = "green";
            document.getElementById("emailForm").style.display = "none";
            document.getElementById("codeForm").style.display = "block";
        } else if (phpMessage) {
            // Nếu có lỗi (email chưa đăng ký hoặc không hợp lệ)
            messageDiv.innerText = phpMessage;
            messageDiv.style.color = "red";
        }

        document.getElementById("codeForm").addEventListener("submit", function(event) {
            event.preventDefault();

            const code = document.getElementById("code").value;

            if (code) {
                // Giả sử mã xác nhận là chính xác
                messageDiv.innerText = "Mã xác nhận chính xác. Bạn có thể đặt lại mật khẩu.";
                messageDiv.style.color = "green";
                // Tiếp tục: chuyển đến trang đặt lại mật khẩu
            } else {
                messageDiv.innerText = "Vui lòng nhập mã xác nhận hợp lệ.";
                messageDiv.style.color = "red";
            }
        });
    </script>

</body>

</html>