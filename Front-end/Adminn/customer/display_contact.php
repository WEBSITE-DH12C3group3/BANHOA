<?php
include '../baidautot.php';
$db = new Database();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM contact_submissions WHERE id = $id";
    $db->delete($sql);
    header("Location: display_contact.php");
}
?>
<!Doctype html>
<html lang="en">

<head>
    <title>EDEN | Khách hàng</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
                            <a href="/BANHOA/Front-end/Adminn/customer/ctm.php"><i class="fas fa-user"></i>
                                Quản Lí Khách Hàng</a>
                        </li>
                    </ul>
                </li>

                <li class="" class="active">
                    <a href="display_contact.php"><i class="fas fa-comments"></i><span>Phản Hồi</span></a>
                </li>

                <li class="">
                    <a href="../index.php?act=logout" onclick="return confirm('Bạn có muốn đăng xuất?')"><i class="fas fa-sign-out-alt"></i>
                        <span>Đăng xuất</span></a>
                </li>
            </ul>
        </nav>

        <div class="maincontent" id="content">
            <h2>Danh Sách Liên Hệ</h2>
            <table class="table table-bordered" id="Table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Nội dung liên hệ</th>
                        <th>Ngày gửi</th>
                        <th>Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM contact_submissions ORDER BY submitted_at DESC";
                    $result = $db->select($sql);
                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['message'] . "</td>";
                            echo "<td>" . date('h:i:s A d-m-Y', strtotime($row['submitted_at'])) . "</td>";
                            echo "<td><a class='btn btn-danger'href='display_contact.php?id=" . $row['id'] . "' onclick='return confirm(\"Bạn có chắc muốn xóa liên hệ này?\")'><i class='fa fa-trash'></i></a>";
                            echo "<a class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#replyModal' data-id='" . $row['id'] . "' data-email='" . $row['email'] . "'>Phản hồi</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>Không có kết quả!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal phản hồi -->
        <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="replyModalLabel">Gửi Phản Hồi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="send_feedback.php" method="post">
                            <input type="hidden" name="contact_id" id="contactId">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="contactEmail" name="email" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Nội dung phản hồi</label>
                                <textarea class="form-control" id="replyMessage" name="message" rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Gửi phản hồi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Xử lý khi modal mở
            const replyModal = document.getElementById('replyModal');
            replyModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const email = button.getAttribute('data-email');

                // Gắn dữ liệu cho modal
                document.getElementById('contactId').value = id;
                document.getElementById('contactEmail').value = email;
            });
        </script>
        <script>
            $('#edit').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                var fullname = button.data('fullname');
                var email = button.data('email');
                var password = button.data('password');
                var phone = button.data('phone');
                var address = button.data('address');
                var role = button.data('role');
                // Update the modal's content.
                var modal = $(this);
                modal.find('#customerID').val(id);
                modal.find('#customerName').val(fullname);
                modal.find('#customerEmail').val(email);
                modal.find('#customerPassword').val(password);
                modal.find('#customerPhone').val(phone);
                modal.find('#customerAddress').val(address);
                modal.find('#role').val(role);
            });
        </script>

        <script src="/BANHOA/Front-end/Adminn/css/pagination.js"></script>
</body>

</html>