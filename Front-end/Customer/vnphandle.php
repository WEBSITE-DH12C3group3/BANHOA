<?php
$vnp_TxnRef = $order_code; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
$vnp_OrderInfo = 'Thanh toán đơn hàng qua VNPAY';
$vnp_OrderType = 'billpayment';
$vnp_Amount = $_SESSION["total"] * 100;
$vnp_Locale = 'vn';
$vnp_BankCode = 'ncb';
$vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
//Add Params of 2.0.1 Version
$vnp_ExpireDate = $expire;
// Invoice
$inputData = array(
    "vnp_Version" => "2.1.0",
    "vnp_TmnCode" => $vnp_TmnCode,
    "vnp_Amount" => $vnp_Amount,
    "vnp_Command" => "pay",
    "vnp_CreateDate" => date('YmdHis'),
    "vnp_CurrCode" => "VND",
    "vnp_IpAddr" => $vnp_IpAddr,
    "vnp_Locale" => $vnp_Locale,
    "vnp_OrderInfo" => $vnp_OrderInfo,
    "vnp_OrderType" => $vnp_OrderType,
    "vnp_ReturnUrl" => $vnp_Returnurl,
    "vnp_TxnRef" => $vnp_TxnRef,
    "vnp_ExpireDate" => $vnp_ExpireDate
);

if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    $inputData['vnp_BankCode'] = $vnp_BankCode;
}
//var_dump($inputData);
ksort($inputData);
$query = "";
$i = 0;
$hashdata = "";
foreach ($inputData as $key => $value) {
    if ($i == 1) {
        $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
    } else {
        $hashdata .= urlencode($key) . "=" . urlencode($value);
        $i = 1;
    }
    $query .= urlencode($key) . "=" . urlencode($value) . '&';
}

$vnp_Url = $vnp_Url . "?" . $query;
if (isset($vnp_HashSecret)) {
    $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
    $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
}
$returnData = array(
    'code' => '00',
    'message' => 'success',
    'data' => $vnp_Url
);

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
        include 'formmail.php';
    }
    header('Location: ' . $vnp_Url);
    die();
} else {
    echo json_encode($returnData);
}
// vui lòng tham khảo thêm tại code demo
