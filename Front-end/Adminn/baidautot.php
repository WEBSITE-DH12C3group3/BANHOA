<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once '/xampp/htdocs/BANHOA/database/connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header('Location: /BANHOA/Front-end/Customer/dangnhap.php');
    exit();
}
include_once '/xampp/htdocs/BANHOA/Front-end/Adminn/exit.php';
?>
<!DOCTYPE html>
<html lang="en-vn">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

    <link rel="icon" href="/BANHOA/Front-end/Adminn/css/logo.png" type="image/png">
    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/BANHOA/Front-end/Adminn/css/style.css">
    <!-- Additional JavaScript Libraries -->
    <script src="/BANHOA/Front-end/Adminn/css/search.js"></script>
    <script src="/BANHOA/Front-end/Adminn/css/sale.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const message = urlParams.get('message');
            const title = urlParams.get('title');

            if (status && message && title) {
                Swal.fire({
                    icon: status, // 'success', 'error', 'warning', 'info', 'question'
                    title: title,
                    text: message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                }).then(() => {
                    // Xóa các tham số khỏi URL sau khi hiển thị SweetAlert
                    // Để tránh hiển thị lại khi refresh
                    history.replaceState({}, document.title, window.location.pathname);
                });
            }
        });
    </script>
</head>

<body>
</body>

</html>