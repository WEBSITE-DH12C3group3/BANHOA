<?php
include "header.php";
$db = new Database();

// Get filter parameters from URL or set default values
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : 'all';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'asc';

// Define SQL WHERE condition based on selected price range
switch ($price_range) {
    case 'under100k':
        $where_price = "price_sale < 100000 AND price_sale IS NOT NULL";
        break;
    case '100k-300k':
        $where_price = "price_sale BETWEEN 100000 AND 300000 AND price_sale IS NOT NULL";
        break;
    case '300k-500k':
        $where_price = "price_sale BETWEEN 300000 AND 500000 AND price_sale IS NOT NULL";
        break;
    case 'over500k':
        $where_price = "price_sale > 500000 AND price_sale IS NOT NULL";
        break;
    default:
        $where_price = "price_sale IS NOT NULL";  // All products with sale price
        break;
}

// Define the sorting order
$order_by = $sort == 'desc' ? 'price_sale DESC' : 'price_sale ASC';

// SQL query to count the total number of products after applying the filter
$sql_count = "SELECT COUNT(*) AS total FROM products WHERE sale >= 50 AND $where_price";
$total_result = $db->select($sql_count);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
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

        .filter-container {
            margin: 20px 0;
        }

        .select-container select {
            padding: 5px;
        }
    </style>
</head>

<body style="margin-top: 200px;">
    <header class="bg-light p-3 text-center category-header">
        <h1>Siêu sale từ 50%</h1>
        <div class="product-count">
            <?php echo $total_products; ?> sản phẩm
        </div>
    </header>

    <div class="container my-5">
        <!-- Filter form -->
        <div class="filter-container">
            <form method="get" action="">
                <input type="hidden" name="id" value="<?php echo $category_id; ?>">
                <input type="hidden" name="category_name" value="<?php echo $category_name; ?>">

                <div class="filter-group">
                    <label for="price_range">Mức giá: </label>
                    <select name="price_range" id="price_range">
                        <option value="all" <?php echo ($price_range == 'all') ? 'selected' : ''; ?>>Tất cả</option>
                        <option value="under100k" <?php echo ($price_range == 'under100k') ? 'selected' : ''; ?>>Dưới 100k</option>
                        <option value="100k-300k" <?php echo ($price_range == '100k-300k') ? 'selected' : ''; ?>>100k - 300k</option>
                        <option value="300k-500k" <?php echo ($price_range == '300k-500k') ? 'selected' : ''; ?>>300k - 500k</option>
                        <option value="over500k" <?php echo ($price_range == 'over500k') ? 'selected' : ''; ?>>Trên 500k</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="sort">Sắp xếp: </label>
                    <select name="sort" id="sort">
                        <option value="asc" <?php echo ($sort == 'asc') ? 'selected' : ''; ?>>Giá tăng dần</option>
                        <option value="desc" <?php echo ($sort == 'desc') ? 'selected' : ''; ?>>Giá giảm dần</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>

        <style>
            .filter-container {
                background-color: #f9f9f9;
                border-radius: 10px;
                padding: 5px 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                width: 100%;
                max-width: 800px;
                margin: 20px auto;
                display: flex;
                justify-content: center;
                /* Centers the content horizontally */
            }

            .filter-container form {
                display: flex;
                align-items: center;
                justify-content: center;
                /* Ensures form is centered horizontally */
                flex-wrap: nowrap;
            }

            .filter-group {
                display: flex;
                align-items: center;
                margin-right: 10px;
            }

            .filter-group label {
                font-weight: bold;
                margin-right: 5px;
                font-size: 14px;
            }

            .filter-group select {
                padding: 5px;
                font-size: 14px;
                border: 1px solid #ccc;
                border-radius: 5px;
                background-color: #fff;
                transition: all 0.3s ease;
            }

            .filter-group select:focus {
                border-color: #007bff;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            button.btn-primary {
                background-color: #007bff;
                color: white;
                padding: 6px 12px;
                font-size: 14px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            button.btn-primary:hover {
                background-color: #0056b3;
            }

            button.btn-primary:active {
                background-color: #003f7f;
            }
        </style>


        <div class="row">
            <div class="container my-5">
                <div class="row" id="Table">
                    <?php
                    // Get products with applied filters and sorting
                    $sql = "SELECT * FROM products WHERE sale >= 50 AND $where_price ORDER BY $order_by";
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
                <div class="pagination-container" style="display: flex; justify-content: center;">
                    <div class="pagination" id="pagination" style="align-self: center;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/BANHOA/mycss/pagination2.js"></script>
</body>

</html>