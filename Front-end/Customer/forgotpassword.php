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
    
    <!-- Bước 1: Nhập Email -->
    <form id="emailForm">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="email@example.com" required>
        <button type="submit">Gửi mã xác nhận</button>
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
    document.getElementById("emailForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        const email = document.getElementById("email").value;
        const message = document.getElementById("message");

        if (email) {
            // Giả sử gửi email thành công, hiển thị form nhập mã
            message.innerText = "Mã xác nhận đã được gửi đến email của bạn. Vui lòng kiểm tra.";
            message.style.color = "green";
            document.getElementById("emailForm").style.display = "none";
            document.getElementById("codeForm").style.display = "block";
        } else {
            message.innerText = "Vui lòng nhập email hợp lệ.";
            message.style.color = "red";
        }
    });

    document.getElementById("codeForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const code = document.getElementById("code").value;
        const message = document.getElementById("message");

        if (code) {
            // Giả sử mã xác nhận là chính xác
            message.innerText = "Mã xác nhận chính xác. Bạn có thể đặt lại mật khẩu.";
            message.style.color = "green";
            // Tiếp tục: chuyển đến trang đặt lại mật khẩu
        } else {
            message.innerText = "Vui lòng nhập mã xác nhận hợp lệ.";
            message.style.color = "red";
        }
    });
</script>

</body>
</html>
