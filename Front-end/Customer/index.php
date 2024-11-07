<?php
include "header.php";
$db = new Database();
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
                        <div class="product-list owl-carousel owl-theme"> <!-- Đặt div này chứa toàn bộ sản phẩm -->
                            <?php
                            $sql = "SELECT * FROM products WHERE remark = 1 ORDER BY id";
                            $result = $db->select($sql);
                            if ($result) {
                                while ($row = $result->fetch_assoc()) { ?>
                                    <div class="item hover-effect">
                                        <div class="category-icon text-center"> <!-- Thêm class 'text-center' để căn giữa -->
                                            <img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $row['image']; ?>" alt="hoaxinh" class="img-fluid rounded-circle">
                                            <h6 class="mt-2"><?php echo $row['product_name']; ?></h6> <!-- Thêm margin-top để tạo khoảng cách giữa ảnh và chữ -->
                                        </div>
                                    </div>
                            <?php
                                }
                            }
                            ?>
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
                            <div class="row text-center">
                            <div class="container my-5">
    <?php
    // Truy vấn tất cả các danh mục từ cơ sở dữ liệu
    $category_sql = "SELECT * FROM categories";
    $category_result = $db->select($category_sql);

    if ($category_result) {
        while ($category = $category_result->fetch_assoc()) {
            $category_id = $category['id'];
            $category_name = $category['category_name'];
            ?>
            <!-- Tiêu đề danh mục -->
            <div class="row text-center">
                <div class="title-divider">
                    <span class="title-text" style="color: #3f640b;"><?php echo strtoupper($category_name); ?></span>
                </div>
            </div>
            
            <!-- Sản phẩm trong danh mục -->
            <div class="product_list-s py-3" style="background-color: #f7aaaa;">
                <div class="row">
                    <div class="container my-5">
                        <div class="row">
                            <?php
                            // Truy vấn sản phẩm dựa trên danh mục hiện tại
                            $sql = "SELECT * FROM products WHERE category_id = $category_id ORDER BY id";
                            $result = $db->select($sql);

                            if ($result) {
                                while ($row = $result->fetch_assoc()) {
                                    $price = number_format($row['price'], 0, ',', '.') . ' VND';
                                    $price_sale = $row['price_sale'] ? number_format($row['price_sale'], 0, ',', '.') . ' VND' : null;
                                    ?>
                                    <div class="col-md-3 col-sm-6 mb-4">
                                        <div class="card">
                                            <img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $row['image']; ?>" class="card-img-top product-image" alt="<?php echo $row['product_name']; ?>">

                                            <div class="card-body text-center">
                                                <h5 class="card-title"><?php echo $row['product_name']; ?></h5>

                                                <!-- Hiển thị giá -->
                                                <p class="text-muted">
                                                    <?php if ($price_sale) {
                                                        $discount_percentage = round((($row['price'] - $row['price_sale']) / $row['price']) * 100, 2);
                                                        ?>
                                                        <span style="text-decoration: line-through; color: black; font-weight: bold;"><?php echo $price; ?></span>
                                                        <span style="font-weight: bold; font-size: 1.2em; color: #f2231d;"><?php echo $price_sale; ?></span>
                                                        <br>
                                                        <small style="color: green; font-weight: bold;">Giảm <?php echo $discount_percentage; ?>%</small>
                                                    <?php } else { ?>
                                                        <span style="font-weight: bold; font-size: 1.2em;"><?php echo $price; ?></span>
                                                    <?php } ?>
                                                </p>

                                                <a href="#" class="btn btn-primary">Đặt hàng</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
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