<?php
session_start(); // Đảm bảo session đã được start
// Initialize the cart session if it's not set
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}
include '/xampp/htdocs/BANHOA/database/connect.php';

// Tạo đối tượng Database
$db = new Database();

// Truy vấn tất cả danh mục từ bảng `categories`
$query = "SELECT * FROM categories";
$categories_result = $db->select($query);

// Khởi tạo mảng danh mục
$categories = [];

// Kiểm tra nếu có kết quả và đưa vào mảng $categories
if ($categories_result) {
  while ($row = $categories_result->fetch_assoc()) {
    $categories[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="/BANHOA/Front-end/public/Eden.png">
  <link rel="stylesheet" href="/BANHOA/css/bootstrap.css">
  <link rel="stylesheet" href="/BANHOA/css/bootstrap.min.css">
  <link rel="stylesheet" href="/BANHOA/mycss/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/BANHOA/assets/owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="/BANHOA/assets/owlcarousel/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="/BANHOA/mycss/footder.css">
  <style>
    /* Style for the dropdown */
    .dropdown-menu {
      display: none;
      /* Initially hide dropdown */
      background-color: #f7aaaa;
    }

    .dropdown:hover .dropdown-menu {
      display: block;
      /* Show dropdown when hovering */
    }

    .dropdown-item {
      color: #3f640b !important;
    }

    .dropdown-item:hover {
      background-color: #ddd;
    }

    /* Other styles... */
    .sticky {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Add any other necessary styles to position the header correctly */
    }
  </style>
</head>

<body>
  <header>
    <section class="myheader" id="myHeader">
      <div class="container py-3">
        <div class="row align-items-center">
          <!-- Logo -->
          <div class="col-md-3 col-4 text-center text-md-start mb-3 mb-md-0">
            <a href="index.php">
              <img
                src="/BANHOA/Front-end/public/logo1.png"
                class="img-fluid"
                width="200px"
                height="auto"
                alt="Logo" />
            </a>
          </div>
          <!-- Search Bar -->
          <div class="col-md-5 col-4 mb-3 mb-md-0">
            <form method="get" action="search.php" class="input-group">
              <input
                type="text"
                class="form-control"
                placeholder="Tìm Kiếm"
                aria-label="Tìm Kiếm"
                aria-describedby="basic-addon2"
                name="q"
                required />
              <button
                class="btn btn-outline-secondary"
                type="submit"
                id="basic-addon2">
                <i class="fa-solid fa-magnifying-glass"></i>
              </button>
            </form>
          </div>

          <!-- Cart and Account Section -->
          <div class="col-md-4 col-4">
            <div
              class="d-flex justify-content-center justify-content-md-end align-items-center">
              <!-- Cart -->
              <div class="col-6">
                <div class="me-4 position-relative text-center">
                  <a
                    href="cart.php"
                    class="position-relative text-dark">
                    <span class="fs-2"><i class="fa-solid fa-bag-shopping"></i></span>
                    <span
                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      <?php echo count($_SESSION['cart']); ?>
                    </span>
                  </a>
                  <div class="text-muted" style="color: #3f640b">
                    Giỏ Hàng
                  </div>
                </div>
              </div>

              <!-- Account -->
              <div class="col-6">
                <div class="fs-3"></div>
                <?php if (empty($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] === false): ?>
                  <!-- Nếu chưa đăng nhập -->
                  <div class="dropdown nav-item">
                    <a
                      class="btn btn-secondary dropdown-toggle"
                      href="#"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      Tài khoản <i class="fa-regular fa-user"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a
                          class="dropdown-item"
                          href="dangky.php">Đăng ký</a>
                      </li>
                      <li>
                        <a
                          class="dropdown-item"
                          href="dangnhap.php">Đăng nhập</a>
                      </li>
                    </ul>
                  </div>
                <?php else:
                  // Nếu người dùng đã đăng nhập
                  function shortenName($name, $maxLength)
                  {
                    if (strlen($name) > $maxLength) {
                      return substr($name, 0, $maxLength) . "...";
                    }
                    return $name;
                  }
                  $name = shortenName($_SESSION['fullname'], 10); // Rút gọn nếu dài hơn 10 ký tự
                ?>
                  <div class="dropdown nav-item">
                    <a class="btn btn-secondary dropdown-toggle"
                      href="#"
                      role="button"
                      data-bs-toggle="dropdown"
                      aria-expanded="false">
                      <i class="fa-regular fa-user"></i>
                      <?php echo $name; ?> <!-- Hiển thị tên người dùng -->
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a
                          class="dropdown-item"
                          href="trangcanhan.php">Trang cá nhân</a>
                      </li>
                      <li>
                        <a
                          class="dropdown-item"
                          href="/BANHOA/database/logout.php">Đăng xuất</a>
                      </li>
                    </ul>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <!-- Other Header Content -->
        </div>
      </div>
    </section>

    <section class="mymainmenu" style="background-color: #f7aaaa;">
      <div class="container">
        <div class="row" style="color:#3f640b;">
          <div class="col-9">
            <nav class="navbar navbar-expand-lg" style="background-color: #f7aaaa;">
              <div class="container-fluid">
                <a class="navbar-brand" style="color: #3f640b;" href="index.php"><b>Trang chủ</b></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav">
                    <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#" style="color: #3f640b;"><b>Trang Chủ</b></a>
                    </li>
                    <!-- Other menu items -->
                    <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #3f640b;">
                        <b>Danh mục</b>
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php foreach ($categories as $category): ?>
                          <li><a class="dropdown-item" href="category.php?id=<?php echo $category['id']; ?>&category_name=<?php echo $category['category_name']; ?>"><?php echo htmlspecialchars($category['category_name']); ?></a></li>
                        <?php endforeach; ?>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </section>
  </header>

  <!-- Optional: Add JavaScript if you want a click-based dropdown -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    // Click-based dropdown toggle using jQuery (optional)
    $(document).ready(function() {
      $('.dropdown-toggle').click(function(e) {
        var $el = $(this).next('.dropdown-menu');
        var isVisible = $el.is(':visible');

        // Hide all dropdown menus
        $('.dropdown-menu').slideUp();

        // Toggle the visibility of the current dropdown
        if (!isVisible) {
          $el.stop(true, true).slideDown();
        }
      });

      // Close the dropdown if clicked outside
      $(document).click(function(e) {
        if (!$(e.target).closest('.dropdown').length) {
          $('.dropdown-menu').slideUp();
        }
      });
    });
  </script>
  <script>
    window.onscroll = function() {
      var header = document.getElementById("myHeader");
      if (window.pageYOffset > 0) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    };
  </script>

</body>

</html>