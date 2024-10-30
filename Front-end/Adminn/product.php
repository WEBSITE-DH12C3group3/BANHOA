<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
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
                            <a href="/BANHOA/Front-end/Adminn/category.php"><i class="fas fa-list"></i>
                                Quản Lí Danh Mục</a>
                        </li>
                        <li class="active">
                            <a href="/BANHOA/Front-end/Adminn/product.php"><i class="fas fa-box"></i>
                                Quản Lí Sản Phẩm</a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/order.php"><i class="fas fa-shopping-cart"></i>
                                Quản Lí Đơn Hàng</a>
                        </li>
                        <li>
                            <a href="/BANHOA/Front-end/Adminn/ctm.php"><i class="fas fa-user"></i>Quản Lí Khách Hàng</a>
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
                    <a href="#"><i class="fas fa-sign-out-alt"></i><span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </nav>



        <!-- Page Content  -->
        <div id="content">


            <div class="maincontent">

                <div class="search-bar">
                    <input type="text" placeholder="Nhập Từ Khóa Cần Tìm...">
                    <button>Tìm Kiếm</button>
                </div>

                <div class="info-bar">
                    <div class="total-posts">
                        <p>Tổng số sản phẩm: 2</p>
                    </div>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addpro">
                        Thêm sản phẩm
                    </button>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản Phẩm</th>
                            <th>Danh Mục</th>
                            <th>Nổi bật</th>
                            <th>Mới</th>
                            <th>Hiện thị</th>
                            <th>Tác vụ</th>
                        </tr>
                    </thead>
                    <tbody class="img-tb">
                        <tr>
                            <td>1</td>
                            <td><img src="/BANHOA/Front-end/Adminn/img/logo.img.png" alt="Ảnh 1"></td>
                            <td>Hoa 1</td>
                            <td>Hoa cưới</td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox" checked></td>
                            <td>
                                <button class="edit">Sửa</button>
                                <button class="delete">Xóa</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><img src="/BANHOA/Front-end/Adminn/img/logo.img.png" alt="Ảnh 1"></td>
                            <td>Hoa 2</td>
                            <td>Hoa tang</td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox"></td>
                            <td><input type="checkbox" checked></td>
                            <td>
                                <button class="edit">Sửa</button>
                                <button class="delete">Xóa</button>
                            </td>
                        </tr>
                        <!-- Thêm các hàng khác ở đây -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <!-- Modal for Adding Product -->
    <div class="modal fade" id="addpro" tabindex="-1" role="dialog" aria-labelledby="addproLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addproLabel">Thêm Sản Phẩm Mới</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="productName">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" id="productName" name="productName" placeholder="Nhập tên sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label for="productDescription">Mô Tả</label>
                            <textarea class="form-control" id="productDescription" name="productDescription" rows="3" placeholder="Nhập mô tả sản phẩm"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productPrice">Giá</label>
                            <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Nhập giá sản phẩm" required>
                        </div>
                        <div class="form-group">
                            <label for="productCategory">Danh Mục</label>
                            <select class="form-control" id="productCategory" name="productCategory" required>
                                <option value="" disabled selected>Chọn danh mục</option>
                                <option value="electronics">Điện Tử</option>
                                <option value="fashion">Thời Trang</option>
                                <option value="home">Đồ Gia Dụng</option>
                                <option value="beauty">Làm Đẹp</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="productImage">Ảnh Sản Phẩm</label>
                            <input type="file" class="form-control-file" id="productImage" name="productImage">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    <button type="submit" form="addProductForm" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>