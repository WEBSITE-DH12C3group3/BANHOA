<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoa</title>
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
            background-color: #d8243c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-save:hover {
            background-color: #c71e34;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-md-3">
                <div class="account-sidebar">
                    <ul>
                        <li><a href="#">Thông tin tài khoản</a></li>
                        <li><a href="#">Đổi mật khẩu</a></li>
                        <li><a href="#">Xem lại đơn hàng</a></li>
                        <li><a href="#">Giới thiệu Enden đến người thân</a></li>
                        <li><a href="#">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>

            <!-- Account Update Section -->
            <div class="col-md-9">
                <div class="account-container">
                    <h2 class="mb-4" style="color: #d8243c;">Cập nhật thông tin tài khoản</h2>
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email của bạn:</label>
                                <input type="email" class="form-control" id="email" placeholder="Nhập email của bạn">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">Tên:</label>
                                <input type="text" class="form-control" id="firstName" placeholder="Nhập tên của bạn">
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="lastName" class="form-label">Họ:</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Nhập họ của bạn">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Điện thoại:</label>
                                    <input type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại của bạn">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="address" class="form-label">Địa chỉ:</label>
                                    <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ của bạn">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">

                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="province" class="form-label">Tỉnh/Thành phố:</label>
                                        <select class="form-select" id="province">
                                            <option value="">Chọn tỉnh thành phố</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="district" class="form-label">Quận/Huyện:</label>
                                        <select class="form-select" id="district">
                                            <option value="">Chọn quận huyện</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="ward" class="form-label">Phường/Xã:</label>
                                        <select class="form-select" id="ward">
                                            <option value="" selected>Chọn phường xã</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-save mt-3">
                                <i class="bi bi-save"></i> Lưu
                            </button>
                    </form>
                </div>
            </div>

            <!-- Script để load dữ liệu tỉnh thành phố, quận huyện, phường xã -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
            <script>
                var citis = document.getElementById("province");
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
            <?php include 'footer.php'; ?>

        </div>
</body>

</html>