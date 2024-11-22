<?php
session_start(); // Khởi tạo session nếu chưa
include 'connect.php';


$product_id = isset($_GET['id']) ? filter_var($_GET['id'], FILTER_VALIDATE_INT) : null;
if (!$product_id) {
    die("Không tìm thấy sản phẩm!");
}
class ReviewHandler
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function submitReview($product_id, $fullname, $rating, $comment)
    {
        if ($rating < 1 || $rating > 5) {
            echo "Đánh giá phải nằm trong khoảng 1–5 sao.";
            return false;
        }

        $stmt = $this->db->prepare("INSERT INTO comments (product_id, fullname, rating, comment) 
                                    VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $product_id, $fullname, $rating, $comment);
        return $stmt->execute();
    }
}

$reviewHandler = new ReviewHandler($db);

if (isset($_POST['submit_review'])) {
    $rating = intval($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    $fullname = $_SESSION['fullname'] ?? null;

    if ($rating > 0 && !empty($comment)) {
        $success = $reviewHandler->submitReview($product_id, $fullname, $rating, $comment);
        if ($success) {
            echo "Đánh giá của bạn đã được gửi thành công!";
        } else {
            echo "Có lỗi xảy ra khi gửi đánh giá.";
        }
    } else {
        echo "Vui lòng nhập đầy đủ thông tin.";
    }
}

?>
