<?php
include_once '../baidautot.php';
require_once './approve.php';
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

        <nav id="sidebar" class="bg-light border-right">
            <div class="sidebar-header text-center py-4">
                <a href="/BANHOA/Front-end/Customer/index.php" onclick="return confirm('Trở về website?')">
                    <h3><img src="/BANHOA/Front-end/Adminn/css/logo.png" class="img-fluid" /><span>EDEN Shop</span></h3>
                </a>
            </div>
            <div class="sidebar-header text-center py-2">
                <i class="fas fa-user"></i><span>
                    <?php
                    echo $_SESSION["fullname"];
                    ?>
                </span>
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
                                <span>Quản Lí Danh Mục</span></a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/product/product.php"><i class="fas fa-box"></i>
                                <span>Quản Lí Sản Phẩm</span></a>
                        </li>
                        <li class="active">
                            <a href="/BANHOA/Front-end/Adminn/order/order.php"><i class="fas fa-shopping-cart"></i>
                                <span>Quản Lí Đơn Hàng</span></a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/customer/ctm.php"><i class="fas fa-user"></i>
                                <span>Quản Lí Khách Hàng</span></a>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="/BANHOA/Front-end/Adminn/customer/display_contact.php"><i class="fas fa-comments"></i><span>Phản Hồi</span></a>
                </li>
                <li class="">
                    <a href="../index.php?act=logout" onclick="return confirm('Bạn có muốn đăng xuất?')"><i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span></a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->

        <div class="maincontent" id="content">
            <h2>Danh Sách Đơn hàng</h2>
            <div class="search-bar">
                <input type="text" id="searchBox"
                    onkeyup="search()" placeholder="Nhập Từ Khóa Cần Tìm...">
            </div>

            <div class="info-bar">
                <div class="total-posts">
                    <!-- count -->
                    <p>Tổng số đơn hàng:
                        <?php $count = $db->count("SELECT * FROM orders ORDER BY order_date DESC");
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
                        <th scope="col">Phương thức thanh toán</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT o.id, o.order_code, u.fullname, u.phone, o.order_date, o.total, o.status, o.payment_method
                                FROM orders o
                                JOIN users u ON o.user_id = u.id
                                ORDER BY o.order_date DESC";
                    $result = $db->select($sql);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['order_code']; ?></td>
                                <td><?php echo $row['fullname']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php $row['total'] = number_format($row['total'], 0, ',', '.');
                                    if ($row['status'] == 'Đã duyệt') {
                                        echo $row['total'] . ' ₫';
                                    } elseif ($row['status'] == 'Đã hủy') {
                                        echo 'Đã hủy';
                                    } elseif ($row['status'] == 'Đã nhận') {
                                        echo $row['total'] . ' ₫';
                                    } elseif ($row['status'] == 'Đã thanh toán') {
                                        // Cập nhật tổng tiền và trạng thái đơn hàng trong bảng orders
                                        $update_query = "UPDATE orders SET total = ? WHERE id = ? AND order_code = ?";
                                        $update_stmt = $db->conn->prepare($update_query);
                                        $update_stmt->bind_param("dis", $total, $id, $order_code);
                                        echo $row['total'] . ' ₫';
                                    } else {
                                        echo 'Chờ duyệt';
                                    } ?>
                                </td>
                                <td><?php if ($row['payment_method'] == 'bank') {
                                        echo 'Banking';
                                    } elseif ($row['payment_method'] == 'cash') {
                                        echo 'COD';
                                    } else { ?>
                                        <span class="text-uppercase"><?php echo $row['payment_method']; ?></span>
                                    <?php } ?>
                                </td>
                                <td><?php echo date('h:i:s A d-m-Y', strtotime($row['order_date'])); ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <a href="order_detail.php?code=<?php echo $row['order_code']; ?>&id=<?php echo $row['id']; ?>" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    <a href="#" onclick="confirmDelete(<?php echo $row['id']; ?>);" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    <?php if ($row['status'] === 'Đã duyệt' || $row['status'] === 'Đã thanh toán' || $row['status'] === 'Đã nhận') { ?>
                                        <a href="print.php?code=<?php echo $row['order_code']; ?>" class="btn btn-secondary"><i class="fa fa-print"></i></a>
                                    <?php } ?>
                                    <?php if ($row['status'] === 'Chờ duyệt') { ?>
                                        <a href="#" onclick="confirmApprove(<?php echo $row['id']; ?>, '<?php echo $row['order_code']; ?>');" class="btn btn-success"><i class="fa fa-check-circle"></i></a>
                                    <?php } ?>
                                </td>

                                <script>
                                    function confirmDelete(id) {
                                        Swal.fire({
                                            title: 'Bạn có chắc chắn muốn xóa?',
                                            text: "Hành động này không thể hoàn tác!",
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#d33',
                                            cancelButtonColor: '#3085d6',
                                            confirmButtonText: 'Có, xóa nó!',
                                            cancelButtonText: 'Hủy'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = 'delorder.php?id=' + id;
                                            }
                                        });
                                    }

                                    function confirmApprove(id, orderCode) {
                                        Swal.fire({
                                            title: 'Bạn có muốn duyệt đơn hàng này?',
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#28a745',
                                            cancelButtonColor: '#6c757d',
                                            confirmButtonText: 'Có, duyệt ngay!',
                                            cancelButtonText: 'Hủy'
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = 'approve.php?id=' + id + '&order_code=' + orderCode;
                                            }
                                        });
                                    }
                                </script>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='10'>Không có đơn hàng để cập nhật.</td></tr>";
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