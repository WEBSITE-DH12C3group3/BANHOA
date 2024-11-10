<?php
include "header.php";
$db = new Database();

// Nhận category_id và category_name từ URL hoặc trang con
$category_id = $_GET['id'];
$category_name = $_GET['category_name'];

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDEN | <?php echo $category_name; ?></title>
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
    <section>
        <header class="bg-light p-3 text-center category-header">
            <h1><?php echo htmlspecialchars($category_name); ?></h1>
            <div class="product-count">
                <?php echo $db->count("SELECT * FROM products WHERE category_id = '$category_id'"); ?> sản phẩm
            </div>
        </header>

        <div class="container my-5">
            <div class="row">
                <div class="container my-5">
                    <div class="row" id="Table">
                        <?php
                        $sql = "SELECT * FROM products WHERE category_id = '$category_id' ORDER BY id";
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

                <div class="pagination-container" style="display: flex; justify-content: center;">
                    <div class="pagination" id="pagination" style="align-self: center;">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/BANHOA/mycss/pagination2.js"></script>
</body>

</html>