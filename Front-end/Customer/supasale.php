<?php
include "header.php";
$db = new Database();

// Nhận trang hiện tại từ URL, mặc định là trang 1 nếu không có
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$products_per_page = 8; // Số sản phẩm mỗi trang
$offset = ($page - 1) * $products_per_page; // Tính OFFSET

// Lấy tổng số sản phẩm trong danh sách "Siêu sale" để tính tổng số trang
$total_products_query = "SELECT COUNT(*) AS total FROM products WHERE sale >= 50";
$total_result = $db->select($total_products_query);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $products_per_page); // Tổng số trang
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDEN | Siêu sale</title>
    <style>
        .product-image {
            width: 100%;
            height: auto;
            max-height: 300px;
            object-fit: cover;
        }

        /* Style for the product count box */
        .product-count {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f2231d;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1.2em;
        }

        .category-header {
            position: relative;
        }
    </style>
</head>

<body>
    <header class="bg-light p-3 text-center category-header">
        <h1>Siêu sale từ 50%</h1>
        <div class="product-count">
            <?php echo $total_products; ?> sản phẩm
        </div>
    </header>
    <div class="container my-5">
        <div class="row">
            <div class="container my-5">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM products WHERE sale >= 50 ORDER BY id LIMIT $products_per_page OFFSET $offset";
                    $result = $db->select($sql);

                    if ($result) {
                        while ($row = $result->fetch_assoc()) {
                            $price = number_format($row['price'], 0, ',', '.') . ' VND';
                            $price_sale = $row['price_sale'] ? number_format($row['price_sale'], 0, ',', '.') . ' VND' : null;
                    ?>
                            <div class="col-md-3 col-sm-6 mb-4">
                                <a href="hoa.php?id=<?php echo $row['id']; ?>" class="card">
                                    <img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $row['image']; ?>" class="card-img-top product-image" alt="<?php echo $row['product_name']; ?>">

                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?php echo $row['product_name']; ?></h5>

                                        <p class="text-muted">
                                            <?php if ($price_sale) {
                                                $discount_percentage = round((($row['price'] - $row['price_sale']) / $row['price']) * 100, 2);
                                            ?>
                                                <span style="text-decoration: line-through; color: black; font-weight: bold;"><?php echo $price; ?></span>
                                                <span style="font-weight: bold; font-size: 1.2em; color: #f2231d;"><?php echo $price_sale; ?></span>
                                                <br>
                                                <small style="color: green; font-weight: bold;">Giảm <?php echo $discount_percentage; ?>%</small>
                                            <?php } else { ?>
                                                <span style="font-weight: bold; font-size: 1.2em;"><?php echo $price; ?></span>
                                            <?php } ?>
                                        </p>

                                        <button class="btn btn-primary">Đặt hàng</button>
                                    </div>
                                </a>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Pagination (only page numbers) -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>