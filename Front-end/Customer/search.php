<?php
include 'header.php';
$db = new Database();
$sql = "SELECT * FROM products WHERE product_name LIKE '%" . $_GET['q'] . "%' LIMIT 10";
$result = $db->select($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tìm Kiếm: <?php echo $_GET['q']; ?></title>
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="container my-5">
                <div class="row">
                    <?php
                    $sql = "SELECT * FROM products WHERE product_name = '" . $_GET['q'] . "'";
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
                    } else {
                        echo "Không có sản phẩm nào có tên " . $_GET['q'] . ".";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    include 'footer.php';
    ?>
</body>

</html>