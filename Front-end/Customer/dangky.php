<?php
include 'header.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>EDEN | Đăng Ký</title>
    <link rel="stylesheet" href="/BANHOA/mycss/form.css">
    <style>
        .log {
            background-color: #28a228;
            cursor: pointer;
            color: #fff;
        }

        .log:hover {
            background-color: #196f38;
            color: #fff;
        }

        .alert {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>

<body style="margin-top: 200px;">
    <section>
        <div class="container mt-5 py-5">
            <div class="row justify-content-center">
                <div class="form-container">
                    <h2 class="text-center mb-4">Đăng Ký Tài Khoản</h2>

                    <!-- Hiển thị thông báo -->
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error'];
                                                        unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success'];
                                                            unset($_SESSION['success']); ?></div>
                    <?php endif; ?>

                    <form action="/BANHOA/database/reg.php" method="post" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="fullname">Họ và Tên</label>
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nhập họ và tên">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Nhập email">
                        </div>

                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu">
                        </div>

                        <div class="form-group">
                            <label for="confirmPassword">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Nhập lại mật khẩu">
                        </div>

                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại">
                        </div>

                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" id="address" placeholder="Tỉnh thành/quận huyện/thị xã/số nhà">
                        </div>

                        <div class="d-flex py-3 form-group">
                            <button type="submit" name="btn-reg" class="btn btn-block log">Đăng Ký</button>
                        </div>

                        <div>
                            Đã có tài khoản? <a href="dangnhap.php">Đăng nhập ở đây.</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        function validateForm() {
            const fullname = document.getElementById("fullname").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value;
            const confirmPassword = document.getElementById("confirmPassword").value;
            const phone = document.getElementById("phone").value.trim();
            const address = document.getElementById("address").value.trim();

            if (!fullname || !email || !password || !confirmPassword || !phone || !address) {
                alert("Vui lòng nhập đầy đủ thông tin!");
                return false;
            }

            if (fullname.length > 220) {
                alert("Họ và tên quá dài, tối đa 220 ký tự!");
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert("Email sai định dạng!");
                return false;
            }

            if (password.length < 6 || password.length > 20) {
                alert("Mật khẩu phải từ 6 đến 20 ký tự!");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Mật khẩu không khớp!");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>