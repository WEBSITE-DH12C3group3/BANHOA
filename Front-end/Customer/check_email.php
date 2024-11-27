<?php
include "../../database/connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];

    // Kiểm tra email trong cơ sở dữ liệu
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "exists"; // Email đã tồn tại
    } else {
        echo "not_exists"; // Email chưa tồn tại
    }
}
