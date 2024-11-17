<?php
include "/xampp/htdocs/BANHOA/database/connect.php";
session_start();
$db = new Database();
// them order
$uid = $_SESSION["users_id"];
$order_code = substr(uniqid(), 0, 8);
$insert_order = "INSERT INTO orders (order_code, user_id, order_date, status) VALUES ('" . $order_code . "', '" . $uid . "', NOW(), 'Chờ duyệt')";
$order_query = $db->insert($insert_order);
if ($order_query) {
    // them san pham
    foreach ($_SESSION['cart'] as $key => $value) {
        $product_id = $value['id'];
        $quantity = $value['quantity'];
        $insert_order_detail = "INSERT INTO order_items (order_code, product_id, quantity) VALUES ('" . $order_code . "', '" . $product_id . "', '" . $quantity . "')";
        $db->insert($insert_order_detail);
    }
}
unset($_SESSION['cart']);
// header("Location: arigatou.php?order_code=" . $order_code);
header("Location: test.php");
