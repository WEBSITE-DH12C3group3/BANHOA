<?php
include '/xampp/htdocs/BANHOA/database/connect.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="icon" type="image/png" href="/BANHOA/Front-end/public/Eden.png">
  <link rel="stylesheet" href="/BANHOA/css/bootstrap.css">
  <link rel="stylesheet" href="/BANHOA/css/bootstrap.min.css">
  <link rel="stylesheet" href="/BANHOA/mycss/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/BANHOA/assets/owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="/BANHOA/assets/owlcarousel/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="/BANHOA/mycss/footder.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
  <header>
    <section class="myheader">
      <div class="container py-3">
        <div class="row align-items-center">
          <!-- Logo -->
          <div class="col-md-3 col-4 text-center text-md-start mb-3 mb-md-0">
            <img
              src="/BANHOA/Front-end/public/logo1.png"
              class="img-fluid"
              width="200px"
              height="auto"
              alt="Logo" />
          </div>

          <!-- Search Bar -->
          <div class="col-md-5 col-4 mb-3 mb-md-0">
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                placeholder="Tìm Kiếm"
                aria-label="Tìm Kiếm"
                aria-describedby="basic-addon2" />
              <button
                class="btn btn-outline-secondary"
                type="button"
                id="basic-addon2">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </div>
          </div>

          <!-- Cart and Account Section -->
          <div class="col-md-4 col-4">
            <div
              class="d-flex justify-content-center justify-content-md-end align-items-center">
              <!-- Cart -->
              <div class="col-6">
                <div class="me-4 position-relative text-center">
                  <a
                    href="/BANHOA/Front-end/Customer/giohang.html"
                    class="position-relative text-dark">
                    <span class="fs-2"><i class="fa-solid fa-bag-shopping"></i></span>
                    <span
                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      0
                    </span>
                  </a>
                  <div class="text-muted" style="color: #3f640b">
                    Giỏ Hàng <br />
                    Của Bạn
                  </div>
                </div>
              </div>

              <!-- Account -->
              <div class="col-6">
                <div class="fs-3"><i class="fa-regular fa-user"></i></div>
                <?php if(empty($_SESSION['users_id'])):?>
                  <div class="dropdown nav-item">
                    <a
                      class="btn btn-secondary dropdown-toggle"
                      href="#"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Xin chào! Tài khoản
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a
                          class="dropdown-item"
                          href="/BANHOA/Front-end/Customer/dangky.php">Đăng ký</a>
                      </li>
                      <li>
                        <a
                          class="dropdown-item"
                          href="/BANHOA/Front-end/Customer/dangnhap.php">Đăng nhập</a>
                      </li>
                    </ul>
                  </div>
                  <?php else:?>
                    <div class="dropdown nav-item">
                    
                    <a
                      class="btn btn-secondary dropdown-toggle"
                      href="#"  
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <section>Hello <br><?=$_SESSION['fullname']?></section>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a
                          class="dropdown-item"
                          href="/BANHOA/Front-end/Customer/trangcanhan.php">Trang cá nhân</a>
                      </li>
                      <li>
                        <a
                          class="dropdown-item"
                          href="/BANHOA/database/logout.php">Đăng xuất</a>
                      </li>
                    </ul>
                  </div>
                    
                <?php endif;?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </header>
</body>

</html>