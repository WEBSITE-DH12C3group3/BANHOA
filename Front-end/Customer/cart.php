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
    <style>
        .cart-item img {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .cart-total {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .input-group button {
            height: 40px;
            width: 40px;
        }

        .input-group .item-quantity {
            max-width: 60px;
            text-align: center;
            height: 40px;
            font-size: 16px;
        }

        .input-group {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .bton {
            background-color: #0d6efd;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .bton:hover {
            background-color: #0a58ca;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

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
                        <th scope="col">Thao tác</th>
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
                                    <a href="modelcart.php?minus=<?php echo $id; ?>" class="btn btn-warning">-</a>
                                    <span class="item-quantity"><?php echo $quantity; ?></span>
                                    <a href="modelcart.php?plus=<?php echo $id; ?>" class="btn btn-success">+</a>
                                </td>
                                <td><?php echo number_format($thanhtien, 0, ',', '.'); ?> VND</td>
                                <td>
                                    <form method="POST" action="cart.php">
                                        <input type="hidden" name="product_id" value="<?php echo $id; ?>" />
                                        <button name="action" value="remove" type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr style='height: 100px;'><td colspan='6'>Giỏ hàng trống!</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between py-4">
                <div class="cart-total py-4">
                    <?php if (count($_SESSION['cart']) > 0): ?>
                        Tổng cộng: <span id="cart-total"><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
                    <?php endif; ?>
                </div>
                <div class="cart-total py-4">
                    <?php if (isset($_SESSION['user_logged_in'])): ?>
                        <button class="bton"><a href="thanhtoan.php" style="color: white; text-decoration: none;">Thanh toán</a></button>
                    <?php else: ?>
                        <button class="bton"><a href="dangky.php" style="color: white; text-decoration: none;">Đăng ký để thanh toán</a></button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include 'footer.php'; ?>

</body>

</html>