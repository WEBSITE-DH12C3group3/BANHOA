<?php
include "/xampp/htdocs/BANHOA/database/connect.php";
include "config_vnp.php";
session_start();
$db = new Database();

$uid = $_SESSION["users_id"];
$order_code = substr(uniqid(), 0, 8);
$payment_method = $_POST['paymentMethod'];

// lay dia chi
$delivery_sql = "SELECT * FROM delivery WHERE user_id = '" . $uid . "' LIMIT 1";
$result = $db->select($delivery_sql);
$db->handleSqlError($delivery_sql);
$row = $result->fetch_assoc();
$id_delivery = $row['id'];

// vnpay
if ($payment_method == 'vnpay') {
    // xuly vnpay
    include_once "vnphandle.php";

    if (isset($_POST['redirect'])) {
        $insert_order = "INSERT INTO orders (order_code, user_id, order_date, status, total, payment_method, id_delivery) 
            VALUES ('" . $order_code . "', '" . $uid . "', NOW(), 'Đã thanh toán', '" . $_SESSION["total"] . "', '" . $payment_method . "', '" . $id_delivery . "')";
        $order_query = $db->insert($insert_order);
        $db->handleSqlError($insert_order);
        // them order detail
        if ($order_query) {
            // them san pham
            foreach ($_SESSION['cart'] as $key => $value) {
                $product_id = $value['id'];
                $quantity = $value['quantity'];
                $insert_order_detail = "INSERT INTO order_items (order_code, product_id, quantity) 
            VALUES ('" . $order_code . "', '" . $product_id . "', '" . $quantity . "')";
                $db->insert($insert_order_detail);
            }
        }
        unset($_SESSION['total']);
        unset($_SESSION['cart']);
        header('Location: ' . $vnp_Url);
        die();
    } else {
        echo json_encode($returnData);
    }
    // vui lòng tham khảo thêm tại code demo
} elseif ($payment_method == 'momo') {
    // xuly momo
    include_once "mmhandle.php";
    exit();
} else {
    // thanh toan khi nhận hàng và chuyển khoản
    $insert_order = "INSERT INTO orders (order_code, user_id, order_date, status, payment_method, id_delivery) 
    VALUES ('" . $order_code . "', '" . $uid . "', NOW(), 'Chờ duyệt', '" . $payment_method . "', '" . $id_delivery . "')";
    $order_query = $db->insert($insert_order);
    $db->handleSqlError($insert_order);
    // them order detail
    if ($order_query) {
        // them san pham
        foreach ($_SESSION['cart'] as $key => $value) {
            $product_id = $value['id'];
            $quantity = $value['quantity'];
            $insert_order_detail = "INSERT INTO order_items (order_code, product_id, quantity) 
            VALUES ('" . $order_code . "', '" . $product_id . "', '" . $quantity . "')";
            $db->insert($insert_order_detail);
        }
    }
    unset($_SESSION['total']);
    unset($_SESSION['cart']);
    header("Location: arigatou.php?order_code=" . $order_code);
}
