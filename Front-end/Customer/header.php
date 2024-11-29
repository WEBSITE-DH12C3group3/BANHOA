<?php
session_start(); // Đảm bảo session đã được start
// Initialize the cart session if it's not set
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}
include '../../database/connect.php';

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
<html lang="en-vn">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/png" href="../public/Eden.png">
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <link rel="stylesheet" href="../../mycss/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOdLHNpLHn9+YRAy0RQgRNEirOrf0gR6Yq6yjHA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="../../assets/owlcarousel/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="../../assets/owlcarousel/assets/owl.theme.default.min.css">
  <link rel="stylesheet" href="../../mycss/footder.css">
  <style>
    /* Style for the dropdown */
    .dropdown:hover .dropdown-menu {
      display: block;
      /* Hiển thị menu khi hover vào phần tử dropdown */
    }

    .dropdown-menu {
      display: none;
      /* Ẩn menu mặc định */
      position: absolute;
      /* Đặt menu vào vị trí tuyệt đối */
      z-index: 1000;
      /* Đảm bảo menu hiển thị trên các phần tử khác */
    }

    .dropdown {
      width: fit-content;
      position: relative;
    }

    .dropdown-item {
      color: #093608 !important;
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
      transition: top 0.3s;
      /* Thêm hiệu ứng chuyển đổi */
    }

    .hidden {
      top: -125px;
      /* Chiều cao của menu để nó biến mất khi cuộn xuống */
    }

    #cart:hover {
      color: orangered;
    }
  </style>
</head>

<body>
  <header class="myheader sticky" id="myHeader">
    <section>
      <div class="container py-3">
        <div class="row align-items-center">
          <!-- Logo -->
          <div class="col-md-3 col-4 text-center text-md-start mb-3 mb-md-0">
            <a href="index.php">
              <img
                src="../public/logo1.png"
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
            <div class="d-flex justify-content-center justify-content-md-end align-items-center">
              <!-- Cart -->
              <div class="col-6">
                <div class="me-4 position-relative text-center">
                  <a
                    href="cart.php"
                    class="position-relative text-dark">
                    <span class="fs-2" id="cart"><i class="fa-solid fa-bag-shopping"></i></span>
                    <span
                      class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                      <?php echo count($_SESSION['cart']); ?>
                    </span>
                  </a>
                  <div class="text-muted">
                    <b>Giỏ Hàng</b>
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
                      <i class="fa-regular fa-user"></i>
                      Tài khoản
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
                    <a class="btn btn-secondary dropdown-toggle" href="#" role="button">
                      <i class="fa-regular fa-user"></i>
                      <?php echo $name; ?> <!-- Hiển thị tên người dùng -->
                    </a>
                    <ul class="dropdown-menu">
                      <li>
                        <a class="dropdown-item" href="trangcanhan.php">Trang cá nhân</a>
                      </li>
                      <?php if ($_SESSION['role'] === 'admin'): ?>
                        <li>
                          <a class="dropdown-item" href="../Adminn/index.php">Quản lý</a>
                        </li>
                      <?php endif; ?>
                      <li>
                        <a class="dropdown-item" href="../../database/logout.php">Đăng xuất</a>
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

    <section class="mymainmenu" style="background-color: #f7aaaa; border-radius: 5px;">
      <div class="container">
        <nav class="navbar navbar-expand-lg">
          <span class="navbar-brand" style="color: #093608;" href="#"><b>EDEN</b></span>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav d-flex justify-content-around w-100">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php" style="color: #093608;"><b>Trang Chủ</b></a>
              </li>
              <?php if (isset($_SESSION['user_logged_in'])): ?>
                <li class="nav-item">
                  <a class="nav-link" href="liked.php" style="color: #093608;"><b>Yêu thích</b></a>
                </li>
              <?php endif; ?>
              <!-- Other menu items -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: #093608;">
                  <b>Danh mục</b>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <?php foreach ($categories as $category): ?>
                    <li><a class="dropdown-item" href="category.php?id=<?php echo $category['id']; ?>&category_name=<?php echo $category['category_name']; ?>"><?php echo htmlspecialchars($category['category_name']); ?></a></li>
                  <?php endforeach; ?>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="supasale.php" style="color: #093608;"><b>Siêu sale</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="contact.php" style="color: #093608;"><b>Liên hệ</b></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.html" style="color: #093608;"><b>Về chúng tôi</b></a>
              </li>
              <li class="nav-item dropdown"></li> <!-- Empty dropdown item -->
            </ul>
          </div>
        </nav>
      </div>
    </section>
  </header>

  <!-- Optional: Add JavaScript if you want a click-based dropdown -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    let lastScrollTop = 0;
    const header = document.getElementById("myHeader");

    window.addEventListener("scroll", function() {
      const currentScroll = window.pageYOffset;

      if (currentScroll > lastScrollTop) {
        // Cuộn xuống
        header.classList.add("hidden");
      } else {
        // Cuộn lên
        header.classList.remove("hidden");
        header.classList.add("sticky");
      }

      lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Đặt lại lastScrollTop để tránh giá trị âm
    });
  </script>

</body>

</html>