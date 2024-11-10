<?php include 'header.php';
$db = new Database();
$uid = $_SESSION["users_id"];
$sql = "SELECT * FROM users WHERE id = '" . $uid . "'";
$result = $db->select($sql);
$row = $result->fetch_assoc();
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thanh Toán</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .checkout-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 1.2rem;
            color: #d8243c;
        }

        label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #d8243c;
            border-color: #d8243c;
        }

        .btn-primary:hover {
            background-color: #b81e32;
            border-color: #b81e32;
        }

        .total-price {
            font-size: 1.5rem;
            color: #d8243c;
        }

        .checkout-container input[type="text"],
        .checkout-container input[type="email"] {
            background-color: #f7f7f7;
            border-color: #ccc;
        }

        .list-group-item {
            background-color: #f7f7f7;
        }

        .summary-container {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Product Summary on the Left -->
            <div class="col-md-6">
                <div class="checkout-container summary-container">
                    <h2 class="text-center mb-4" style="color: #d8243c;">Chi tiết đơn hàng</h2>
                    <ul class="list-group mb-3">
                        <?php foreach ($_SESSION['cart'] as $key => $value) {
                            $query = "SELECT price, sale FROM products WHERE id = '" . $value['id'] . "'";
                            $rs = $db->select($query);
                            $r = $rs->fetch_assoc();
                        ?>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div class="d-flex align-items-center">
                                    <img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $value['image']; ?>" class="product-img" style="border-radius: 5px; width: 80px; height: 80px; object-fit: cover;">
                                    <div style="margin-left: 20px;">
                                        <h6 class="my-0"><?php echo $value['name']; ?></h6>
                                    </div>
                                </div>
                                <span class="text-muted"><?php echo number_format($r['price'], 0, ',', '.'); ?> ₫</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Ship</h6>
                                    <small class="text-muted">Miễn phí vận chuyển</small>
                                </div>
                                <span class="text-muted">0 ₫</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Giảm giá</h6>
                                </div>
                                <span class="text-muted"><?php echo $r['sale']; ?>%</span>
                            </li>
                            <br>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <!-- Customer Information on the Right -->
            <div class="col-md-6">
                <div class="checkout-container">
                    <h2 class="text-center mb-4" style="color: #d8243c;">Thông tin thanh toán</h2>
                    <div class="form-section">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="firstName" required value="<?php echo $row['fullname']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required value="<?php echo $row['email']; ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" required value="<?php echo $row['phone']; ?>">
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-title">Địa chỉ giao hàng</div>
                            <form>
                                <div class="row">
                                    <!-- Địa chỉ -->
                                    <div class="col-md-12 mb-3">
                                        <input type="text" class="form-control" id="address" value="<?php echo $row['address']; ?>">
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-title">Phương thức thanh toán</div>
                                    <form>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" disabled>
                                            <label class="form-check-label" for="creditCard">
                                                Thẻ tín dụng / Thẻ ghi nợ
                                            </label>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="cardName" class="form-label">Tên trên thẻ</label>
                                                <input type="text" class="form-control" id="cardName" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="cardNumber" class="form-label">Số thẻ</label>
                                                <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6 mb-3">
                                                <label for="expiryDate" class="form-label">Ngày hết hạn</label>
                                                <input type="text" class="form-control" id="expiryDate" placeholder="MM/YY" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="cvv" class="form-label">CVV</label>
                                                <input type="text" class="form-control" id="cvv" placeholder="123" required>
                                            </div>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer" disabled>
                                            <label class="form-check-label" for="bankTransfer">
                                                Chuyển khoản ngân hàng
                                            </label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery" checked>
                                            <label class="form-check-label" for="cashOnDelivery">
                                                Thanh toán khi nhận hàng
                                            </label>
                                        </div>
                                    </form>
                                </div>

                                <!-- Order Summary Section -->
                                <div class="form-section">
                                    <div class="section-title">Tóm tắt đơn hàng</div>
                                    <ul class="list-group mb-3">
                                        <?php foreach ($_SESSION['cart'] as $key => $value) {
                                            $query = "SELECT price, sale FROM products WHERE id = '" . $value['id'] . "'";
                                            $rs = $db->select($query);
                                            $r = $rs->fetch_assoc();
                                            $price = $r['price'] - ($r['price'] * $r['sale'] / 100);
                                            $total += $price * $value['quantity'];
                                        ?>
                                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                                <div>
                                                    <h6 class="my-0"><?php echo $value['name']; ?></h6>
                                                </div>
                                                <span class="text-muted"><?php echo number_format($price, 0, ',', '.'); ?> ₫</span>
                                            </li>
                                        <?php } ?>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Tổng (VND)</span>
                                            <strong class="total-price"><?php echo number_format($total, 0, ',', '.'); ?> ₫</strong>
                                        </li>
                                    </ul>
                                </div>
                                <a class="w-100 btn btn-primary btn-lg" href="order.php">Thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'footer.php'; ?>
        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>