<?php
include 'baidautot.php';  // Bao gồm file chứa lớp Database

// Khởi tạo đối tượng Database
$db = new Database();
$conn = $db->conn;  // Lấy kết nối từ thuộc tính conn của đối tượng

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối không thành công.");
}

// Ví dụ thực hiện tính toán doanh thu
$sql = "SELECT SUM(total) AS total_revenue_day FROM orders WHERE DATE(order_date) = CURDATE()";
$result = $conn->query($sql);
$total_revenue_day = $result->fetch_assoc()['total_revenue_day'] ?? 0;

$sql_week = "SELECT SUM(total) AS total_revenue_week FROM orders WHERE WEEK(order_date) = WEEK(CURDATE())";
$result_week = $conn->query($sql_week);
$total_revenue_week = $result_week->fetch_assoc()['total_revenue_week'] ?? 0;

$sql_month = "SELECT SUM(total) AS total_revenue_month FROM orders WHERE MONTH(order_date) = MONTH(CURDATE())";
$result_month = $conn->query($sql_month);
$total_revenue_month = $result_month->fetch_assoc()['total_revenue_month'] ?? 0;
?>

<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>EDEN Shop</title>
    <link rel="icon" href="/BANHOA/Front-end/Adminn/img/logo.png" type="image/png">
    <!-- CSS Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <!-- Additional JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="/BANHOA/Front-end/Adminn/css/style.css">
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <!-- Sidebar  -->
        <nav id="sidebar" class="act">
            <div class="sidebar-header">
                <a href="index.php">
                    <h3><img src="/BANHOA/Front-end/Adminn/img/logo.png" class="img-fluid" /><span>EDEN Shop</span></h3>
                </a>
            </div>
            <div class="sidebar-header">
                <a href=""> <i class="fas fa-user"></i><span>
                        <?php
                        echo $_SESSION["fullname"];
                        ?>
                    </span></a>
            </div>
            <ul class="list-unstyled components">
                <li class="active">
                    <a href="/BANHOA/Front-end/Adminn/index.php">
                        <i class="fas fa-chart-bar"></i><span>Thống kê</span></a>
                </li>
                <li class="dropdown">
                    <a href="#subm" class="dropdown-toggle">
                        <i class="fas fa-th-large"></i><span>Quản Lí</span></a>
                    <ul class="collapse list-unstyled menu" id="subm">
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/category/category.php"><i class="fas fa-list"></i>
                                Quản Lí Danh Mục</a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/product/product.php"><i class="fas fa-box"></i>
                                Quản Lí Sản Phẩm</a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/order/order.php"><i class="fas fa-shopping-cart"></i>
                                Quản Lí Đơn Hàng</a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/customer/ctm.php"><i class="fas fa-user"></i>Quản Lí Khách Hàng</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="#"><i class="fas fa-comments"></i><span>Phản Hồi</span></a>
                </li>
                <li class="">
                    <a href="index.php?act=logout" onclick="return confirm('ả diu sua?')"><i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span></a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <!-- Hiển thị các mục doanh thu cố định (Ngày, Tuần, Tháng) -->
            <div class="maincontent">
                <div class="dashboard">
                    <div class="item total-revenue">
                        <p>Tổng doanh thu (Ngày)</p>
                        <p><?php echo number_format($total_revenue_day, 0, ',', '.') . " đ"; ?></p>
                    </div>
                    <div class="item total-revenue-week">
                        <p>Tổng doanh thu (Tuần)</p>
                        <p><?php echo number_format($total_revenue_week, 0, ',', '.') . " đ"; ?></p>
                    </div>
                    <div class="item total-revenue-month">
                        <p>Tổng doanh thu (Tháng)</p>
                        <p><?php echo number_format($total_revenue_month, 0, ',', '.') . " đ"; ?></p>
                    </div>
                </div>
            </div>

            <!-- Form chọn khoảng thời gian (đặt ở dưới cùng) -->
            <div class="date-range-form" id="content">
                <form method="GET" action="">
                    <label for="start_date">Từ ngày:</label>
                    <input type="date" id="start_date" name="start_date" required>

                    <label for="end_date">Đến ngày:</label>
                    <input type="date" id="end_date" name="end_date" required>

                    <button type="submit">Xem doanh thu</button>
                </form>
            </div>

            <?php
            // Khởi tạo biến doanh thu trong khoảng tùy chọn
            $total_revenue_custom = 0;

            // Xử lý khi người dùng gửi form
            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                $start_date = $_GET['start_date'];
                $end_date = $_GET['end_date'];

                // Truy vấn doanh thu cho khoảng thời gian được chọn
                $sql_custom = "SELECT SUM(total) AS total_revenue_custom 
                       FROM orders 
                       WHERE order_date BETWEEN '$start_date' AND '$end_date'";
                $result_custom = $conn->query($sql_custom);
                $total_revenue_custom = $result_custom->fetch_assoc()['total_revenue_custom'] ?? 0;

                // Hiển thị bảng doanh thu cho khoảng thời gian tùy chọn
                echo "
        <div class='custom-revenue'>
            <h3>Doanh thu từ ngày $start_date đến ngày $end_date</h3>
            <table class='table'>
                <thead>
                    <tr>
                        <th>Khoảng thời gian</th>
                        <th>Tổng doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Từ ngày " . date('d-m-Y', strtotime($start_date)) . " đến ngày " . date('d-m-Y', strtotime($end_date)) . "</td>
                        <td>" . number_format($total_revenue_custom, 0, ',', '.') . " đ</td>
                    </tr>
                </tbody>
            </table>
        </div>";
            }
            ?>
        </div>





        <!-- <div class="card" style="min-height: 485px">
            </div> -->
    </div>



</body>

</html>