<?php
include '../baidautot.php';
$db = new Database();
?>
<!Doctype html>
<html lang="en">

<head>
    <title>EDEN | Sản phẩm</title>
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
                        <li class="active">
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
            <h2>Danh Sách Sản Phẩm</h2>
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

            <table class="table table-bordered" id="Table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Miêu tả</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Sale</th>
                        <th scope="col">Kho</th>
                        <th scope="col">Đã bán</th>
                        <th scope="col">Nổi bật</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col" style="width: 120px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT p.id, p.product_name, p.image, p.description, p.price, p.sale, p.stock, p.remark, c.category_name, p.category_id, p.sold
                                FROM products p
                                JOIN categories c ON p.category_id = c.id
                                ORDER BY p.id, p.product_name, c.category_name";
                    $result = $db->select($sql);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><img src="../uploads/<?php echo $row['image']; ?>" alt="product image" width="100px" height="auto"></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo number_format($row['price'], 0, ',', '.'); ?>₫</td>
                                <td><?php echo $row['sale']; ?>%</td>
                                <td><?php echo $row['stock']; ?></td>
                                <td><?php if (!$row['sold']) echo "0";
                                    else echo $row['sold']; ?></td>
                                <td><?php if ($row['remark'] == 1) echo "Có";
                                    else echo "Không"; ?></td>
                                <td><?php echo $row['category_name']; ?></td>
                                <td>
                                    <a type="button" class="btn btn-info"
                                        data-toggle="modal"
                                        data-target="#edit"
                                        data-id="<?php echo $row['id']; ?>"
                                        data-product_name="<?php echo $row['product_name']; ?>"
                                        data-image="<?php echo $row['image']; ?>"
                                        data-description="<?php echo $row['description']; ?>"
                                        data-price="<?php echo $row['price']; ?>"
                                        data-sale="<?php echo $row['sale']; ?>"
                                        data-stock="<?php echo $row['stock']; ?>"
                                        data-remark="<?php echo $row['remark']; ?>"
                                        data-category_id="<?php echo $row['category_id']; ?>"
                                        style="color: white;"><i class="fa fa-edit"></i></a>
                                    <a onclick="return confirm('Bạn có muốn xóa?')" href="delpro.php?id=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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

    <!-- Modal for Addting Product -->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Thêm Sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addForm" method="POST" action="addpro.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="product_name">Tên Sản phẩm</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="URL Hình ảnh" accept="image/*" required>
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
                            <label for="sale">Sale (%)</label>
                            <input type="number" class="form-control" id="sale" name="sale" placeholder="Giảm giá" required min="0" max="99" step="1" />
                        </div>
                        <div class="form-group">
                            <label for="stock">Số lượng</label>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Số lượng" required>
                        </div>
                        <div class="form-group">
                            <label for="remark">Nổi bật</label>
                            <select class="form-control" name="remark" id="remark" required>
                                <option value="">Chọn kiểu</option>
                                <option value="0">Không nổi bật</option>
                                <option value="1">Nổi bật</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Danh mục</label>
                            <select class="form-control" id="category_id" name="category_id" required>
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
                    <button type="submit" form="addForm" class="btn btn-primary">Thêm</button>
                </div>
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
                    <form id="editForm" method="POST" action="editpro.php" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="id">Mã Sản phẩm</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Mã sản phẩm" value="<?php echo $row['id'] ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="product_name">Tên Sản phẩm</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Tên sản phẩm" required value="<?php echo $row['product_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="image">Hình ảnh hiện tại</label><br />
                            <img id="image" src="../uploads/<?php echo $row['image']; ?>" alt="Current image" width="150px" height="auto"><br />
                            <label for="image">Chọn hình ảnh mới (nếu muốn thay đổi):</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="URL Hình ảnh" accept="image/*">
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
                            <label for="sale">Sale (%)</label>
                            <input type="number" class="form-control" id="sale" name="sale" placeholder="Giảm giá" required value="<?php echo $row['sale'] ?>" min="0" max="99" step="1">
                        </div>
                        <div class="form-group">
                            <label for="stock">Số lượng</label>
                            <input type="number" class="form-control" id="stock" name="stock" placeholder="Số lượng" required value="<?php echo $row['stock'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="remark">Nổi bật</label>
                            <select class="form-control" name="remark" id="remark" required>
                                <option value="0">Không nổi bật</option>
                                <option value="1">Nổi bật</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category_id">Danh mục</label>
                            <select class="form-control" id="category_id" name="category_id" required>
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
            var image = button.data('image'); // Lấy URL hình ảnh từ data-* attributes
            var description = button.data('description');
            var price = button.data('price');
            var sale = button.data('sale');
            var stock = button.data('stock');
            var remark = button.data('remark');
            var category_id = button.data('category_id'); // Lấy danh mục từ data-* attributes
            // Update the modal's content.
            var modal = $(this);
            modal.find('#id').val(id);
            modal.find('#product_name').val(product_name);
            modal.find('#image').attr('src', '../uploads/' + image); // Cập nhật URL hình ảnh trong modal
            modal.find('#description').val(description);
            modal.find('#price').val(price);
            modal.find('#sale').val(sale);
            modal.find('#stock').val(stock);
            modal.find('#remark').val(remark); // Cập nhật giá trị nổi bật trong modal
            modal.find('#category_id').val(category_id); // Cập nhật danh mục trong modal
        });
    </script>
    <script src="/BANHOA/Front-end/Adminn/css/pagination.js"></script>
</body>

</html>