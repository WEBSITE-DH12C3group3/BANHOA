<?php
session_start();
include '/xampp/htdocs/BANHOA/database/connect.php';
if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header('Location: /BANHOA/Front-end/Customer/dangnhap.php');
    exit();
}
include '/xampp/htdocs/BANHOA/Front-end/Adminn/exit.php';
