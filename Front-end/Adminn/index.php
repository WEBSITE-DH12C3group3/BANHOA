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
    <title>EDEN Shop</title>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-light border-right">
            <!-- Logo and Title -->
            <div class="sidebar-header text-center py-4">
                <a href="index.php">
                    <h3><img src="/BANHOA/Front-end/Adminn/img/logo.png" class="img-fluid" /><span>EDEN Shop</span></h3>
                </a>
            </div>

            <!-- User Info -->
            <div class="sidebar-header text-center py-2">
                <i class="fas fa-user"></i>
                <span>
                    <?php echo $_SESSION["fullname"]; ?>
                </span>
            </div>

            <!-- Menu Items -->
            <ul class="list-unstyled components">
                <!-- Dashboard -->
                <li class="active">
                    <a href="/BANHOA/Front-end/Adminn/index.php"><i class="fas fa-chart-bar"></i><span>Thống kê</span></a>
                </li>

                <!-- Management Dropdown -->
                <li class="dropdown">
                    <a href="#subm" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false"><i class="fas fa-th-large"></i><span>Quản Lí</span>
                    </a>
                    <ul class="collapse list-unstyled menu" id="subm">
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/category/category.php">
                                <i class="fas fa-list"></i>
                                Quản Lí Danh Mục
                            </a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/product/product.php">
                                <i class="fas fa-box"></i>
                                Quản Lí Sản Phẩm
                            </a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/order/order.php">
                                <i class="fas fa-shopping-cart"></i>
                                Quản Lí Đơn Hàng
                            </a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/customer/ctm.php">
                                <i class="fas fa-user"></i>
                                Quản Lí Khách Hàng
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Feedback -->
                <li>
                    <a href="#"><i class="fas fa-comments"></i><span>Phản Hồi</span></a>
                </li>

                <!-- Logout -->
                <li>
                    <a href="index.php?act=logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất không?')">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </nav>

        <div lass="maincontent" id="content">
            <!-- Hiển thị các mục doanh thu cố định (Ngày, Tuần, Tháng) -->
            <div>
                <div class="dashboard" style="margin-left: 60px;">
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
            <div class="date-range-form" style="text-align: center; margin: 20px;">
                <form method="GET" action="">
                    <label for="start_date">Từ ngày:</label>
                    <input type="date" id="start_date" name="start_date" required style="border-radius: 5px;">

                    <label for="end_date">Đến ngày:</label>
                    <input type="date" id="end_date" name="end_date" required style="border-radius: 5px;">

                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Xem</button>
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
        <div class='container'>
            <h5 style='text-align: center;'>Doanh thu từ ngày $start_date đến ngày $end_date</h5>
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