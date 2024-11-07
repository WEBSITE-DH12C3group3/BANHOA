<?php
include '../baidautot.php';
$db = new Database();
?>
<!Doctype html>
<html lang="en">

<head>
    <title>EDEN | Đơn hàng</title>

    <!-- Additional JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/BANHOA/Front-end/Adminn/css/search.js"></script>
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
            <div class="sidebar-header">
                <a href=""> <i class="fas fa-user"></i><span>
                        <?php
                        echo $_SESSION["fullname"];
                        ?>
                    </span></a>
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
                    <a href="../index.php?act=logout" onclick="return confirm('Bạn có muốn đăng xuất?')"><i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span></a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->

        <div class="maincontent" id="content">

            <div class="search-bar">
                <input type="text" id="searchBox"
                    onkeyup="search()" placeholder="Nhập Từ Khóa Cần Tìm...">
            </div>

            <div class="info-bar">
                <div class="total-posts">
                    <!-- count -->
                    <p>Tổng số đơn hàng:
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
                        <th scope="col">Hành động</th>
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
                                <td><?php echo $row['total']; ?>₫</td>
                                <td><?php echo $row['order_date']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <a href="order_detail.php?code=<?php echo $row['order_code']; ?>&id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <a onclick="return confirm('Bạn có muốn xóa?')" href="delorder.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    <?php if ($row['status'] != 'Đã duyệt') { ?>
                                        <a onclick="return confirm('Bạn có muốn duyệt?')" href="approve.php?id=<?php echo $row['id']; ?>" class="btn btn-success"><i class="fa fa-check-circle"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php
                        }
                        $order_query = "SELECT id FROM orders";
                        $order_result = $db->select($order_query);

                        if ($order_result) {
                            while ($order = $order_result->fetch_assoc()) {
                                $order_id = $order['id'];

                                // Tính tổng tiền cho mỗi đơn hàng dựa trên các sản phẩm trong order_items
                                $item_query = "SELECT p.price_sale, oi.quantity 
                       FROM order_items oi
                       JOIN products p ON oi.product_id = p.id
                       WHERE oi.order_id = ?";

                                $stmt = $db->conn->prepare($item_query);
                                $stmt->bind_param("i", $order_id);
                                $stmt->execute();
                                $item_result = $stmt->get_result();

                                $total = 0;
                                if ($item_result) {
                                    while ($item = $item_result->fetch_assoc()) {
                                        $total += $item['price_sale'] * $item['quantity'];
                                    }
                                }

                                // Cập nhật tổng tiền cho đơn hàng hiện tại trong bảng orders
                                $update_query = "UPDATE orders SET total = ? WHERE id = ?";
                                $update_stmt = $db->conn->prepare($update_query);
                                $update_stmt->bind_param("di", $total, $order_id);
                                $update_stmt->execute();

                                // echo "Đã cập nhật tổng tiền cho đơn hàng ID: $order_id thành công!<br>";
                            }
                        } else {
                            echo "Không có đơn hàng nào để cập nhật.";
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


    <script src="/BANHOA/Front-end/Adminn/css/pagination.js"></script>
</body>

</html>