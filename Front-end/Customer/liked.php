<?php
include 'header.php';
$sql = "SELECT * FROM favourite,products WHERE favourite.product_id = products.id AND user_id = '" . $_SESSION['users_id'] . "'";
$result = $db->select($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sản phẩm yêu thích</title>
</head>

<body style="margin-top: 120px;">
    <section class="py-5">
        <div class="container mt-5">
            <h2 class="mb-4 text-center">Sản phẩm yêu thích</h2>
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Ảnh sản phẩm</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    <?php
                    if ($result) {
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            $i++;
                    ?>
                            <tr class="cart-item">
                                <td><?php echo $i; ?></td>
                                <td><img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $row['image']; ?>" alt="Product Image" width="100px"></td>
                                <td><a href="hoa.php?id=<?php echo $row['id']; ?>"><?php echo $row['product_name']; ?></a></td>
                                <td><?php echo $row['stock']; ?></td>
                                <td><?php echo number_format($row['price_sale'], 0, ',', '.'); ?> VND</td>
                                <td>
                                    <a href="modelcart.php?unlike=<?php echo $row['id']; ?>" style=" color: white; text-decoration: none;">
                                        <button name="action" value="remove" type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>

                        <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="6"><img src="../public/exhausted-wojak.gif" alt="exhausted-wojak" width="300">
                                <div style="margin: 10px;">Không có sản phẩm yêu thích</div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    </section>
</body>
<?php
include 'footer.php';
?>

</html>