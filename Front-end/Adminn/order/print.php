<?php
require_once '../../../tFPDF-master/tfpdf.php';
require_once '../../../database/connect.php';

$pdf = new tFPDF();
$db = new Database();
$pdf->AddPage("0");
$pdf->AddFont('DejaVu', '', 'DejaVuSansCondensed.ttf', true);
$pdf->SetFont('DejaVu', '', 15);
$pdf->SetFillColor(193, 229, 252);

// Sử dụng đường dẫn tuyệt đối hoặc __DIR__ để tránh lỗi đường dẫn
$logoPath = __DIR__ . '/../css/logo.png'; //  Hoặc: /đường/dẫn/tuyệt/đối/đến/logo.png
if (!file_exists($logoPath)) {
    echo "Lỗi: File logo không tồn tại: " . $logoPath; // Thông báo lỗi nếu không tìm thấy logo
} else {
    $pdf->Image($logoPath, 10, 10, 30);
}
$pdf->Ln(30);

$code = $_GET['code'];
// Kiểm tra $code:
if (empty($code)) {
    die("Lỗi: Thiếu mã đơn hàng.");
}

$sql = "SELECT * FROM order_items, products 
        WHERE order_items.product_id = products.id AND order_items.order_code = '$code'";
$query_lietke_dh = $db->select($sql);
if (!$query_lietke_dh) {
    die("Lỗi truy vấn SQL: " . mysqli_error($db->conn));
}

$pdf->Write(10, 'Đơn hàng của bạn gồm có:');
$pdf->Ln(10);

$width_cell = array(8, 35, 80, 22, 30, 40);

$pdf->Cell($width_cell[0], 10, 'ID', 1, 0, 'C', true);
$pdf->Cell($width_cell[1], 10, 'Mã hàng', 1, 0, 'C', true);
$pdf->Cell($width_cell[2], 10, 'Tên sản phẩm', 1, 0, 'C', true);
$pdf->Cell($width_cell[3], 10, 'Số lượng', 1, 0, 'C', true);
$pdf->Cell($width_cell[4], 10, 'Giá', 1, 0, 'C', true);
$pdf->Cell($width_cell[5], 10, 'Thành tiền', 1, 1, 'C', true);
$pdf->SetFillColor(235, 236, 236);
$fill = false;
$i = 0;
$total = 0; // Khởi tạo tổng tiền
while ($row = mysqli_fetch_array($query_lietke_dh)) {
    $i++;
    $pdf->Cell($width_cell[0], 10, $i, 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[1], 10, $row['order_code'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[2], 10, $row['product_name'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[3], 10, $row['quantity'], 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[4], 10, number_format($row['price_sale']), 1, 0, 'C', $fill);
    $pdf->Cell($width_cell[5], 10, number_format($row['quantity'] * $row['price_sale']), 1, 1, 'C', $fill);
    $fill = !$fill;
    $total += $row['quantity'] * $row['price_sale']; // Tính tổng tiền
}
$pdf->Ln(5);
$pdf->Write(10, 'Tổng tiền: ' . number_format($total) . ' VND');
$pdf->Ln(10);
$pdf->Write(10, 'Cảm ơn bạn đã đặt hàng tại website của chúng tôi.');
$pdf->Ln(10);
$pdfFileName = 'DonHang_' . $code . '.pdf';
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="' . $pdfFileName . '"');
$pdf->Output('I'); // Hoặc 'D' để download
