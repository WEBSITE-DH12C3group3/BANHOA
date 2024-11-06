<?php

include 'header.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        /* produc CSS */
        .product-image {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: cover;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            padding: 5px;
            border-radius: 5px;
            font-size: 14px;
        }
    </style>
    <title>EDEN</title>
</head>

<body>

    <section class="mymainmenu" style="background-color: #f7aaaa;">
        <div class="container">
            <div class="row" style="color:#3f640b;">
                <div class="col-md-3 py-3"><b>Danh Mục Sản Phẩm</b></div>
                <div class="col-9">
                    <nav class="navbar navbar-expand-lg" style="background-color: #f7aaaa;">
                        <div class="container-fluid">
                            <a class="navbar-brand" style="color: #3f640b;" href="#"><b>Eden shop</b></a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                <ul class="navbar-nav">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#" style="color: #3f640b;"><b>Trang Chủ</b></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" style="color: #3f640b;"><b>Chủ Đề</b></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" style="color: #3f640b;"><b>Kiểu Dáng</b></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" style="color: #3f640b;"><b>Tin Tức</b></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" style="color: #3f640b;"><b>Mới Nhất</b></a>
                                    </li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #3f640b;">
                                            <b>Màu Sắc</b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#" style="color: #3f640b;">Trắng</a></li>
                                            <li><a class="dropdown-item" href="#" style="color: #3f640b;">Đỏ</a></li>
                                            <li><a class="dropdown-item" href="#" style="color: #3f640b;">cam</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <section class="mymaincontent my-3">
        <div class="container my-3">
            <div class="slider">
                <div id="carouselExampleRide" class="carousel slide" data-bs-ride="true">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="/BANHOA/Front-end/public/copyside.jpg" class="d-block w-100" alt="anhslide">
                        </div>
                        <div class="carousel-item">
                            <img src="/BANHOA/Front-end/public/copyslide.jpg" class="d-block w-100" alt="anhslide">
                        </div>
                        <div class="carousel-item">
                            <img src="/BANHOA/Front-end/public/cpsile.jpg" class="d-block w-100" alt="anhslide">
                        </div>
                        <div class="carousel-item">
                            <img src="/BANHOA/Front-end/public/ngay-phu-nu-viet-nam.jpg" class="d-block w-100" alt="anhslide">
                        </div>
                        <div class="carousel-item">
                            <img src="/BANHOA/Front-end/public/tinh-thanh.jpg" class="d-block w-100" alt="anhslide">
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <br>
            <div class="cate-list mb-3 py-5">
                <span>
                    <h3 style="color: #3f640b;">Sản Phẩm Nổi Bật</h3>
                </span>
                <hr>
                <div class="row py-4">
                    <div class="large-12 columns">
                        <div class="owl-carousel owl-theme">
                            <div class="item hover-effect">
                                <div class="category-icon ">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Hồng Pháp</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon ">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Hồng Vàng</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Hướng Dương</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon img-fluid">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Hồng Đỏ</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon5.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Hồng Xanh</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon6.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Mix Màu</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon7.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Diên Vĩ</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon8.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Hồng Nhật</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon9.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Cẩm Tú</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon10.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Lan</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon11.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Hồng Trắng</h6>
                                </div>
                            </div>
                            <div class="item hover-effect">
                                <div class="category-icon">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon12.jpg" alt="hoaxinh" class="img-fluid rounded-circle">
                                    <h6>Hoa Trà</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-2">
                    <div class="row">
                        <div class="col">
                            <div class="vertical-menu">
                                <ul>
                                    <li><a href="#" class="active">Trang Chủ</a></li>
                                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">Danh Mục</a>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="/BANHOA/Front-end/Customer/hoasinhnhat.php">Hoa sinh nhật</a></li>
                                            <li><a class="dropdown-item" href="#">Hoa khai chương</a></li>
                                            <li><a class="dropdown-item" href="#">Hoa tang</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Dịch Vụ</a></li>
                                    <li><a href="#">Tin Tức</a></li>
                                    <li><a href="#">Liên Hệ</a></li>
                                    <li><a href="#">Về Chúng Tôi</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="row"><img src="/BANHOA/Front-end/public/thuonghieu.png" alt="thuonghieu"></div>
                        </div>
                    </div>
                </div>
                <div class="col-10">
                    <div class="row">
                        <div class="col">
                            <div class="product-list mb-3">
                                <div class="product_title border-bottom">
                                    <div class="title-text">HOA SINH NHẬT</div>
                                </div>
                                <div class="product_list-s py-3" style="background-color: #f7aaaa;">
                                    <div class="row">
                                        <!-- Sản phẩm 1 -->
                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg" class="card-img-top product-image" alt="Adorable">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Adorable(Tình Yêu Thuần Khiết)</h5>
                                                    <p class="text-muted">850,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg" class="card-img-top product-image" alt="Tinh Khiết (Thạch Thảo Trắng)">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Tinh Khiết (Thạch Thảo Trắng)</h5>
                                                    <p class="text-muted">420,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" class="card-img-top product-image" alt="Hạ Về (Cúc Tana Xinh)">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Hạ Về (Cúc Tana Xinh)</h5>
                                                    <p class="text-muted">560,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card position-relative">
                                                <span class="discount-badge">15% Giảm</span>
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" class="card-img-top product-image" alt="Be Happy">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Be Happy</h5>
                                                    <p class="text-muted">720,000 VND <del>850,000 VND</del></p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Danh mục Hoa cưới -->
                            <div class="product-list mb-3">
                                <div class="product_title border-bottom">
                                    <div class="title-text ">HOA CƯỚI</div>
                                </div>
                                <div class="product_list-s py-3" style="background-color: #f7aaaa;">
                                    <div class="row">
                                        <!-- Sản phẩm 1 -->
                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg" class="card-img-top product-image" alt="Adorable">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Adorable(Tình Yêu Thuần Khiết)</h5>
                                                    <p class="text-muted">850,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg" class="card-img-top product-image" alt="Tinh Khiết (Thạch Thảo Trắng)">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Tinh Khiết (Thạch Thảo Trắng)</h5>
                                                    <p class="text-muted">420,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" class="card-img-top product-image" alt="Hạ Về (Cúc Tana Xinh)">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Hạ Về (Cúc Tana Xinh)</h5>
                                                    <p class="text-muted">560,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card position-relative">
                                                <span class="discount-badge">15% Giảm</span>
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" class="card-img-top product-image" alt="Be Happy">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Be Happy</h5>
                                                    <p class="text-muted">720,000 VND <del>850,000 VND</del></p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Danh mục Hoa khai trương -->
                            <div class="product-list mb-3">
                                <div class="product_title border-bottom">
                                    <div class="title-text">HOA KHAI TRƯƠNG</div>
                                </div>
                                <div class="product_list-s py-3" style="background-color: #f7aaaa;">
                                    <div class="row">
                                        <!-- Sản phẩm 1 -->
                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg" class="card-img-top product-image" alt="Adorable">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Adorable(Tình Yêu Thuần Khiết)</h5>
                                                    <p class="text-muted">850,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg" class="card-img-top product-image" alt="Tinh Khiết (Thạch Thảo Trắng)">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Tinh Khiết (Thạch Thảo Trắng)</h5>
                                                    <p class="text-muted">420,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card">
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" class="card-img-top product-image" alt="Hạ Về (Cúc Tana Xinh)">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Hạ Về (Cúc Tana Xinh)</h5>
                                                    <p class="text-muted">560,000 VND</p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 col-sm-6 mb-4">
                                            <div class="card position-relative">
                                                <span class="discount-badge">15% Giảm</span>
                                                <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" class="card-img-top product-image" alt="Be Happy">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title">Be Happy</h5>
                                                    <p class="text-muted">720,000 VND <del>850,000 VND</del></p>
                                                    <a href="#" class="btn btn-primary">Đặt hàng</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col">
                            <div class="row text-center">
                                <div class="title-divider">
                                    <span class="title-text" style="color: #3f640b;">TẠI SAO BẠN NÊN CHỌN CHÚNG TÔI</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="color: #3f640b;">
                                        <b>EDEN – Shop hoa tươi online</b> <br>
                                        <br>
                                        EDEN là shop hoa tươi hỗ trợ khách hàng đặt hoa online, giao tận nơi miễn phí khu vực nội thành. Tuy chỉ vừa hoạt động một thời gian ngắn nhưng EDEN đã được nhiều đơn vị lớn tin tưởng và đặt hoa mỗi ngày. Trong năm vừa qua, EDEN đã phục vụ thành công hơn 5000+ đơn hàng điện hoa toàn quốc. <br>
                                        <br>
                                        <b>Đặt hoa online, giao hoa tận nơi</b> <br>
                                        <br>
                                        Việc gửi tặng hoa trở nên vô cùng đơn giản khi EDEN cung cấp công cụ giúp khách hàng có thể thực hiện thao tác đặt hoa online trực tiếp trên website một cách dễ dàng. Ngoài ra, quý khách còn có thể đặt hoa thông qua hotline 034 827 8722, nhân viên tư vấn sẽ hỗ trợ khách hàng một cách nhanh nhất. Đơn hàng sẽ được thực hiện khi được nhân viên xác nhận thông tin đơn hàng với khách hàng. Sau khi hoàn thành sản phẩm, nhân viên giao hàng sẽ giao hoa tận nơi, trao tận tay người nhận. <br>
                                        <br>
                                        <b>Dịch vụ giao hoa trong ngày</b> <br>
                                        <br>
                                        Shop hoa tươi EDEN luôn sẵn sàng lắng nghe nhu cầu của khách hàng. Chúng tôi đảm bảo có thể giao hoa tươi trong ngày theo yêu cầu của bạn. Bạn trót quên ngày kỉ niệm quan trọng, bạn lỡ quên mua hoa chúc mừng mà thời gian đã gần kề, đừng lo EDEN sẽ giúp bạn giải quyết vấn đề nan giải này. Dù trong hoàn cảnh nào, shop hoa tươi chúng tôi luôn đảm bảo giao đúng, đủ và chất lượng <br>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <p style="color: #3f640b;">
                                        <b>Dịch vụ điện hoa toàn quốc</b> <br>
                                        <br>
                                        Với hệ thống chi nhánh cửa hàng hoa tươi liên kết trên toàn quốc, EDEN cung cấp dịch vụ điện hoa toàn quốc cho quý khách hàng cá nhân và doanh nghiệp. Nếu quý khách có nhu cầu gửi tặng hoa cho người nhận, EDEN sẽ tư vấn cho khách hàng những mẫu hoa tươi phù hợp nhất cho mỗi dịp, lễ trong năm. Sản phẩm sẽ được thực hiện bởi những thợ cắm hoa lành nghề nhất tại khu vực bạn muốn giao hoa. EDEN cam kết giao hàng đúng hẹn và bảo đảm rằng mỗi sản phẩm đều đạt được tiêu chuẩn cao nhất. <br>
                                        <br>
                                        <b>Sản phẩm hoa tươi cung cấp tại EDEN</b> <br>
                                        <br>
                                        Tại EDEN, khách hàng có thể tìm thấy rất nhiều loại hoa khác nhau. Những loại hoa có thể được kết hợp với nhau tạo nên nhiều mẫu mã đa dạng, mới mẻ và độc đáo, phù hợp trong nhiều hoàn cảnh khác nhau. Hoa tại EDEN luôn giữ được độ tươi mới có nguồn gốc, xuất xứ rõ ràng. Những nhành hoa được lựa chọn cẩn thận để tạo ra những sản phẩm hoàn hảo nhất có thể.
                                        <br>
                                        Nhờ vào nguồn hoa tươi dồi dào, phong phú và thợ cắm hoa lành nghề, EDEN cung cấp sản phẩm hoa tươi phù hợp với mọi dịp trong năm như: Hoa sinh nhật, Hoa khai trương, Hoa chia buồn đám tang, Hoa chúc mừng tốt nghiệp, Hoa cầu hôn,… Hoa tươi thành phẩm cũng được hoàn thiện theo nhiều kiểu dáng, thiết kế khác nhau như: Bó hoa, Giỏ hoa, Lẵng hoa để bàn, Kệ hoa chúc mừng,…
                                    </p>
                                </div>
                            </div>
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
                dots: false,
                responsiveClass: true,
                responsive: {
                    0: {
                        items: 2,
                    },
                    600: {
                        items: 4,
                    },
                    1000: {
                        items: 6,
                        loop: false,
                        margin: 20
                    }
                }
            })
        })
    </script>
</body>

</html>