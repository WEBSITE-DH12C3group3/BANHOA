<?php
session_start();
include 'connect.php';

$db = new Database();
$_SESSION['product_id'] = $product_id;
$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    $product_id = intval($_POST['product_id']);

    if (isset($_SESSION['fullname'])) {
        $product_id = $_POST['product_id'];
        $fullname = $_SESSION['fullname'];
        $rating = intval($_POST['rating']);
        $comment = $db->escape_string($_POST['comment']);
        $created_at = date("Y-m-d H:i:s");

        // Kiểm tra dữ liệu đầu vào
        if ($rating < 1 || $rating > 5) {
            $_SESSION['message'] = "Đánh giá không hợp lệ!";
            header("Location: /BANHOA/Front-end/Customer/hoa.php?id={$product_id}&show_comments=true#comments");
            exit;
        }
        if (empty(trim($comment))) {
            $_SESSION['message'] = "Bình luận không được để trống!";
            header("Location: /BANHOA/Front-end/Customer/hoa.php?id={$product_id}&show_comments=true#comments");
            exit;
        }

        // Thêm dữ liệu vào database
        $insert_query = "INSERT INTO comments (product_id, fullname, rating, comment, created_at)
                         VALUES ('{$product_id}', '{$fullname}', '{$rating}', '{$comment}', '{$created_at}')";
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
