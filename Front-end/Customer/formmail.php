<?php
$title = 'Đặt hàng thành công';

$content = '
    <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
        <h2 style="color: #007bff;">Cảm ơn quý khách đã đặt hàng!</h2>
        <p>Quý khách đã đặt hàng thành công với mã đơn hàng: 
            <strong style="color: #28a745;">' . $order_code . '</strong>
        </p>
        <p>Thông tin đơn hàng của quý khách bao gồm:</p>
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #dee2e6; padding: 8px; background-color: #f8f9fa;">Tên sản phẩm</th>
                    <th style="border: 1px solid #dee2e6; padding: 8px; background-color: #f8f9fa;">Giá</th>
                    <th style="border: 1px solid #dee2e6; padding: 8px; background-color: #f8f9fa;">Số lượng</th>
                </tr>
            </thead>
            <tbody>';

foreach ($_SESSION['cart'] as $key => $val) {
    $content .= '
                <tr>
                    <td style="border: 1px solid #dee2e6; padding: 8px;">' . $val['name'] . '</td>
                    <td style="border: 1px solid #dee2e6; padding: 8px;">' . number_format($val['price_sale'], 0, ',', '.') . ' VND</td>
                    <td style="border: 1px solid #dee2e6; padding: 8px; text-align: center;">' . $val['quantity'] . '</td>
                </tr>';
}

$content .= '
            </tbody>
        </table>
        <p style="color: #dc3545; font-weight: bold;">Tổng tiền: ' . number_format($_SESSION['total'], 0, ',', '.') . ' VND</p>
        <p>Nếu quý khách có bất kỳ câu hỏi nào, xin vui lòng liên hệ với chúng tôi qua email hoặc hotline.</p>
        <p>Trân trọng,<br>Đội ngũ cửa hàng của chúng tôi.</p>
    </div>';

$email = $_SESSION['email'];
$mail = new Mailer();
$mail->sendMail($title, $content, $email);

unset($_SESSION['total']);
unset($_SESSION['cart']);
