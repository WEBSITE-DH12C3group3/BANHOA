<?php
include_once 'connect.php';

$db = new Database();

// Kiểm tra xem có mã đơn hàng trong yêu cầu POST không
if (isset($_POST['order_code'])) {
    $order_code = $_POST['order_code'];

    // Truy vấn để kiểm tra trạng thái đơn hàng
    $query = "SELECT status FROM orders WHERE order_code = '$order_code'";
    $result = $db->select($query);

    if ($result) {
        $order = $result->fetch_assoc();

        // Kiểm tra nếu trạng thái đơn hàng là "chờ duyệt"
        if ($order['status'] == 'Chờ duyệt') {
            // Cập nhật trạng thái đơn hàng thành "Đã hủy"
            $update_query = "UPDATE orders SET status = 'Đã hủy', total = 0 WHERE order_code = '$order_code'";
            $update_result = $db->update($update_query);

            if ($update_result) {
                header("Location: /BANHOA/Front-end/Customer/order_management.php");
            } else {
                echo "Lỗi khi hủy đơn hàng.";
            }
        } else {
            echo "Không thể hủy đơn hàng này vì trạng thái hiện tại không phải là 'chờ duyệt'.";
        }
    } else {
        echo "Mã đơn hàng không tồn tại.";
    }
} else {
    echo "Yêu cầu không hợp lệ.";
}
