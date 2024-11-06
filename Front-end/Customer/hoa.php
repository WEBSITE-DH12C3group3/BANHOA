<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Hoa</title>
    <style>
        body {
            background-color: #f7f7f7;
        }

        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .price {
            font-size: 1.5rem;
            color: red;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
        }

        .offer-section {
            background-color: #e9f7ef;
            padding: 10px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .offer-section li {
            list-style-type: none;
            margin: 5px 0;
        }

        .product-buttons {
            margin-top: 20px;
        }

        .product-buttons button {
            margin-right: 10px;
        }

        .note {
            background-color: #ffefef;
            padding: 10px;
            margin-top: 10px;
            border-left: 5px solid red;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6">
                <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" class="product-image" width="400px" height="auto" alt="Flower Arrangement">
            </div>
            <!-- Product Details -->
            <div class="col-md-6">
                <h3 class="product-title">Hoa Vàng Nhiều Bông</h3>
                <p><span class="old-price">700.000 ₫</span> <span class="price">600.000 ₫</span></p>
                <p><small>Giá đã bao gồm 8% VAT - Sản phẩm hỗ trợ giao miễn phí khu vực gần.</small></p>

                <!-- Product Components -->
                <ul class="list-unstyled">
                    <li>Cúc rossi hồng: 5</li>
                    <li>Green wicky: 3</li>
                    <li>Hoa baby: 1</li>
                    <li>Hồng Lạc Thần: 10</li>
                </ul>

                <p class="text-muted"><small>Sản phẩm thực nhận có thể khác với hình đại diện trên website.</small></p>

                <!-- Buttons -->
                <div class="product-buttons">
                    <button class="btn btn-outline-secondary">Thêm vào giỏ</button>
                    <button class="btn btn-danger">Mua ngay</button>
                </div>

                <!-- Customer Service -->
                <div class="mt-3">
                    <button class="btn btn-success">Gọi ngay: 1800 6353</button>
                </div>

                <!-- Offers Section -->
                <div class="offer-section">
                    <h5>Ưu đãi đặc biệt</h5>
                    <ul>
                        <li>Tặng Banner Hoặc Thiệp (Trị Giá 20.000đ - 50.000đ) Miễn Phí</li>
                        <li>Giảm tiếp 3% cho đơn hàng bạn tạo online lần thứ 2</li>
                        <li>Miễn phí giao khu vực nội thành</li>
                        <li>Giao hàng trong vòng 2 giờ</li>
                        <li>Cam kết 100% hoàn lại tiền nếu bạn không hài lòng</li>
                        <li>Cam kết hoa tươi trong 3 ngày</li>
                    </ul>
                </div>

                <!-- Note Section -->
                <div class="note">
                    <p>Lưu ý: Sản phẩm bạn đang chọn là sản phẩm thiết kế đặc biệt. Hiện nay chỉ thử nghiệm cung cấp cho Tp. Hồ Chí Minh và Hà Nội.</p>
                </div>
            </div>
        </div>
    </div>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            .sale-badge {
                top: 10px;
                right: 10px;
                padding: 5px 10px;
                font-size: 12px;
            }

            .card-img-top {
                height: 200px;
                object-fit: cover;
            }

            .card h5 {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .card p {
                font-size: 16px;
            }

            .card-body {
                padding: 10px;
            }

            .text-danger {
                color: #dc3545 !important;
            }

            .text-white {
                color: #fff !important;
            }

            .bg-danger {
                background-color: #dc3545 !important;
            }

            .bg-warning {
                background-color: #ffc107 !important;
            }
        </style>
    </head>

    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Đánh Giá Sản Phẩm</title>

        <!-- Bootstrap CSS -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <style>
            .rating-container {
                background-color: #fdf7f2;
                padding: 20px;
                border-radius: 8px;
                border: 1px solid #f5ece6;
                margin-top: 20px;
            }

            .rating-stars {
                color: #f44336;
                font-size: 20px;
            }

            .btn-group-toggle .btn {
                border: 1px solid #ccc;
                background-color: white;
                color: #333;
            }

            .btn.active {
                background-color: #f5ece6;
                border-color: #f44336;
                color: #f44336;
            }

            .star-rating input {
                display: none;
            }

            .star-rating label {
                font-size: 24px;
                color: #ddd;
                cursor: pointer;
            }

            .star-rating input:checked~label,
            .star-rating label:hover,
            .star-rating label:hover~label {
                color: #f44336;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <div class="rating-container">
                <div class="row">
                    <div class="col-md-2 text-center">
                        <div class="rating-summary">5.0 <span>trên 5</span></div>
                        <div class="rating-stars">
                            <span>★★★★★</span>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn">
                                <input type="radio" name="options" id="option1" autocomplete="off"> Tất Cả
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option2" autocomplete="off"> 5 Sao (28)
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option3" autocomplete="off"> 4 Sao (1)
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option4" autocomplete="off"> 3 Sao (0)
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option5" autocomplete="off"> 2 Sao (0)
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option6" autocomplete="off"> 1 Sao (0)
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option7" autocomplete="off"> Có Hình Ảnh / Video (24)
                            </label>
                            <label class="btn">
                                <input type="radio" name="options" id="option8" autocomplete="off"> Có Bình Luận (24)
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Đánh giá sản phẩm -->
            <div class="rating-container mt-4">
                <h5>Đánh Giá Sản Phẩm</h5>
                <form id="ratingForm">
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5">
                        <label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4">
                        <label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3">
                        <label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2">
                        <label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1">
                        <label for="star1">★</label>
                    </div>

                    <div class="form-group mt-3">
                        <textarea class="form-control" id="review" rows="4" placeholder="Nhập nhận xét của bạn"></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Gửi Đánh Giá</button>
                </form>

                <div class="mt-4" id="reviewMessage"></div>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <script>
            document.getElementById("ratingForm").addEventListener("submit", function(event) {
                event.preventDefault();

                // Lấy giá trị đánh giá sao
                const rating = document.querySelector('input[name="rating"]:checked');
                const reviewText = document.getElementById("review").value;

                if (rating && reviewText) {
                    document.getElementById("reviewMessage").innerHTML = `
                    <div class="alert alert-success">
                        Cảm ơn bạn đã đánh giá ${rating.value} sao. Nhận xét của bạn: "${reviewText}"
                    </div>
                `;
                    document.getElementById("ratingForm").reset();
                } else {
                    document.getElementById("reviewMessage").innerHTML = `
                    <div class="alert alert-danger">
                        Vui lòng chọn số sao và nhập nhận xét của bạn!
                    </div>
                `;
                }
            });
        </script>
    </body>

    </html>


    <body>

        <div class="container mt-5">
            <h2 class="text-danger">Những mẫu hoa tươi cùng loại khác</h2>
            <div class="row">
                <!-- Product 1 -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 text-center">
                        <div class="badge bg-danger text-white position-absolute sale-badge">Sale</div>
                        <img src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg" class="card-img-top" alt="Melody">
                        <div class="card-body">
                            <h5 class="card-title">Hoa Đỏ</h5>
                            <p class="card-text"><del>500.000 đ</del> <span class="text-danger">450.000 đ</span></p>
                            <span class="badge bg-warning text-white">Freeship</span>
                        </div>
                        <div class="mb-4">
                            <a href="#" class="btn btn-primary">Đặt hàng</a>
                        </div>
                    </div>
                </div>
                <!-- Product 2 -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 text-center">
                        <div class="badge bg-danger text-white position-absolute sale-badge">Sale</div>
                        <img src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg" class="card-img-top" alt="Only rose 9">
                        <div class="card-body">
                            <h5 class="card-title">Hoa Vàng</h5>
                            <p class="card-text"><span class="text-danger">Giá từ: 400.000 đ</span></p>
                            <span class="badge bg-warning text-white">Freeship</span>
                        </div>
                        <div class="mb-4">
                            <a href="#" class="btn btn-primary">Đặt hàng</a>
                        </div>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 text-center">
                        <div class="badge bg-danger text-white position-absolute sale-badge">Sale</div>
                        <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" class="card-img-top" alt="Nắng Hồng">
                        <div class="card-body">
                            <h5 class="card-title">Nắng Hồng</h5>
                            <p class="card-text"><del>600.000 đ</del> <span class="text-danger">550.000 đ</span></p>
                            <span class="badge bg-warning text-white">Freeship</span>
                        </div>
                        <div class="mb-4">
                            <a href="#" class="btn btn-primary">Đặt hàng</a>
                        </div>
                    </div>
                </div>
                <!-- Product 4 -->
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 text-center">
                        <div class="badge bg-danger text-white position-absolute sale-badge">Sale</div>
                        <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" class="card-img-top" alt="Ohara">
                        <div class="card-body">
                            <h5 class="card-title">Hoa Bó</h5>
                            <p class="card-text"><del>1.045.000 đ</del> <span class="text-danger">950.000 đ</span></p>
                            <span class="badge bg-warning text-white">Freeship</span>
                        </div>
                        <div class="mb-4">
                            <a href="#" class="btn btn-primary">Đặt hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    </body>

</html>

<?php include 'footer.php'; ?>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>