<?php
include 'header.php';
$db = new Database();
$q = $_GET['q'];
$sql = "SELECT * FROM products WHERE product_name LIKE '%" . $q . "%'";
$count = $db->count($sql);
$result = $db->select($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Tìm Kiếm: <?php echo $q; ?></title>
</head>

<body>
    <header class="bg-light p-3 text-center">
        <div class="product-count">
            <?php
            // Lấy tổng số sản phẩm trong danh sách "Siêu sale" để tính tổng số trang
            echo $count;
            ?> sản phẩm
        </div>
    </header>

    <div class="container my-5">
        <div class="row" id="Table">
            <?php
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
        <div class="pagination-container" style="display: flex; justify-content: center;">
            <div class="pagination" id="pagination" style="align-self: center;">
            </div>
        </div>
    </div>

    <script src="/BANHOA/mycss/pagination2.js"></script>
    <?php
    include 'footer.php';
    ?>
</body>

</html>