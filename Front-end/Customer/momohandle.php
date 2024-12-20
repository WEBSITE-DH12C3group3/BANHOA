<?php
header('Content-type: text/html; charset=utf-8');

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';

$amount = $_SESSION["total"];
$orderId = $order_code;
$redirectUrl = "http://localhost/BANHOA/Front-end/Customer/arigatou.php";
$ipnUrl = "http://localhost/BANHOA/Front-end/Customer/arigatou.php";
$extraData = "";

$requestId = time() . "";
if ($payment_method == 'momo') {
    $orderInfo = "Thanh toán mã QR";
    $requestType = "captureWallet";
} else {
    $orderInfo = "Thanh toán qua MoMo ATM";
    $requestType = "payWithATM";
}
// $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
//before sign HMAC SHA256 signature
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);
$data = array(
    'partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature
);
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);  // decode json

//Just a example, please check more in there
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
header('Location: ' . $jsonResult['payUrl']);
