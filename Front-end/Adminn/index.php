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

$sql_weekly = "SELECT DAYOFWEEK(order_date) AS day_index, SUM(total) AS revenue
               FROM orders
               WHERE WEEK(order_date) = WEEK(CURDATE())
               GROUP BY DAYOFWEEK(order_date)
               ORDER BY DAYOFWEEK(order_date) ASC";

$result_weekly = $conn->query($sql_weekly);

// Khởi tạo các mảng để lưu trữ dữ liệu biểu đồ
$days_of_week = ['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
$weekly_revenues = array_fill(0, 7, 0); // Mảng doanh thu mặc định là 0 cho tất cả các ngày

while ($row = $result_weekly->fetch_assoc()) {
    $weekly_revenues[$row['day_index'] - 1] = $row['revenue']; // Trừ 1 để khớp chỉ số ngày
}

$sql_monthly = "SELECT DAY(order_date) AS day, SUM(total) AS revenue
                FROM orders
                WHERE MONTH(order_date) = MONTH(CURDATE())
                GROUP BY DAY(order_date)
                ORDER BY DAY(order_date) ASC";

$result_monthly = $conn->query($sql_monthly);

// Khởi tạo mảng cho biểu đồ
$days_in_month = range(1, date('t')); // Tạo danh sách ngày trong tháng (1 -> số ngày cuối cùng của tháng)
$monthly_revenues = array_fill(0, count($days_in_month), 0); // Doanh thu mặc định là 0 cho tất cả các ngày

while ($row = $result_monthly->fetch_assoc()) {
    $monthly_revenues[$row['day'] - 1] = $row['revenue']; // Trừ 1 để khớp chỉ số ngày
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
                    <p>Doanh thu trong ngày</p>
                    <p><?php echo number_format($total_revenue_day, 0, ',', '.') . " đ"; ?></p>
                </div>
                <div class="item total-revenue-week">
                    <p>Doanh thu trong tuần</p>
                    <p><?php echo number_format($total_revenue_week, 0, ',', '.') . " đ"; ?></p>
                </div>
                <div class="item total-revenue-month">
                    <p>Doanh thu trong tháng</p>
                    <p><?php echo number_format($total_revenue_month, 0, ',', '.') . " đ"; ?></p>
                </div>
            </div>

            <div class="date-range-form" style="text-align: center; margin: 20px;">
                <form method="GET" action="">
                    <label for="start_date">Từ ngày:</label>
                    <input type="date" id="start_date" name="start_date" required style="border-radius: 5px;"
                        value="<?php echo isset($_GET['start_date']) ? $_GET['start_date'] : ''; ?>">
                    <label for="end_date">Đến ngày:</label>
                    <input type="date" id="end_date" name="end_date" required style="border-radius: 5px;"
                        value="<?php echo isset($_GET['end_date']) ? $_GET['end_date'] : ''; ?>">
                    <button type="submit" class="btn btn-primary" style="margin-left: 10px;">Xem</button>
                </form>
            </div>

            <?php
            // Khởi tạo biến doanh thu trong khoảng tùy chọn
            $total_revenue_custom = 0;

            // Xử lý khi người dùng gửi form
            if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
                $start_date_input = $_GET['start_date'];
                $end_date_input = $_GET['end_date'];

                // --- Bổ sung kiểm tra validation tại đây ---
                // Chuyển đổi sang timestamp để so sánh dễ dàng hơn
                $start_timestamp = strtotime($start_date_input);
                $end_timestamp = strtotime($end_date_input);

                if ($start_timestamp > $end_timestamp) {
                    // Assume showAlertAndRedirect is available from connect.php or product.php includes
                    // If not, you might need to include it or define it here, or use a simple alert.
                    // For consistency with previous interactions, we'll assume it's available.

                    echo "<script>";
                    echo "Swal.fire({";
                    echo "    icon: 'error',";
                    echo "    title: 'Lỗi ngày tháng!',";
                    echo "    text: 'Ngày bắt đầu không được lớn hơn ngày kết thúc.',";
                    echo "    showConfirmButton: true";
                    echo "}).then(function() {";
                    echo "    window.location.href=window.location.pathname;"; // Redirect back to the same page
                    echo "});";
                    echo "</script>";
                    exit(); // Dừng thực thi script nếu ngày không hợp lệ
                }
                // --- Kết thúc phần kiểm tra validation ---

                // Chuyển ngày từ dd/mm/yyyy sang Y-m-d để làm việc với database
                $start_date = date('Y-m-d', $start_timestamp);
                // Để bao gồm cả ngày cuối cùng, set thời gian đến cuối ngày
                $end_date = date('Y-m-d 23:59:59', $end_timestamp);

                // Truy vấn doanh thu cho khoảng thời gian được chọn
                $sql_custom = "SELECT SUM(total) AS total_revenue_custom 
                   FROM orders 
                   WHERE order_date >= '$start_date' AND order_date <= '$end_date'";
                $result_custom = $conn->query($sql_custom);

                if (!$result_custom) {
                    echo "Lỗi truy vấn: " . $conn->error;
                    exit;
                }

                // Lấy doanh thu
                $total_revenue_custom = $result_custom->fetch_assoc()['total_revenue_custom'] ?: 0;

                // Chuyển định dạng ngày sang dd/mm/yyyy
                $start_date_display = date('d/m/Y', strtotime($start_date_input));
                $end_date_display = date('d/m/Y', strtotime($end_date_input));

                // Hiển thị bảng doanh thu
                echo "
        <div class='container'>
            <h5>Doanh thu từ ngày $start_date_display đến ngày $end_date_display</h5>
            <table class='table'>
                <thead>
                    <tr>
                        <th>Khoảng thời gian</th>
                        <th>Tổng doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Từ ngày $start_date_display đến ngày $end_date_display</td>
                        <td>" . number_format($total_revenue_custom, 0, ',', '.') . " đ</td>
                    </tr>
                </tbody>
            </table>
        </div>";
            }
            ?>

            <script>
                // JavaScript để đặt placeholder ban đầu là dd/mm/yyyy
                document.addEventListener("DOMContentLoaded", function() {
                    const inputs = document.querySelectorAll("input[type='date']");
                    inputs.forEach(input => {
                        if (!input.value) {
                            input.placeholder = "dd/mm/yyyy";
                        }
                    });
                });
            </script>


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
                                borderColor: '#333',
                                borderWidth: 2,
                                tension: 0.4
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
            <!-- Biểu đồ doanh thu theo tuần -->
            <div class="chart-container" style="width: 60%; margin: auto; margin-top: 40px;">
                <canvas id="weekly-revenue-line-chart"></canvas>
                <script>
                    var weeklyLineCtx = document.getElementById('weekly-revenue-line-chart').getContext('2d');
                    var weeklyLineChart = new Chart(weeklyLineCtx, {
                        type: 'line', // Loại biểu đồ đường
                        data: {
                            labels: <?php echo json_encode($days_of_week); ?>, // Các ngày trong tuần
                            datasets: [{
                                label: 'Doanh thu',
                                data: <?php echo json_encode($weekly_revenues); ?>, // Doanh thu từng ngày trong tuần
                                backgroundColor: 'rgba(75, 192, 192, 0.2)', // Màu nền dưới đường
                                borderColor: '#333', // Màu đường
                                borderWidth: 2,
                                tension: 0.4 // Độ cong của đường
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Biểu đồ thống kê doanh thu theo tuần'
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
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let value = context.raw || 0;
                                            return value.toLocaleString() + ' đ'; // Format doanh thu VND
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <!-- Biểu đồ doanh thu theo tháng -->
            <div class="chart-container" style="width: 60%; margin: auto; margin-top: 40px;">
                <canvas id="monthly-revenue-line-chart"></canvas>
                <script>
                    var monthlyLineCtx = document.getElementById('monthly-revenue-line-chart').getContext('2d');
                    var monthlyLineChart = new Chart(monthlyLineCtx, {
                        type: 'line', // Loại biểu đồ đường
                        data: {
                            labels: <?php echo json_encode($days_in_month); ?>, // Các ngày trong tháng
                            datasets: [{
                                label: 'Doanh thu',
                                data: <?php echo json_encode($monthly_revenues); ?>, // Doanh thu từng ngày
                                backgroundColor: 'rgba(255, 99, 132, 0.2)', // Màu nền dưới đường
                                borderColor: '#333', // Màu đường
                                borderWidth: 2,
                                tension: 0.4 // Độ cong của đường
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Biểu đồ thống kê doanh thu trong tháng'
                                    },
                                    ticks: {
                                        stepSize: 1 // Hiển thị tất cả các ngày
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
                            },
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let value = context.raw || 0;
                                            return value.toLocaleString() + ' đ'; // Format doanh thu VND
                                        }
                                    }
                                }
                            }
                        }
                    });
                </script>

                <!-- Nút xem PDF -->
                <div style="text-align: center; margin: 20px;">
                    <button id="view-pdf" class="btn btn-danger">Xem PDF</button>
                </div>

                <!-- Thư viện html2pdf.js -->
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>

                <script>
                    document.getElementById('view-pdf').addEventListener('click', function() {
                        // Lấy phần nội dung cần xuất PDF
                        var content = document.getElementById('content');

                        // Tinh chỉnh CSS cho nội dung PDF (căn giữa và cân đối lề)
                        content.style.width = '90%'; // Giới hạn chiều rộng nội dung trong PDF
                        content.style.margin = '0 auto'; // Căn giữa nội dung
                        content.style.textAlign = 'center';

                        // Cấu hình PDF
                        var opt = {
                            margin: [0, 0, 0, 0], // Loại bỏ lề để không ngắt trang
                            filename: 'bao-cao-doanh-thu.pdf', // Tên file PDF
                            image: {
                                type: 'jpeg',
                                quality: 0.98
                            }, // Định dạng hình ảnh
                            html2canvas: {
                                scale: 3,
                                useCORS: true
                            }, // Độ phân giải cao hơn (giúp nội dung sắc nét)
                            jsPDF: {
                                unit: 'px',
                                format: [content.scrollWidth, content.scrollHeight],
                                orientation: 'landscape'
                            } // Kích thước PDF dựa trên kích thước nội dung
                        };

                        // Tạo PDF và mở trong tab mới
                        html2pdf()
                            .set(opt)
                            .from(content)
                            .outputPdf('blob') // Chuyển PDF thành Blob
                            .then(function(pdfBlob) {
                                // Tạo URL tạm thời từ Blob
                                var pdfUrl = URL.createObjectURL(pdfBlob);

                                // Mở URL trong tab mới
                                window.open(pdfUrl, '_blank');
                            });
                    });
                </script>



                </id=>

            </div>
        </div>
</body>

</html>