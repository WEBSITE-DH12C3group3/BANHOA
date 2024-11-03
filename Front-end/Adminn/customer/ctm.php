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
    <title>EDEN | Khách hàng</title>
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

                <li>
                    <a href="" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-bell"></i><span>Thông Báo</span></a>
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
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/order/order.php"><i class="fas fa-shopping-cart"></i>
                                Quản Lí Đơn Hàng</a>
                        </li>
                        <li class="active">
                            <a href="/BANHOA/Front-end/Adminn/customer/ctm.php"><i class="fas fa-user"></i>Quản Lí Khách Hàng</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="" data-toggle="collapse" aria-expanded="false">
                        <i class="fas fa-percent"></i><span>Khuyến Mãi</span></a>
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
                            <?php $count = $db->count("SELECT * FROM users");
                            echo $count; ?></p>
                    </div>
                </div>

                <table class="table table-bordered" id="Table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Email</th>
                            <th scope="col">Mật khẩu</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Địa chỉ</th>
                            <th scope="col">Vai trò</th>
                            <th scope="col">Ngày tạo</th>
                            <th scope="col" style="width: 137px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM users ORDER BY id, fullname";
                        $result = $db->select($sql);
                        if ($result) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['password']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php echo $row['role']; ?></td>
                                    <td><?php echo $row['created_at']; ?></td>
                                    <td>
                                        <a type="button" class="btn btn-info"
                                            data-toggle="modal"
                                            data-target="#edit"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-fullname="<?php echo $row['fullname']; ?>"
                                            data-email="<?php echo $row['email']; ?>"
                                            data-password="<?php echo $row['password']; ?>"
                                            data-phone="<?php echo $row['phone']; ?>"
                                            data-address="<?php echo $row['address']; ?>" style="color: white;">Sửa</a>

                                        <a onclick="return confirm('Bạn có muốn xóa?')" href="deluser.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Xóa</a>
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

    <!-- Modal for Editing Customer -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editcLabel">Sửa Khách Hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="edituser.php">
                        <div class="form-group">
                            <label for="customerName">Mã Khách Hàng</label>
                            <input type="text" class="form-control" id="customerID" name="customerID" placeholder="Mã khách hàng" value="<?php echo $row['id'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="customerName">Tên Khách Hàng</label>
                            <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Tên khách hàng" required value="<?php echo $row['fullname'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="customerEmail">Email</label>
                            <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="Nhập email" required value="<?php echo $row['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="customerPassword">Mật Khẩu</label>
                            <input type="password" class="form-control" id="customerPassword" name="customerPassword" placeholder="Nhập mật khẩu" required value="<?php echo $row['password'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="customerPhone">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="customerPhone" name="customerPhone" placeholder="Nhập số điện thoại" required value="<?php echo $row['phone'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="customerAddress">Địa Chỉ</label>
                            <input type="text" class="form-control" id="customerAddress" name="customerAddress" placeholder="Nhập địa chỉ" required value="<?php echo $row['address'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="role">Vai trò</label>
                            <select class="form-control" name="role" id="role" required>
                                <option value="customer">Customer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="editForm" class="btn btn-primary">Lưu Khách Hàng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var fullname = button.data('fullname');
            var email = button.data('email');
            var password = button.data('password');
            var phone = button.data('phone');
            var address = button.data('address');

            // Update the modal's content.
            var modal = $(this);
            modal.find('#customerID').val(id);
            modal.find('#customerName').val(fullname);
            modal.find('#customerEmail').val(email);
            modal.find('#customerPassword').val(password);
            modal.find('#customerPhone').val(phone);
            modal.find('#customerAddress').val(address);
        });
    </script>

    <script src="/BANHOA/Front-end/Adminn/css/pagination.js"></script>
</body>

</html>