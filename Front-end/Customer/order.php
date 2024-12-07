<?php
include "/xampp/htdocs/BANHOA/database/connect.php";
require '/xampp/htdocs/BANHOA/database/sendmailreset.php';
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
} elseif ($payment_method == 'momo') {
    // xuly momo
    include_once "momohandle.php";
} elseif ($payment_method == 'momo_atm') {
    // xuly momo atm
    include_once "momohandle.php";
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
            // tru so luong san pham trong kho
            $update_stock = "UPDATE products SET stock = stock - " . $quantity . ", sold = " . $quantity . " WHERE id = '" . $product_id . "'";
            $db->update($update_stock);
            $db->handleSqlError($update_stock);
        }
    }
    header("Location: arigatou.php?order_code=" . $order_code);
}
