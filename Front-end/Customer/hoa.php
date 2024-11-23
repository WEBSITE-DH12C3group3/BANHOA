<?php
include 'header.php';
$product_id = $_GET('id');

$db = new Database();

// Truy vấn sản phẩm
$product_query = "SELECT * FROM products WHERE id = " . (int)$product_id . " LIMIT 1";
$product_result = $db->select($product_query);

if (!$product_result) {
    die("Sản phẩm không tồn tại!"); // Trả lỗi nếu không có sản phẩm
}
$row = $product_result->fetch_assoc();

// Lấy thông tin đánh giá sản phẩm
$ratings_query = "SELECT rating, user_id, fullname, comment, created_at FROM comments WHERE product_id = {$product_id} ORDER BY created_at DESC";
$ratings_result = $db->select($ratings_query);
$comments = [];
if ($ratings_result) {
    while ($rating = $ratings_result->fetch_assoc()) {
        $comments[] = $rating;
    }
}

// Xử lý gửi đánh giá
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    if (isset($_SESSION['fullname'])) {
        $user_id = $_SESSION['users_id'];
        $fullname = $_SESSION['fullname'];
        $rating = intval($_POST['rating']); // Lấy số sao từ form
        $comment = $db->escape_string($_POST['comment']);
        $created_at = date("Y-m-d H:i:s");

        // Kiểm tra dữ liệu đầu vào
        if ($rating < 1 || $rating > 5) {
            $_SESSION['message'] = "Đánh giá không hợp lệ!";
            header("Location: /BANHOA/Front-end/Customer/hoa.php?id={$product_id}");
            exit;
        }
        if (empty(trim($comment))) {
            $_SESSION['message'] = "Bình luận không được để trống!";
            header("Location: /BANHOA/Front-end/Customer/hoa.php?id={$product_id}");
            exit;
        }

        $insert_query = "INSERT INTO comments (product_id, user_id, fullname, rating, comment, created_at)
                         VALUES ('{$product_id}', '$user_id', '{$fullname}', '{$rating}', '{$comment}', '{$created_at}')";
        if ($db->insert($insert_query)) {
            $_SESSION['message'] = "Đánh giá của bạn đã được gửi thành công!";
        }

        // Chuyển hướng để ngăn double-submit
        header("Location: /BANHOA/Front-end/Customer/hoa.php?id={$product_id}");
        exit;
    } else {
        $_SESSION['message'] = "Bạn cần đăng nhập để gửi đánh giá.";
        header("Location: login.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoa | <?php echo $row['product_name']; ?></title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/BANHOA/mycss/hoacss.css">
</head>
<body style="margin-top: 200px;">
    <div class="container mt-5">
        <form class="row" action="modelcart.php?product_id=<?php echo $row['id'] ?>" method="post">
            <!-- Product Image -->
            <div class="col-md-6">
                <img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $row['image']; ?>" class="product-image" width="400px" height="auto" alt="img">
            </div>
            <!-- Product Details -->
            <div class="col-md-6">
                <h3 class="product-title"><?php echo $row['product_name']; ?></h3>
                <p>
                    <span class="old-price" style="font-weight: bold;color: #000000;"><?php echo number_format($row['price'], 0, ',', '.'); ?> VND</span>
                    <span class="price" style="font-weight: bold; color: #f2231d;"><?php echo number_format($row['price_sale'], 0, ',', '.'); ?> VND</span>
                </p>

                <p><small>Giá đã bao gồm 8% VAT - Sản phẩm hỗ trợ giao miễn phí khu vực gần.</small></p>

                <ul class="list-unstyled">
                    <li><?php echo $row['description']; ?></li>
                </ul>

                <p class="text-muted"><small>Sản phẩm thực nhận có thể khác với hình đại diện trên website.</small></p>

                <!-- Buttons -->
                <div class="product-buttons">
                    <button class="btn btn-outline-secondary" name="add" type="submit"><i class="fas fa-cart-plus"></i> Thêm vào giỏ</button>
                    <button class="btn btn-danger" name="addcart" type="submit"><i class="fas fa-shopping-cart"></i> Mua ngay</button>
                </div>
                <?php if (isset($_GET['added']) && $_GET['added'] == 1): ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Đã thêm vào giỏ hàng!',
                            showConfirmButton: false,
                            timer: 1500,
                            toast: true,
                            position: 'top-end',
                            customClass: {
                                popup: 'swal2-custom-popup',
                                icon: 'swal2-custom-icon'
                            }
                        });
                    </script>
                <?php endif; ?>

                <!-- Customer Service -->
                <div class="mt-3">
                    <button class="btn btn-success"><i class="fas fa-phone"></i> <a href="tel:+84333268135" style="text-decoration: none; color: white;">0333268135</a></button>
                </div>

                <!-- Offers Section -->
                <div class="offer-section">
                    <h5>Ưu đãi đặc biệt</h5>
                    <ul>
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
        </form>
    </div>

    <div class="container">
        <!-- Phần đánh giá sản phẩm -->
        <div class="rating-container">
            <div class="row">
                <div class="col-md-2 text-center">
                    <div class="rating-summary">
                        <?php
                        $total_ratings = count($comments);
                        $average_rating = 0;
                        if ($total_ratings > 0) {
                            $sum_ratings = 0;
                            foreach ($comments as $rating) {
                                $sum_ratings += $rating['rating'];
                            }
                            $average_rating = round($sum_ratings / $total_ratings, 1);
                        }
                        echo $average_rating . " <span>trên 5</span>";
                        ?>
                    </div>
                    <div class="rating-stars">
                        <span>★★★★★</span>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn">
                            <input type="radio" name="options" id="option1" autocomplete="off" onclick="filterReviews(1)"> 1 Sao (<?php echo count(array_filter($comments, function($comment) { return $comment['rating'] == 1; })); ?>)
                        </label>
                        <label class="btn">
                            <input type="radio" name="options" id="option2" autocomplete="off" onclick="filterReviews(2)"> 2 Sao (<?php echo count(array_filter($comments, function($comment) { return $comment['rating'] == 2; })); ?>)
                        </label>
                        <label class="btn">
                            <input type="radio" name="options" id="option3" autocomplete="off" onclick="filterReviews(3)"> 3 Sao (<?php echo count(array_filter($comments, function($comment) { return $comment['rating'] == 3; })); ?>)
                        </label>
                        <label class="btn">
                            <input type="radio" name="options" id="option4" autocomplete="off" onclick="filterReviews(4)"> 4 Sao (<?php echo count(array_filter($comments, function($comment) { return $comment['rating'] == 4; })); ?>)
                        </label>
                        <label class="btn">
                            <input type="radio" name="options" id="option5" autocomplete="off" onclick="filterReviews(5)"> 5 Sao (<?php echo count(array_filter($comments, function($comment) { return $comment['rating'] == 5; })); ?>)
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="customer-reviews mt-4">
            <h5>Nhận Xét Khách Hàng</h5>
            <div id="reviewList">
                <ul>
                    <?php foreach ($comments as $comment) { ?>
                        <li>
                            <strong><?php echo htmlspecialchars($comment['fullname']); ?></strong>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $comment['rating']) {
                                        echo '★';
                                    } else {
                                        echo '☆';
                                    }
                                } ?>
                            </div>
                            <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                            <small><?php echo $comment['created_at']; ?></small>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <?php if (isset($message) && $message): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Form for submitting review -->
            <div id="comments" class="rating-container mt-4" style="display: none;">
                <h5>Đánh Giá Sản Phẩm</h5>
                <form method="POST">
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
                        <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
                        <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
                        <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
                        <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
                    </div>
                    <div class="form-group mt-3">
                        <textarea class="form-control" name="comment" rows="4" placeholder="Nhập nhận xét của bạn"></textarea>
                    </div>
                    <button type="submit" name="submit_review" class="btn btn-danger">Gửi Đánh Giá</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Ẩn phần comments mặc định
            const commentsSection = document.getElementById('comments');
            commentsSection.style.display = 'none';  // Ẩn phần comments

            // Kiểm tra xem có tham số trên URL hay không
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('show_comments') && urlParams.get('show_comments') === 'true') {
                commentsSection.style.display = 'block'; // Hiển thị comments nếu tham số có giá trị true
            }

            // Lấy tất cả các nút "Đánh giá"
            const reviewButtons = document.querySelectorAll('.review-button');

            reviewButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết

                    // Thêm tham số vào URL để hiển thị phần comments
                    window.location.href = window.location.href.split('?')[0] + '?show_comments=true'; 
                });
            });
        });
    </script>

    <div class="container mt-5">
        <h2 class="text-danger">Những mẫu hoa tươi cùng loại khác</h2>
        <div class="row" id="Table">
            <?php

            // Truy vấn sản phẩm với phân trang
            $sql = "SELECT * FROM products WHERE category_id = '$row[category_id]' AND id != $product_id ORDER BY id";
            $result = $db->select($sql);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $price = number_format($row['price'], 0, ',', '.') . ' VND';
                    $price_sale = $row['price_sale'] ? number_format($row['price_sale'], 0, ',', '.') . ' VND' : null;
            ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <a class="card h-100 text-center" href="hoa.php?id=<?php echo $row['id']; ?>">
                            <div class="badge bg-danger text-white position-absolute sale-badge">Sale <?php echo $row['sale']; ?>%</div>
                            <img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $row['image']; ?>" class="card-img-top product-image" alt="<?php echo $row['product_name']; ?>">

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                                <p class="card-text">
                                    <del style="font-weight: bold;"><?php echo $price; ?></del> <!-- Original price in bold -->
                                    <span class="text-danger" style="font-weight: bold;color: #f2231d;"><?php echo $price_sale; ?></span> <!-- Sale price in bold -->
                                </p>
                                <button class="btn btn-primary">Đặt hàng</button>
                            </div>

                        </a>
                    </div>
            <?php
                }
            }
            ?>
        </div>

        <div class="pagination-container" style="display: flex; justify-content: center;">
            <div class="pagination" id="pagination" style="align-self: center;">
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/BANHOA/mycss/pagination.js"></script>
    
</body>
</html>
