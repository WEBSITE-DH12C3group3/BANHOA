<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/BANHOA/Front-end/public/Eden.png">
    <link rel="stylesheet" href="/BANHOA/css/bootstrap.css">
    <link rel="stylesheet" href="/BANHOA/css/bootstrap.min.css">
    <link rel="stylesheet" href="/BANHOA/mycss/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="/BANHOA/assets/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="/BANHOA/assets/owlcarousel/assets/owl.theme.default.min.css">
    <script src="/BANHOA/assets/vendors/jquery.min.js"></script>
    <script src="/BANHOA/assets/owlcarousel/owl.carousel.js"></script>
    <link rel="stylesheet" href="/BANHOA/mycss/footder.css">
    <style>
        .form-container {
            border: 1px solid #ccc; /* Màu của khung */
            border-radius: 5px; /* Bo góc */
            padding: 20px; /* Đệm bên trong */
            background-color: #f9f9f9; /* Màu nền */
        }
    </style>
    <title>EDEN</title>
</head>
<body>
    <section class="myheader">
        <div class="container py-3">
            <div class="row align-items-center">
                <!-- Logo -->
                <div class="col-md-3 col-4 text-center text-md-start mb-3 mb-md-0">
                    <img src="/BANHOA/Front-end/public/logo1.png" class="img-fluid" width="200px" height="auto" alt="Logo">
                </div>
    
                <!-- Search Bar -->
                <div class="col-md-5 col-4 mb-3 mb-md-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Tìm Kiếm" aria-label="Tìm Kiếm" aria-describedby="basic-addon2">
                        <button class="btn btn-outline-secondary" type="button" id="basic-addon2">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </div>
    
                <!-- Cart and Account Section -->
                <div class="col-md-4 col-4">
                    <div class="d-flex justify-content-center justify-content-md-end align-items-center">
                        <!-- Cart -->
                        <div class="col-6">
                            <div class="me-4 position-relative text-center">
                                <a href="/BANHOA/Front-end/Customer/giohang.html" class="position-relative text-dark">
                                    <span class="fs-2"><i class="fa-solid fa-bag-shopping"></i></span>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        0
                                    </span>
                                </a>
                                <div class="text-muted" style="color:#3f640b;">
                                    Giỏ Hàng <br> Của Bạn
                                </div>
                            </div>
                        </div>
    
                        <!-- Account -->
                        <div class="col-6">
                            <div class="fs-3"><i class="fa-regular fa-user"></i></div>
                            <div class="dropdown nav-item">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Xin chào! Tài khoản
                                </a>
                                <ul class="  dropdown-menu">
                                    <li><a class="dropdown-item" href="/BANHOA/Front-end/Customer/dangky.html">Đăng ký</a></li>
                                    <li><a class="dropdown-item" href="/BANHOA/Front-end/Customer/dangnhap.html">Đăng nhập</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container mt-5 py-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="form-container" style="border: 1px solid #ccc; border-radius: 5px; padding: 20px; background-color: #f9f9f9;">
                        <h2 class="text-center mb-4">Đăng Ký Tài Khoản</h2>
                        <form id="register" action="/BANHOA/database/reg.php" method="post" onsubmit="return validateForm()">
                            <!-- Fullname -->
                            <div class="form-group">
                                <label for="fullnamee">Họ Và Tên</label>
                                <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Nhập họ và tên" required>
                            </div>
    
                            <!-- user -->
                            <div class="form-group">
                                <label for="user">Tên Đăng Nhập</label>
                                <input type="text" class="form-control" name="user" id="user" placeholder="Nhập tên đăng nhập" required>
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
                            <!-- <div class="form-group">
                                <label for="confirmPassword">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                            </div> -->
                            <!-- Thêm thông báo lỗi cho mật khẩu không khớp -->
                            <div id="errorMessage" style="color: red;"></div>
                            
                            <!-- Confirm Password -->
                            <div class="form-group">
                                <label for="confirmPassword">Nhập lại mật khẩu</label>
                                <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                            </div>
                            
                                
                            <!-- Phone Number -->
                            <div class="form-group">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" class="form-control" name="phone" id="phone" placeholder="Nhập số điện thoại" required>
                            </div>
    
                            <div class="form-group">
                                <label for="address">Địa chỉ nhận hàng</label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Tỉnh thành/quận huyện/thị xã/số nhà" required>
                            </div>
    
                            <!-- Submit Button -->
                            <div class="py-5">
                                <button type="submit" name="btn-reg" value="Đăng ký" class="btn btn-primary btn-block">Đăng Ký</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <section class="mymainfooter text-dark py-4 fooder">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h4>Giới Thiệu</h4>
                    <ul class="list-menu">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="#">Giới Thiệu</a></li>
                        <li><a href="#">Sản Phẩm</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>Mua Hàng</h4>
                    <ul class="list-menu">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="#">Giới Thiệu</a></li>
                        <li><a href="#">Sản Phẩm</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>Chăm Sóc Khách Hàng</h4>
                    <ul class="list-menu">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="#">Giới Thiệu</a></li>
                        <li><a href="#">Sản Phẩm</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>Liên Lạc</h4>
                    <ul class="list-menu">
                        <li><a href="#">Trang Chủ</a></li>
                        <li><a href="#">Giới Thiệu</a></li>
                        <li><a href="#">Sản Phẩm</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-hover">
                        <tr>
                            <th>Số Điện Thoại</th>
                            <td><a href="tel:+84349459165">0349459165</a></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><a href="mailto:mynameistrang@gmail.com">mynameistrang@gmail.com</a></td>
                        </tr>
                        <tr>
                            <th>Địa Chỉ</th>
                            <td class="text-primary">Cầu Diễn-Bắc Từ Liêm-Hà Nội</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="input-group mb-3">
                            <form method="get">
                                <label for="send"></label>
                                <input type="text" id="send" placeholder="nội dung">
                                <input type="submit" value="Gửi">
                            </form>
                        </div>
                    </div>
                    <div class="row-md-6">
                        <button type="button" class="btn btn-outline-success fs-2"><a href="#"><i class="fa-brands fa-facebook"></i></a></button>
                        <button type="button" class="btn btn-outline-danger fs-2"><a href="#"><i class="fa-brands fa-instagram"></i></a></button>
                        <button type="button" class="btn btn-outline-warning fs-2"><a href="#"><i class="fa-brands fa-twitter"></i></a></button>
                        <button type="button" class="btn btn-outline-info fs-2"><a href="#"><img src="/BANHOA/Front-end/public/nopgeden.png" width="37px" alt=""></a></button>
                    </div>
                </div>
            </div>
        </div>
    </section> 

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
        errorMessage.textContent = "Mật khẩu và Nhập lại mật khẩu không khớp!";
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