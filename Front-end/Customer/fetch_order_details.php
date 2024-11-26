<?php
include '../../database/connect.php'; // Kết nối với cơ sở dữ liệu
$db = new Database();

header('Content-Type: application/json');

try {
    // Lấy dữ liệu từ AJAX
    $input = json_decode(file_get_contents('php://input'), true);

    // Kiểm tra dữ liệu đầu vào
    if (empty($input['order_code']) || empty($input['payment_method'])) {
        echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
        exit;
    }

    $order_code = $db->conn->real_escape_string($input['order_code']);
    $payment_method = strtolower($db->conn->real_escape_string($input['payment_method']));

    // Kiểm tra phương thức thanh toán
    if ($payment_method === 'momo' || $payment_method == 'momo_atm') {
        $query = "SELECT * FROM momo WHERE order_code = ?";
    } elseif ($payment_method === 'vnpay') {
        $query = "SELECT * FROM vnpay WHERE order_code = ?";
    } else {
        echo json_encode(['success' => false, 'message' => 'Phương thức thanh toán không hợp lệ.']);
        exit;
    }

    // Thực thi truy vấn
    $stmt = $db->conn->prepare($query);
    $stmt->bind_param("s", $order_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $details = $result->fetch_assoc();
        echo json_encode(['success' => true, 'details' => $details]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy thông tin với mã đơn hàng này.']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
}
