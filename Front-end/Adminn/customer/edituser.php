<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['customerID']) ? mysqli_real_escape_string($db->conn, $_POST['customerID']) : '';
    $name = isset($_POST['customerName']) ? mysqli_real_escape_string($db->conn, $_POST['customerName']) : '';
    $username = isset($_POST['customerUser']) ? mysqli_real_escape_string($db->conn, $_POST['customerUser']) : '';
    $email = isset($_POST['customerEmail']) ? mysqli_real_escape_string($db->conn, $_POST['customerEmail']) : '';
    $password = isset($_POST['customerPassword']) ? mysqli_real_escape_string($db->conn, $_POST['customerPassword']) : '';
    $phone = isset($_POST['customerPhone']) ? mysqli_real_escape_string($db->conn, $_POST['customerPhone']) : '';
    $address = isset($_POST['customerAddress']) ? mysqli_real_escape_string($db->conn, $_POST['customerAddress']) : '';
    $role = isset($_POST['role']) ? mysqli_real_escape_string($db->conn, $_POST['role']) : '';

    if (empty($id) || empty($name) || empty($username) || empty($email) || empty($password) || empty($phone) || empty($address) || empty($role)) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin!'); window.location.href = 'ctm.php';</script>";
        exit;
    }

    $stmt = $db->conn->prepare("UPDATE users SET fullname=?, user=?, email=?, password=?, phone=?, address=?, role=? WHERE id=?");
    $stmt->bind_param("sssssssi", $name, $username, $email, $password, $phone, $address, $role, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Cập nhật thành công!'); window.location.href = 'ctm.php';</script>";
    } else {
        $error = $stmt->error;
        echo "<script>alert('Lỗi khi cập nhật: ' + '$error'); window.location.href = 'ctm.php';</script>";
    }
    $stmt->close();
}
