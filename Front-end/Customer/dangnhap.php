<?php
include 'header.php';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Xóa thông báo lỗi sau khi hiển thị
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>EDEN | Đăng Nhập</title>
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
    </style>
</head>

<body>
    <section>
        <div class="container mt-5 py-5">
            <div class="row justify-content-center">
                <div class="form-container">

                    <h2 class="text-center mb-4">Đăng Nhập</h2>
                    <?php if (!empty($error)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/BANHOA/database/login.php">
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
                        <div class="form-group" style="margin-top: 20px;">
                            <a href="/BANHOA/Front-end/Customer/forgotpassword.php">Quên mật khẩu?</a>
                            <a href="dangky.php">Đăng ký</a>
                            <button type="submit" name="btn-login" class="btn btn-block log" style="float: right;">Đăng nhập</button>
                        </div>

                    </form>
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