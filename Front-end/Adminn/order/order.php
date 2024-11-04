<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
$db = new Database();
?>
<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>EDEN | Đơn hàng</title>
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
    <script src="/BANHOA/Front-end/Adminn/css/search.js"></script>
    <link rel="stylesheet" href="/BANHOA/Front-end/Adminn/css/style.css">
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <!-- Sidebar  -->

        <nav id="sidebar">
            <div class="sidebar-header">
                <a href="/BANHOA/Front-end/Adminn/index.php">
                    <h3><img src="/BANHOA/Front-end/Adminn/img/logo.png" class="img-fluid" /><span>EDEN Shop</span></h3>
                </a>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="/BANHOA/Front-end/Adminn/index.php">
                        <i class="fas fa-chart-bar"></i><span>Thống kê</span></a>
                </li>

                <li class="dropdown">
                    <a href="#subm" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
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
                        <li class="active">
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
                    <a href="#"><i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span></a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">

            <div class="maincontent">

                <div class="search-bar">
                    <input type="text" id="searchBox"
                        onkeyup="search()" placeholder="Nhập Từ Khóa Cần Tìm...">
                </div>

                <div class="info-bar">
                    <div class="total-posts">
                        <!-- count -->
                        <p>Tổng số khách hàng:
                            <?php $count = $db->count("SELECT * FROM orders");
                            echo $count; ?></p>
                    </div>
                </div>

                <table class="table table-bordered" id="Table">
                    <thead>
                        <tr>
                            <th scope="col">Mã đơn</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Tổng tiền</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col" style="width: 145x;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT o.id, o.order_code, u.fullname, u.phone, o.order_date, o.total, o.status
                                FROM orders o
                                JOIN users u ON o.user_id = u.id
                                ORDER BY o.id, o.order_code";
                        $result = $db->select($sql);
                        if ($result) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['order_code']; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['total']; ?></td>
                                    <td><?php echo $row['order_date']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                    <td>
                                        <a type="button" href="" class="btn btn-success" style="color: white;">Duyệt</a>
                                        <a onclick="return confirm('Bạn có muốn xóa?')" href="delorder.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Xóa</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='10'>Không có kết quả!</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <div id="noResult" style="display: none;">Không tìm thấy kết quả phù hợp.</div>
                <div class="pagination-container" style="display: flex; justify-content: center;">
                    <div class="pagination" id="pagination" style="align-self: center;">
                    </div>
                </div>

            </div>
        </div>
    </div>


    <script src="/BANHOA/Front-end/Adminn/css/pagination.js"></script>
</body>

</html>