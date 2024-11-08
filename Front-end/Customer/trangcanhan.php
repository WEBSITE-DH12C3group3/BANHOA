<?php
include 'header.php';

// Khởi tạo đối tượng Database
$db = new Database();

// Giả sử bạn đã đăng nhập và có user_id của người dùng
$user_id = $_SESSION['users_id'];

// Truy vấn thông tin người dùng từ bảng users
$query = "SELECT fullname, email, phone, address FROM users WHERE id = $user_id";
$result = $db->select($query);

if ($result) {
    $user = $result->fetch_assoc();
} else {
    echo "Không tìm thấy thông tin người dùng.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <!-- Bootstrap CSS -->
    <style>
        body {
            background-color: #f7f7f7;
        }

        .account-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .account-sidebar {
            background-color: #343a40;
            color: white;
            padding: 15px;
            border-radius: 8px;
        }

        .account-sidebar ul {
            list-style: none;
            padding: 0;
        }

        .account-sidebar ul li {
            margin-bottom: 15px;
        }

        .account-sidebar ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .account-sidebar ul li a:hover {
            color: #d8243c;
        }

        .account-details {
            padding: 20px;
        }

        .account-details label {
            font-weight: 500;
        }

        .account-details input,
        .account-details select {
            background-color: #f7f7f7;
            border-color: #ccc;
        }

        .btn-save {
            background-color: #28a745;
            color: white;
            border-radius: 25px;
        }

        .btn-save:hover {
            background-color: #218838;
        }

        .btn-save i {
            margin-right: 5px;
        }

        .form-select,
        .form-control {
            background-color: #fff;
            border: 1px solid #ced4da;
            padding: 10px;
            font-size: 16px;
            color: #495057;
            border-radius: 4px;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-select:focus,
        .form-control:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.25);
            border-color: #80bdff;
        }

        .btn-save {
            background-color: #d8242c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-save:hover {
            background-color: red;
            color: white;
        }

        .form-group label {
            margin: 5px;
        }
    </style>
    <script>
        // Kiểm tra tham số 'status' từ URL để hiển thị thông báo
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                alert("Cập nhật thông tin thành công!");
                // Xóa 'status=success' khỏi URL để không hiện lại khi reload
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        };
    </script>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-md-3">
                <div class="account-sidebar">
                    <ul>
                        <li><a href="#">Thông tin tài khoản</a></li>
                        <li><a href="/BANHOA/database/updatepassword.php">Đổi mật khẩu</a></li>
                        <li><a href="#">Xem lại đơn hàng</a></li>
                        <li><a href="#">Giới thiệu Enden đến người thân</a></li>
                        <li><a href="/BANHOA/database/logout.php">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>

            <!-- Form hiển thị thông tin người dùng -->
            <!-- Form hiển thị thông tin người dùng -->
            <div class="col-md-9">
                <div class="account-container">
                    <h2 class="mb-4" style="color: #d8243c;">Cập nhật thông tin tài khoản</h2>
                    <form action="/BANHOA/database/updateuser.php" method="post" onsubmit="return validateForm()">
                        <!-- Fullname -->
                        <div class="form-group">
                            <label for="fullname">Họ và Tên</label>
                            <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" placeholder="Nhập họ và tên" required>
                        </div>

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Nhập email" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="tel" class="form-control" name="phone" id="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" placeholder="Nhập số điện thoại" required>
                        </div>

                        <!-- Address -->
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo htmlspecialchars($user['address']); ?>" placeholder="Tỉnh thành/quận huyện/thị xã/số nhà" required>
                        </div>

                        <button type="submit" name="updateuser" class="btn btn-save mt-3">
                            <i class="bi bi-save"></i> Lưu
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<?php include 'footer.php'; ?>

</html>