<?php
include 'baidautot.php';
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

        <!-- Page Content  -->
        <div id="content">

            <div class="maincontent">
                <div class="dashboard">

                    <div class="item total-revenue">
                        <p>Tổng doanh thu (Ngày)</p>
                        <p>0 đ</p>
                    </div>
                    <div class="item total-revenue-week">
                        <p>Tổng doanh thu (Tuần)</p>
                        <p>2,740,000 đ</p>
                    </div>
                    <div class="item total-revenue-month">
                        <p>Tổng doanh thu (Tháng)</p>
                        <p>2,740,000 đ</p>
                    </div>
                    <div class="item total-orders">
                        <p>Tổng đơn</p>
                        <p>7</p>
                    </div>
                    <div class="item total-customers">
                        <p>Tổng khách hàng</p>
                        <p>2</p>
                    </div>
                    <div class="item total-products">
                        <p>Tổng sản phẩm</p>
                        <p>9</p>
                    </div>
                    <div class="item total-product-types">
                        <p>Tổng loại sản phẩm</p>
                        <p>8</p>
                    </div>
                </div>

                <div class="chart-section">
                    <div class="chart">
                        <h2>Biểu đồ thống kê Doanh thu</h2>
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="category-statistics">
                        <h2>Thống kê danh mục</h2>
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>



        <!-- <div class="card" style="min-height: 485px">
            </div> -->
    </div>

    <script>
        // Biểu đồ Doanh thu (Cột)
        const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5'],
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: [1200000, 1900000, 3000000, 2500000, 2800000],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Biểu đồ Thống kê danh mục (Tròn)
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctxCategory, {
            type: 'pie',
            data: {
                labels: ['Hoa Đám Tang', 'Hoa Chúc Mừng', 'Hoa Đám Cưới', 'Hoa Bỉ Ngạn Vàng', 'Hoa Để Bàn'],
                datasets: [{
                    label: 'Thống kê danh mục',
                    data: [300000, 500000, 1000000, 1500000, 2000000],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
    </script>

</body>

</html>