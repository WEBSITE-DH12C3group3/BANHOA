<?php include 'header.php'; ?>
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

    <body>

        <div class="container mt-5">
            <div class="row">
                <!-- Product Summary on the Left -->
                <div class="col-md-6">
                    <div class="checkout-container summary-container">
                        <h2 class="text-center mb-4" style="color: #d8243c;">Chi tiết đơn hàng</h2>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div class="d-flex align-items-center">
                                    <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" alt="Nữ hoàng - 13075" class="product-img">
                                    <div>
                                        <h6 class="my-0">Nữ hoàng - 13075</h6>
                                        <small class="text-muted">Sản phẩm hoa</small>
                                    </div>
                                </div>
                                <span class="text-muted">600.000 ₫</span>
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
                                    <small class="text-muted">Không</small>
                                </div>
                                <span class="text-muted">0 ₫</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Tổng cộng (VND)</span>
                                <strong class="total-price">600.000 ₫</strong>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Customer Information on the Right -->
                <div class="col-md-6">
                    <div class="checkout-container">
                        <h2 class="text-center mb-4" style="color: #d8243c;">Thông tin thanh toán</h2>
                        <div class="form-section">
                            <form>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">Họ</label>
                                        <input type="text" class="form-control" id="firstName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Tên</label>
                                        <input type="text" class="form-control" id="lastName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                        <input type="text" class="form-control" id="phone" required>
                                    </div>
                                </div>

                                <div class="form-section">
                                    <div class="section-title">Địa chỉ giao hàng</div>
                                    <form>
                                        <div class="row">
                                            <!-- Địa chỉ -->
                                            <div class="col-md-12 mb-3">
                                                <label for="address" class="form-label">Địa chỉ</label>
                                                <input type="text" class="form-control" id="address">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Tỉnh thành -->
                                            <div class="col-md-6 mb-3">
                                                <label for="city" class="form-label">Tỉnh/Thành phố</label>
                                                <select class="form-select" id="city" aria-label="Chọn tỉnh thành">
                                                    <option value="" selected>Chọn tỉnh thành</option>
                                                </select>
                                            </div>

                                            <!-- Quận huyện -->
                                            <div class="col-md-6 mb-3">
                                                <label for="district" class="form-label">Quận/Huyện</label>
                                                <select class="form-select" id="district" aria-label="Chọn quận huyện">
                                                    <option value="" selected>Chọn quận huyện</option>
                                                </select>
                                            </div>

                                            <!-- Phường xã -->
                                            <div class="col-md-6 mb-3">
                                                <label for="ward" class="form-label">Phường/Xã</label>
                                                <select class="form-select" id="ward" aria-label="Chọn phường xã">
                                                    <option value="" selected>Chọn phường xã</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- Axios and script to load city, district, ward data -->
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
                                <script>
                                    var citis = document.getElementById("city");
                                    var districts = document.getElementById("district");
                                    var wards = document.getElementById("ward");

                                    var Parameter = {
                                        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
                                        method: "GET",
                                        responseType: "application/json",
                                    };

                                    var promise = axios(Parameter);
                                    promise.then(function(result) {
                                        renderCity(result.data);
                                    });

                                    function renderCity(data) {
                                        for (const x of data) {
                                            citis.options[citis.options.length] = new Option(x.Name, x.Id);
                                        }

                                        citis.onchange = function() {
                                            districts.length = 1; // reset district list
                                            wards.length = 1; // reset ward list

                                            if (this.value != "") {
                                                const result = data.filter(n => n.Id === this.value);

                                                for (const k of result[0].Districts) {
                                                    districts.options[districts.options.length] = new Option(k.Name, k.Id);
                                                }
                                            }
                                        };

                                        districts.onchange = function() {
                                            wards.length = 1; // reset ward list

                                            const dataCity = data.filter(n => n.Id === citis.value);
                                            if (this.value != "") {
                                                const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;

                                                for (const w of dataWards) {
                                                    wards.options[wards.options.length] = new Option(w.Name, w.Id);
                                                }
                                            }
                                        };
                                    }
                                </script>

                                <div class="form-section">
                                    <div class="section-title">Phương thức thanh toán</div>
                                    <form>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="creditCard" checked>
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
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer">
                                            <label class="form-check-label" for="bankTransfer">
                                                Chuyển khoản ngân hàng
                                            </label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="radio" name="paymentMethod" id="cashOnDelivery">
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
                                        <li class="list-group-item d-flex justify-content-between lh-sm">
                                            <div>
                                                <h6 class="my-0">Nữ hoàng - 13075</h6>
                                                <small class="text-muted">Sản phẩm hoa</small>
                                            </div>
                                            <span class="text-muted">600.000 ₫</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Tổng (VND)</span>
                                            <strong class="total-price">600.000 ₫</strong>
                                        </li>
                                    </ul>
                                </div>

                                <button class="w-100 btn btn-primary btn-lg" type="submit">Thanh toán</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>