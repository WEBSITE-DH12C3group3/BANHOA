<?php
include 'header.php';
include 'config.php';

try {
    $db = new Database();
    if (!$db->conn) {
        throw new Exception("Không thể kết nối tới cơ sở dữ liệu.");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Kiểm tra tất cả các biến GET
        $required_params = ['vnp_Amount', 'vnp_BankCode', 'vnp_BankTranNo', 'vnp_CardType', 'vnp_OrderInfo', 'vnp_PayDate', 'vnp_TmCode', 'vnp_TransactionNo', 'vnp_Txnref'];
        foreach ($required_params as $param) {
            if (!isset($_GET[$param])) {
                throw new Exception("Thiếu tham số: " . htmlspecialchars($param)); // Hiển thị lỗi chi tiết
            }
        }

        // Lấy giá trị sau khi đã kiểm tra isset
        $vnp_Amount = intval($_GET['vnp_Amount']);
        $vnp_BankCode = $db->conn->real_escape_string($_GET['vnp_BankCode']);
        $vnp_BankTranNo = $db->conn->real_escape_string($_GET['vnp_BankTranNo']);
        $vnp_CardType = $db->conn->real_escape_string($_GET['vnp_CardType']);
        $vnp_OrderInfo = $db->conn->real_escape_string($_GET['vnp_OrderInfo']);
        $vnp_PayDate = $db->conn->real_escape_string($_GET['vnp_PayDate']);
        $vnp_TmCode = $db->conn->real_escape_string($_GET['vnp_TmCode']);
        $vnp_TransactionNo = $db->conn->real_escape_string($_GET['vnp_TransactionNo']);
        $order_code = $db->conn->real_escape_string($_GET['vnp_Txnref']);

        // Chuẩn bị câu lệnh SQL  
        $insert_vnpay = "INSERT INTO vnpay (vnp_amount, vnp_bankcode, vnpay_banktranno, vnp_cardtype, vnp_orderinfo, vnp_paydate, vnp_tmncode, vnp_transactionno, order_code) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->conn->prepare($insert_vnpay);
        if (!$stmt) {
            throw new Exception("Lỗi chuẩn bị câu lệnh: " . $db->conn->error);
        }

        $stmt->bind_param("issssssss", $vnp_Amount, $vnp_BankCode, $vnp_BankTranNo, $vnp_CardType, $vnp_OrderInfo, $vnp_PayDate, $vnp_TmCode, $vnp_TransactionNo, $order_code);

        if (!$stmt->execute()) {
            throw new Exception("Lỗi thực thi câu lệnh: " . $stmt->error);
        }

        $stmt->close();

        // Xóa giỏ hàng sau khi thanh toán thành công (nếu cần)
        unset($_SESSION['cart']);
    }
} catch (Exception $e) {
    die("Đã xảy ra lỗi: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <title>EDEN | Arigatou</title>
    <style>
        body {
            background-color: #f8f9fa;
        }

        .thank-you-container {
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .thank-you-container h1 {
            color: #28a745;
            font-size: 2.5rem;
            font-weight: bold;
        }

        .thank-you-container p {
            font-size: 1.1rem;
            color: #555;
        }

        .thank-you-container .order-code {
            font-size: 1.2rem;
            font-weight: bold;
            color: #007bff;
        }

        .thank-you-container a.btn {
            margin-top: 20px;
            font-size: 1rem;
            font-weight: bold;
        }
    </style>
</head>

<body style="margin-top: 200px;">

    <div class="thank-you-container">
        <h1>Cảm ơn bạn đã đặt hàng!</h1>
        <p>Chúng tôi đã nhận được đơn hàng của bạn. Mã đơn hàng của bạn là:</p>
        <p class="order-code">#<?php if (isset($order_code)) echo $order_code; ?></p>
        <p>Vui lòng kiểm tra email để biết chi tiết về đơn hàng và thời gian giao hàng.</p>
        <p>Nếu có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua:</p>
        <p><strong>Email:</strong> support@eden.com</p>
        <p><strong>Số điện thoại:</strong> 0333268135</p>
        <a href="index.php" class="btn btn-primary">Quay lại trang chủ</a>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>