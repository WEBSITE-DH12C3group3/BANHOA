<?php
include 'header.php';
$db = new Database();

// Khởi tạo session nếu chưa bắt đầu
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Xử lý các thao tác giỏ hàng (cộng, trừ, xóa)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($productId  && $action == 'remove') {
        header("Location: modelcart.php?delete=" . $productId);
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDEN | Giỏ Hàng</title>
    <link rel="stylesheet" href="/BANHOA/mycss/cart.css">
</head>

<body style="margin-top: 200px;">

    <section class="py-5">
        <div class="container mt-5">
            <h2 class="mb-4 text-center">Giỏ Hàng</h2>
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Ảnh sản phẩm</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Thành tiền</th>
                        <th scope="col" width="90px">Thao tác</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    <?php
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                        $i = 0;
                        $total = 0;
                        foreach ($_SESSION['cart'] as $item) {
                            $i++;
                            $id = $item['id'];
                            $price = $item['price_sale'];
                            $quantity = $item['quantity'];
                            $name = $item['name'];
                            $image = $item['image'];

                            $thanhtien = $price * $quantity;
                            $total += $thanhtien;
                    ?>
                            <tr class="cart-item">
                                <td><?php echo $i; ?></td>
                                <td><img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $image; ?>" alt="Product Image" /></td>
                                <td><?php echo $name; ?></td>
                                <td>
                                    <a href="modelcart.php?minus=<?php echo $id; ?>" class="btn btn-light nuts"><i class="fa fa-minus"></i></a>
                                    <span class="item-quantity btn"><?php echo $quantity; ?></span>
                                    <a href="modelcart.php?plus=<?php echo $id; ?>" class="btn btn-light nuts"><i class="fa fa-plus"></i></a>
                                </td>
                                <td><?php echo number_format($thanhtien, 0, ',', '.'); ?> VND</td>
                                <td>
                                    <a href="modelcart.php?delete=<?php echo $id; ?>" style="color: white; text-decoration: none;">
                                        <button name="action" value="remove" type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr style="border: 0px solid white;">
                            <td colspan="6"><a href="modelcart.php?deleteall=1" class="btn btn-danger" style="float: right; margin-top: 10px;">Xóa tất cả</a></td>
                        </tr>
                    <?php
                    } else {
                        echo "<tr style='height: 100px;'><td colspan='6'>Giỏ hàng trống!<br>
                          <a href='index.php' class='btn btn-success' style='margin-top: 10px;'>Mua Ngay</a></td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <?php if (count($_SESSION['cart']) > 0): ?>
                    <div class="cart-total py-2">
                        Tổng cộng: <span id="cart-total"><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
                    </div>
                    <div class="cart-total py-2">
                        <?php if (isset($_SESSION['user_logged_in'])): ?>
                            <button class="bton"><a href="htvc.php" style="color: white; text-decoration: none;">Hình thức vận chuyển</a></button>
                        <?php else: ?>
                            <button class="bton"><a href="dangky.php" style="color: white; text-decoration: none;">Đăng ký để tiếp tục</a></button>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>