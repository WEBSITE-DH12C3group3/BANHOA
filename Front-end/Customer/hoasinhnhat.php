<?php
// Cấu hình kết nối cơ sở dữ liệu
$servername = "localhost"; // Tên máy chủ
$username = "root"; // Tên đăng nhập MySQL
$password = ""; // Mật khẩu MySQL (để trống nếu không đặt mật khẩu)
$dbname = "websitehoa"; // Thay bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$db = new mysqli($servername, $username, $password, $dbname);
// Kiểm tra kết nối
if ($db->connect_error) {
    die("Kết nối thất bại: " . $db->connect_error);
}
include "header.php";
?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    /* Custom CSS */
    .product-image {
      width: 100%;
      height: auto;
      max-height: 300px;
      object-fit: cover;
    }

    .discount-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: red;
      color: white;
      padding: 5px;
      border-radius: 5px;
      font-size: 14px;
    }
  </style>
</head>

<body>

  <section>
    <!-- Header -->
    <header class="bg-light p-3 text-center">
      <h1>Hoa Sinh Nhật</h1>
    </header>

    <!-- Main content -->
    <div class="container my-5">
      <div class="row">
        <!-- Filter and Sorting -->
        <div class="col-12 d-flex justify-content-between mb-4">
          <div>
            <button class="btn btn-outline-secondary">Sắp xếp theo</button>
            <select class="form-select d-inline w-auto">
              <option value="default">Mặc định</option>
              <option value="price">Giá</option>
              <option value="name">Tên</option>
            </select>
          </div>
          <div>
            <button class="btn btn-outline-secondary">Số lượng hiển thị</button>
            <select class="form-select d-inline w-auto">
              <option value="4">4</option>
              <option value="8">8</option>
              <option value="12">12</option>
            </select>
          </div>
        </div>
        <div class="container my-5">
    <div class="row">
        <?php
        // Fetch products with remark = 1 from the database
        $sql = "SELECT * FROM products WHERE category_id = 1 ORDER BY id";
        $result = $db->query($sql);

        if ($result) {
            while ($row = $result->fetch_assoc()) { 
                $price = number_format($row['price'], 0, ',', '.') . ' VND';
                $price_sale = $row['price_sale'] ? number_format($row['price_sale'], 0, ',', '.') . ' VND' : null;
        ?>
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card">
                        <img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $row['image']; ?>" class="card-img-top product-image" alt="<?php echo $row['product_name']; ?>">
                        
                        <div class="card-body text-center">
                            <h5 class="card-title"><?php echo $row['product_name']; ?></h5>
                            
                            <!-- Display price with sale check -->
                            <p class="text-muted">
                                <?php if ($price_sale) { 
                                    // Tính toán phần trăm giảm giá
                                    $discount_percentage = round(((($row['price'] - $row['price_sale']) / $row['price']) * 100), 2);
                                ?>
                                    <!-- Giá gốc bị gạch bỏ, màu đỏ -->
                                    <span style="text-decoration: line-through; color: black; font-weight: bold;"><?php echo $price; ?></span>
                                    <!-- Giá bán giảm nổi bật -->
                                    <span style="font-weight: bold; font-size: 1.2em; color: #f2231d;"><?php echo $price_sale; ?></span>
                                    <br>
                                    <!-- Hiển thị phần trăm giảm giá -->
                                    <small style="color: green; font-weight: bold;">Giảm <?php echo $discount_percentage; ?>%</small>
                                <?php } else { ?>
                                    <!-- Giá bình thường, làm nổi bật -->
                                    <span style="font-weight: bold; font-size: 1.2em;"><?php echo $price; ?></span>
                                <?php } ?>
                            </p>
                            
                            <a href="#" class="btn btn-primary">Đặt hàng</a>
                        </div>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>

  </section>
  <!-- Footer -->
  <?php include 'footer.php'; ?>
  <!-- Link Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>