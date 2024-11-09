<?php
include "header.php";
$db = new Database();

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
    </style>
</head>

<body>
    <header class="bg-light p-3 text-center">
        <h1>Siêu sale từ 50%</h1>
    </header>
    <div class="container my-5">
        <div class="row">
            <div class="container my-5">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM products WHERE sale >= 50 ORDER BY id";
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
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>