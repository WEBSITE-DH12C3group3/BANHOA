<?php include 'header.php'; ?>

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

        <!-- Product Cards -->
        <!-- Row 1 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg" class="card-img-top product-image" alt="Adorable">
            <div class="card-body text-center">
              <h5 class="card-title">Adorable</h5>
              <p class="text-muted">850,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg" class="card-img-top product-image" alt="Tinh Khiết (Thạch Thảo Trắng)">
            <div class="card-body text-center">
              <h5 class="card-title">Tinh Khiết (Thạch Thảo Trắng)</h5>
              <p class="text-muted">420,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" class="card-img-top product-image" alt="Hạ Về (Cúc Tana Xinh)">
            <div class="card-body text-center">
              <h5 class="card-title">Hạ Về (Cúc Tana Xinh)</h5>
              <p class="text-muted">560,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card position-relative">
            <span class="discount-badge">15% Giảm</span>
            <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" class="card-img-top product-image" alt="Be Happy">
            <div class="card-body text-center">
              <h5 class="card-title">Be Happy</h5>
              <p class="text-muted">720,000 VND <del>850,000 VND</del></p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <!-- Row 2 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg" class="card-img-top product-image" alt="Adorable">
            <div class="card-body text-center">
              <h5 class="card-title">Adorable</h5>
              <p class="text-muted">850,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg" class="card-img-top product-image" alt="Tinh Khiết (Thạch Thảo Trắng)">
            <div class="card-body text-center">
              <h5 class="card-title">Tinh Khiết (Thạch Thảo Trắng)</h5>
              <p class="text-muted">420,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg" class="card-img-top product-image" alt="Hạ Về (Cúc Tana Xinh)">
            <div class="card-body text-center">
              <h5 class="card-title">Hạ Về (Cúc Tana Xinh)</h5>
              <p class="text-muted">560,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card position-relative">
            <span class="discount-badge">15% Giảm</span>
            <img src="/BANHOA/Front-end/hoaicon/hoaicon4.jpg" class="card-img-top product-image" alt="Be Happy">
            <div class="card-body text-center">
              <h5 class="card-title">Be Happy</h5>
              <p class="text-muted">720,000 VND <del>850,000 VND</del></p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <!-- Row 3 -->
        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon9.jpg" class="card-img-top product-image" alt="Mộng Mơ (Hoa Cúc)">
            <div class="card-body text-center">
              <h5 class="card-title">Mộng Mơ (Hoa Cúc)</h5>
              <p class="text-muted">420,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon10.jpg" class="card-img-top product-image" alt="Hoa Tươi Sáng">
            <div class="card-body text-center">
              <h5 class="card-title">Hoa Tươi Sáng</h5>
              <p class="text-muted">620,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

        <div class="col-md-3 col-sm-6 mb-4">
          <div class="card">
            <img src="/BANHOA/Front-end/hoaicon/hoaicon11.jpg" class="card-img-top product-image" alt="Nắng Mai (Hoa Hướng Dương)">
            <div class="card-body text-center">
              <h5 class="card-title">Nắng Mai (Hoa Hướng Dương)</h5>
              <p class="text-muted">520,000 VND</p>
              <a href="#" class="btn btn-primary">Đặt hàng</a>
            </div>
          </div>
        </div>

  </section>
  <!-- Footer -->
  <?php include 'footer.php'; ?>
  <!-- Link Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>