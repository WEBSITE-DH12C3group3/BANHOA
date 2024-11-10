<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "websitehoa"; // Thay đổi thành tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu từ form
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Kiểm tra nếu có trường nào bị bỏ trống
if(empty($name) || empty($email) || empty($message)) {
    echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location.href = 'contact.html';</script>";
    exit;
}

// Chuẩn bị câu lệnh SQL
$sql = "INSERT INTO contact_submissions (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Câu lệnh SQL không hợp lệ: ' . $conn->error);
}

// Liên kết tham số với câu lệnh SQL
$stmt->bind_param("sss", $name, $email, $message);

// Thực hiện truy vấn
if ($stmt->execute()) {
    echo "<script>alert('Đã gửi thành công!'); window.location.href = 'contact.html';</script>";
} else {
    echo "<script>alert('Gửi thất bại, vui lòng thử lại!'); window.location.href = 'contact.html';</script>";
    echo "Lỗi SQL: " . $stmt->error;
}

// Đóng kết nối
$stmt->close();
$conn->close();
?>
