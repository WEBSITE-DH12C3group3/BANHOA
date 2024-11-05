<?php
session_start();
ob_start();
require '/xampp/htdocs/BANHOA/database/sendmailreset.php';

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
        input[type="email"], input[type="text"] {
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
        <div class="message" style="color: <?= strpos($error, 'Mã xác nhận') !== false ? 'red' : 'green'; ?>;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    
    <!-- Form nhập email để gửi mã xác nhận -->
    <form id="emailForm" method="POST" action="/BANHOA/database/resetpassword.php">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="email@example.com" required>
        <button type="submit" name="resetpassword">Gửi mã xác nhận</button>
    </form>
    
    <!-- Form nhập mã xác nhận (ẩn mặc định) -->
    <form id="codeForm" method="POST" action="/BANHOA/database/resetpassword.php" style="display: none;">
        <label for="code">Mã xác nhận</label>
        <input type="text" id="code" name="code" placeholder="Nhập mã xác nhận" required>
        <button type="submit" name="checkCode">Xác nhận mã</button>
    </form>

    <a href="/BANHOA/database/login.php" class="back-link">Quay lại trang đăng nhập</a>
    <div class="message" id="message"></div>
</div>

<script>
        // Lấy thông báo từ PHP và hiển thị
        const phpMessage = "<?= htmlspecialchars($error) ?>";
        const messageDiv = document.getElementById("message");

        // Kiểm tra nếu có thông báo "Mã xác nhận đã được gửi"
        if (phpMessage.includes("Mã xác nhận đã được gửi")) {
            // messageDiv.innerText = phpMessage;
            // messageDiv.style.color = "green";
            document.getElementById("emailForm").style.display = "none"; // Ẩn form nhập email
            document.getElementById("codeForm").style.display = "block"; // Hiển thị form nhập mã
        } else if (phpMessage.includes("Mã xác nhận không hợp lệ")) {
            // Nếu mã xác nhận sai, hiển thị lại form mã xác nhận
            // messageDiv.innerText = phpMessage;
            // messageDiv.style.color = "red";
            document.getElementById("emailForm").style.display = "none"; // Ẩn form email
            document.getElementById("codeForm").style.display = "block"; // Giữ form nhập mã
        } else if (phpMessage) {
            // Nếu có lỗi khác (như email chưa đăng ký hoặc không hợp lệ)
            // messageDiv.innerText = phpMessage;
            // messageDiv.style.color = "red";
        }
    </script>

</body>
</html>
