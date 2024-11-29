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

// Truy vấn doanh thu theo giờ trong ngày (bao gồm tất cả các giờ từ 0h đến 23h)
$sql_hourly = "SELECT HOUR(order_date) AS hour, SUM(total) AS revenue
               FROM orders
               WHERE DATE(order_date) = CURDATE()
               GROUP BY HOUR(order_date)
               ORDER BY hour ASC";

$result_hourly = $conn->query($sql_hourly);

// Khởi tạo các mảng để lưu trữ dữ liệu biểu đồ
$hours = range(0, 23);  // Tạo mảng từ 0 đến 23 cho trục X
$revenues = array_fill(0, 24, 0);  // Mảng doanh thu mặc định là 0 cho tất cả các giờ

while ($row = $result_hourly->fetch_assoc()) {
    $revenues[$row['hour']] = $row['revenue'];  // Lưu doanh thu cho từng giờ
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>EDEN Shop</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Cải thiện giao diện biểu đồ */
        .chart-container {
            width: 80%;
            margin: auto;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 40px;
        }

        /* Tăng chiều cao của biểu đồ */
        #hourly-revenue-chart {
            height: 400px;
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        /* Tùy chỉnh tiêu đề biểu đồ */
        .chart-container h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
        }



        /* Tùy chỉnh form chọn khoảng thời gian */
        .date-range-form {
            margin: 20px 0;
            padding: 10px;
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <!-- Sidebar -->
        <nav id="sidebar" class="bg-light border-right">
            <!-- Logo and Title -->
            <div class="sidebar-header text-center py-4">
                <a href="/BANHOA/Front-end/Customer/index.php" onclick="return confirm('Trở về website?')">
                    <h3><img src="/BANHOA/Front-end/Adminn/css/logo.png" class="img-fluid" /><span>EDEN Shop</span></h3>
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
                <li class="active">
                    <a href="/BANHOA/Front-end/Adminn/index.php"><i class="fas fa-chart-bar"></i><span>Thống kê</span></a>
                </li>
                <li class="dropdown">
                    <a href="#subm" class="dropdown-toggle" data-toggle="collapse" aria-expanded="false"><i class="fas fa-th-large"></i><span>Quản Lí</span>
                    </a>
                    <ul class="collapse list-unstyled menu" id="subm">
                        <li><a href="/BANHOA/Front-end/Adminn/category/category.php"><i class="fas fa-list"></i> Quản Lí Danh Mục</a></li>
                        <li><a href="/BANHOA/Front-end/Adminn/product/product.php"><i class="fas fa-box"></i> Quản Lí Sản Phẩm</a></li>
                        <li><a href="/BANHOA/Front-end/Adminn/order/order.php"><i class="fas fa-shopping-cart"></i> Quản Lí Đơn Hàng</a></li>
                        <li><a href="/BANHOA/Front-end/Adminn/customer/ctm.php"><i class="fas fa-user"></i> Quản Lí Khách Hàng</a></li>
                    </ul>
                </li>
                <li><a href="/BANHOA/Front-end/Adminn/customer/display_contact.php"><i class="fas fa-comments"></i> Phản Hồi</a></li>
                <li><a href="index.php?act=logout" onclick="return confirm('Bạn có muốn đăng xuất?')"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a></li>
            </ul>
        </nav>

        <div class="maincontent" id="content">
            <!-- Hiển thị các mục doanh thu cố định (Ngày, Tuần, Tháng) -->
            <style>
                .total-revenue {
                    border-left: 10px solid #8BC34A;
                }

                .total-revenue-week {
                    border-left: 10px solid #2196F3;
                }

                .total-revenue-month {
                    border-left: 10px solid #FFC107;
                }
            </style>
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

            <!-- Form chọn khoảng thời gian -->
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
                $start_date = date('Y-m-d', strtotime($_GET['start_date']));
                $end_date = date('Y-m-d', strtotime($_GET['end_date']));

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
                        <table class='table' style='border-collapse: collapse; border: 1px solid #ddd;'>
                            <thead>
                                <tr>
                                    <th>Khoảng thời gian</th>
                                    <th>Tổng doanh thu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Từ ngày " . $start_date . " đến ngày " . $end_date . "</td>
                                    <td>" . number_format($total_revenue_custom, 0, ',', '.') . " đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>";
            }
            ?>

            <!-- Biểu đồ doanh thu theo giờ -->
            <div class="chart-container" style="width: 60%; margin: auto;">
                <canvas id="hourly-revenue-chart"></canvas>
                <script>
                    var ctx = document.getElementById('hourly-revenue-chart').getContext('2d');
                    var chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($hours); ?>, // Giờ trong ngày từ 0h đến 23h
                            datasets: [{
                                label: 'Doanh thu',
                                data: <?php echo json_encode($revenues); ?>, // Doanh thu từng giờ
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Biểu đồ thống kê doanh thu trong ngày'
                                    },
                                    ticks: {
                                        beginAtZero: true
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Doanh thu (VND)'
                                    },
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</body>

</html>