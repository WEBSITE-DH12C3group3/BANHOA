<?php include 'header.php'; ?>
<DOCTYPE html>
    <html lang="en">

    <head>
        <title>EDEN | Đăng Ký</title>
        <link rel="stylesheet" href="/BANHOA/mycss/form.css">
    </head>

    <body>
        <section>
            <div class="container mt-5 py-5">
                <div class="row justify-content-center">
                    <div class="form-container">
                        <h2 class="text-center mb-4">Đăng Ký Tài Khoản</h2>
                        <form action="/BANHOA/database/reg.php" method="post" onsubmit="return validateForm()">
                            <!-- Fullname -->
                            <div class="form-group">
                                <label for="fullnamee">Họ và Tên</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nhập họ và tên" required>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Nhập email" required>
                            </div>

                            <!-- Password -->
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Nhập mật khẩu" required>
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="confirmPassword">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                            </div>
                            <!-- Thêm thông báo lỗi cho mật khẩu không khớp -->
                            <div id="errorMessage" style="color: red;"></div>


                            <!-- Phone Number -->
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại" required>
                            </div>

                            <div class="form-group">
                                <label for="address">Địa chỉ</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Tỉnh thành/quận huyện/thị xã/số nhà" required>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex py-3 form-group">
                                <button type="submit" class="btn btn-block nuts">Đăng Ký</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php include 'footer.php'; ?>

        <script src="/BANHOA/js/bootstrap.bundle.min.js"></script>
        <script src="/BANHOA/js/bootstrap.bundle.js"></script>
        <script src="/BANHOA/js/bootstrap.js"></script>
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

            function validateForm() {
                var password = document.getElementById("password").value;
                var confirmPassword = document.getElementById("confirmPassword").value;
                var errorMessage = document.getElementById("errorMessage");

                // // Kiểm tra độ dài của mật khẩu
                // if (password.length < 6) {
                //     errorMessage.textContent = "Mật khẩu phải có ít nhất 6 ký tự!";
                //     return false;
                // }

                // Kiểm tra mật khẩu và xác nhận mật khẩu
                if (password !== confirmPassword) {
                    errorMessage.textContent = "Mật khẩu không khớp!";
                    return false;
                }

                errorMessage.textContent = "";
                alert("Đăng ký thành công!");
                return true; // Form sẽ được gửi nếu mọi thứ đúng
            }


            //     function chuyedoidangky(next){
            //         next.preventDefault();
            //         window.location.href="/BANHOA/Front-end/Customer/index.html";
            //     }
            // 
        </script>
    </body>