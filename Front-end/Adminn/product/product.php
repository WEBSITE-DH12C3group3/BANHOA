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
    <title>EDEN | Sản phẩm</title>
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
                        <li class="active">
                            <a href="/BANHOA/Front-end/Adminn/product/product.php"><i class="fas fa-box"></i>
                                Quản Lí Sản Phẩm</a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/order.php"><i class="fas fa-shopping-cart"></i>
                                Quản Lí Đơn Hàng</a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/customer/ctm.php"><i class="fas fa-user"></i>
                                Quản Lí Khách Hàng</a>
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
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add">
                        Thêm sản phẩm
                    </button>
                </div>

                <div class="info-bar">
                    <div class="total-posts">
                        <!-- count -->
                        <p>Tổng số sản phẩm:
                            <?php $count = $db->count("SELECT * FROM products");
                            echo $count; ?></p>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Miêu tả</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Kho</th>
                            <th scope="col">Danh mục</th>
                            <th scope="col" style="width: 137px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT p.id, p.product_name, p.image, p.description, p.price, p.stock, c.category_name
                                FROM products p
                                JOIN categories c ON p.category_id = c.id
                                ORDER BY p.id, p.product_name, c.category_name";
                        $result = $db->select($sql);
                        if ($result) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['image']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['stock']; ?></td>
                                    <td><?php echo $row['category_name']; ?></td>
                                    <td>
                                        <a type=" button" class="btn btn-info"
                                            data-toggle="modal"
                                            data-target="#edit"
                                            data-id="<?php echo $row['id']; ?>"
                                            data-product_name="<?php echo $row['product_name']; ?>"
                                            data-image="<?php echo $row['image']; ?>"
                                            data-description="<?php echo $row['description']; ?>"
                                            data-price="<?php echo $row['price']; ?>"
                                            data-stock="<?php echo $row['stock']; ?>"
                                            data-category_name="<?php echo $row['category_name']; ?>"
                                            style="color: white;">Sửa</a>

                                        <a onclick="return confirm('Bạn có muốn xóa?')" href="delpro.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Xóa</a>
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
            </div>
        </div>
    </div>

    <!-- Modal for Editing Product -->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Sửa Sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST" action="editpro.php">
                        <div class="form-group">
                            <label for="id">Mã Sản phẩm</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Mã sản phẩm" value="<?php echo $row['id'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="product_name">Tên Sản phẩm</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Tên sản phẩm" required value="<?php echo $row['product_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh</label>
                            <input type="text" class="form-control" id="image" name="image" placeholder="URL Hình ảnh" value="<?php echo $row['image'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Mô tả"><?php echo $row['description'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Giá sản phẩm" required value="<?php echo $row['price'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="stock">Số lượng</label>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Số lượng" required value="<?php echo $row['stock'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="category_name">Danh mục</label>
                            <select class="form-control" id="category_name" name="category_id" required>
                                <?php
                                // Truy vấn để lấy các danh mục từ bảng categories
                                $sql = "SELECT id, category_name FROM categories";
                                $result = $db->select($sql);
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['category_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Không có danh mục nào</option>"; // Thêm thông báo nếu không có danh mục
                                }
                                ?>
                            </select>
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
            var product_name = button.data('product_name');
            var image = button.data('image');
            var description = button.data('description');
            var price = button.data('price');
            var stock = button.data('stock');
            var category_name = button.data('category_name');

            // Update the modal's content.
            var modal = $(this);
            modal.find('#id').val(id);
            modal.find('#product_name').val(product_name);
            modal.find('#image').val(image);
            modal.find('#description').val(description);
            modal.find('#price').val(price);
            modal.find('#stock').val(stock);
            modal.find('#category_name').val(category_name);

        });
    </script>


    <!-- Modal for Editing Product -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Sửa Sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm" method="POST" action="addpro.php">
                        <div class="form-group">
                            <label for="product_name">Tên Sản phẩm</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="URL Hình ảnh">
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Mô tả"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Giá sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Số lượng</label>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Số lượng" required>
                        </div>
                        <div class="form-group">
                            <label for="category_name">Danh mục</label>
                            <select class="form-control" id="category_name" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                <?php
                                // Truy vấn để lấy các danh mục từ bảng categories
                                $sql = "SELECT id, category_name FROM categories";
                                $result = $db->select($sql);
                                if ($result) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['category_name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="editForm" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>