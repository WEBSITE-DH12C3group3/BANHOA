<?php
include '../baidautot.php';
$db = new Database();
?>
<!Doctype html>
<html lang="en">

<head>
    <title>EDEN | Danh mục</title>
</head>

<body>
    <div class="wrapper">
        <div class="body-overlay"></div>
        <!-- Sidebar  -->

        <nav id="sidebar" class="bg-light border-right">
            <div class="sidebar-header text-center py-4">
                <a href="/BANHOA/Front-end/Customer/index.php" onclick="return confirm('Trở về website?')">
                    <h3>
                        <img src="/BANHOA/Front-end/Adminn/css/logo.png" class="img-fluid" /><span>EDEN Shop</span>
                    </h3>
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
                        <li class="active">
                            <a href="/BANHOA/Front-end/Adminn/category/category.php"><i class="fas fa-list"></i>
                                <span>Quản Lí Danh Mục</span></a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/product/product.php"><i class="fas fa-box"></i>
                                <span>Quản Lí Sản Phẩm</span></a>
                        </li>
                        <li>
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
                    <a href="/BANHOA/Front-end/Adminn/customer/display_contact.php"><i class="fas fa-comments"></i>
                        <span>Phản Hồi</span></a>
                </li>
                <li class="">
                    <a href="../index.php?act=logout" onclick="return confirm('Bạn có muốn đăng xuất?')"><i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span></a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div class="maincontent" id="content">
            <h2>Danh Sách Danh Mục</h2>
            <div class="search-bar">
                <input type="text" id="searchBox"
                    onkeyup="search()" placeholder="Nhập Từ Khóa Cần Tìm...">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add">
                    Thêm danh mục
                </button>
            </div>

            <div class="info-bar">
                <div class="total-posts">
                    <!-- count -->
                    <p>Tổng số danh mục:
                        <?php $count = $db->count("SELECT * FROM categories");
                        echo $count; ?></p>
                </div>
            </div>

            <table class="table table-bordered" id="Table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 140px;">ID</th>
                        <th scope="col">Tên danh mục</th>
                        <th scope="col" style="width: 120px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM categories ORDER BY id, category_name";
                    $result = $db->select($sql);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['category_name']; ?></td>

                                <td>
                                    <a type="button" class="btn btn-info"
                                        data-toggle="modal"
                                        data-target="#edit"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-category_name="<?php echo $row['category_name']; ?>"
                                        style="color: white;"><i class="fa fa-edit"></i></a>

                                    <a onclick="return confirm('Bạn có muốn xóa?')" href="delcate.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

    <!-- Modal for Editing Category -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Sửa Danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="editcate.php">
                        <div class="form-group">
                            <label for="cateid">Mã Danh mục</label>
                            <input type="text" class="form-control" id="cateid" name="cateid" placeholder="Mã danh mục" value="<?php echo $row['id'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="catename">Tên Danh mục</label>
                            <input type="text" class="form-control" id="catename" name="catename" placeholder="Tên danh mục" required value="<?php echo $row['category_name'] ?>">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="editForm" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var category_name = button.data('category_name');

            // Update the modal's content.
            var modal = $(this);
            modal.find('#cateid').val(id);
            modal.find('#catename').val(category_name);

        });
    </script>


    <!-- Modal for Editing Category -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Thêm Danh mục</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm" method="POST" action="addcate.php">
                        <div class="form-group">
                            <label for="ID">Mã Danh mục</label>
                            <input type="text" class="form-control" id="ID" name="ID" placeholder="Mã danh mục" required>
                        </div>
                        <div class="form-group">
                            <label for="Name">Tên Danh mục</label>
                            <input type="text" class="form-control" id="Name" name="Name" placeholder="Tên danh mục" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="addForm" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <script src="/BANHOA/Front-end/Adminn/css/pagination.js"></script>
</body>

</html>