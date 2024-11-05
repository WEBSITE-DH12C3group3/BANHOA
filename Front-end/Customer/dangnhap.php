<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Xóa thông báo lỗi sau khi hiển thị
include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .form-container {
            border: 1px solid #ccc;
            /* Màu của khung */
            border-radius: 5px;
            /* Bo góc */
            padding: 20px;
            /* Đệm bên trong */
            background-color: #f9f9f9;
            /* Màu nền */
        }
    </style>
    <title>EDEN</title>
</head>

<body>
    <section>
        <div class="container  mt-5 py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-container" style="border: 1px solid #ccc; border-radius: 5px; padding: 20px; background-color: #f9f9f9;">

                        <h2 class="text-center mb-4">Đăng Nhập</h2>
                        <?php if (!empty($error)) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="/BANHOA/database/login.php"> <!-- Thay your_php_script.php bằng tên file PHP của bạn -->
                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
                            </div>
                            <div>
                                <a href="/BANHOA/Front-end/Customer/forgotpassword.php">Quên mật khẩu?</a>
                            </div>
                            <!-- Thẻ button được căn giữa -->
                            <div class="d-flex py-3">
                                <button type="submit" name="btn-login" class="btn btn-primary">Đăng nhập</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 1,
                        // nav: true
                    },
                    600: {
                        items: 3,
                        // nav: false
                    },
                    1000: {
                        items: 5,
                        nav: true,
                        loop: false,
                        margin: 20
                    }
                }
            })
        })

        function chuyedoidangnhap(next) {
            next.preventDefault();
            window.location.href = "/BANHOA/Front-end/Customer/index.html";
        }
    </script>
</body>