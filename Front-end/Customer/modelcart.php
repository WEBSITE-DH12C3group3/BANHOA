<?php
include "/xampp/htdocs/BANHOA/database/connect.php";
session_start();
$db = new Database();

//minus plus product

// Plus quantity
if (isset($_GET['plus'])) {
    $id = $_GET['plus'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] += 1;
            break;
        }
    }
    unset($item); // Hủy tham chiếu
    header('Location: cart.php');
    exit();
}

// Minus quantity
if (isset($_GET['minus'])) {
    $id = $_GET['minus'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $id) {
            $item['quantity'] = max(1, $item['quantity'] - 1); // Không giảm dưới 1
            break;
        }
    }
    unset($item); // Hủy tham chiếu
    header('Location: cart.php');
    exit();
}
//delete
if (isset($_GET['delete']) && isset($_SESSION['cart'])) {
    $id = $_GET['delete'];

    // Duyệt qua từng sản phẩm trong giỏ hàng để tìm sản phẩm cần xóa
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            // Xóa sản phẩm khỏi giỏ hàng
            unset($_SESSION['cart'][$key]);
            break;
        }
    }

    // Sắp xếp lại chỉ số mảng sau khi xóa sản phẩm
    $_SESSION['cart'] = array_values($_SESSION['cart']);

    // Chuyển hướng lại trang giỏ hàng (hoặc bất kỳ trang nào bạn muốn)
    header('Location: cart.php');
    exit();
}

//deleteall
if (isset($_GET['deleteall']) && $_GET['deleteall'] == 1) {
    unset($_SESSION['cart']);
    header("Location: cart.php");
}

//buy
if (isset($_POST['addcart'])) {
    $product_id = $_GET['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Lấy số lượng từ form

    // Truy vấn sản phẩm từ CSDL
    $sql = "SELECT * FROM products WHERE id = '" . $product_id . "' LIMIT 1";
    $query = $db->select($sql);

    if ($query->num_rows > 0) {
        // Lấy dữ liệu sản phẩm
        $row = $query->fetch_assoc();

        // Tạo mảng sản phẩm mới
        $new_product = array(
            'id' => $product_id,
            'name' => $row['product_name'],
            'image' => $row['image'],
            'price_sale' => $row['price_sale'],
            'quantity' => $quantity
        );

        // Kiểm tra xem giỏ hàng đã tồn tại hay chưa
        if (isset($_SESSION['cart'])) {
            $found = false;

            // Duyệt qua các sản phẩm trong giỏ hàng bằng tham chiếu
            foreach ($_SESSION['cart'] as &$item) {
                // Nếu sản phẩm đã tồn tại cùng size, tăng số lượng
                if ($item['id'] == $product_id) {
                    $item['quantity'] += $quantity; // Cộng thêm số lượng
                    $found = true;
                    break;
                }
            }
            unset($item); // Hủy tham chiếu để tránh lỗi

            // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm mới
            if (!$found) {
                $_SESSION['cart'][] = $new_product;
            }
        } else {
            // Nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng và thêm sản phẩm
            $_SESSION['cart'] = array($new_product);
        }
    }

    // Chuyển hướng đến trang giỏ hàng
    header('Location: cart.php');
    exit();
}

//add
if (isset($_POST['add'])) {
    $product_id = $_GET['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1; // Lấy số lượng từ form

    // Truy vấn sản phẩm từ CSDL
    $sql = "SELECT * FROM products WHERE id = '" . $product_id . "' LIMIT 1";
    $query = $db->select($sql);

    if ($query->num_rows > 0) {
        // Lấy dữ liệu sản phẩm
        $row = $query->fetch_assoc();

        // Tạo mảng sản phẩm mới
        $new_product = array(
            'id' => $product_id,
            'name' => $row['product_name'],
            'image' => $row['image'],
            'price_sale' => $row['price_sale'],
            'quantity' => $quantity
        );

        // Kiểm tra xem giỏ hàng đã tồn tại hay chưa
        if (isset($_SESSION['cart'])) {
            $found = false;

            // Duyệt qua các sản phẩm trong giỏ hàng bằng tham chiếu
            foreach ($_SESSION['cart'] as &$item) {
                // Nếu sản phẩm đã tồn tại cùng size, tăng số lượng
                if ($item['id'] == $product_id) {
                    $item['quantity'] += $quantity; // Cộng thêm số lượng
                    $found = true;
                    break;
                }
            }
            unset($item); // Hủy tham chiếu để tránh lỗi

            // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm mới
            if (!$found) {
                $_SESSION['cart'][] = $new_product;
            }
        } else {
            // Nếu giỏ hàng chưa tồn tại, khởi tạo giỏ hàng và thêm sản phẩm
            $_SESSION['cart'] = array($new_product);
        }
    }

    // Chuyển hướng đến trang giỏ hàng
    header('Location: hoa.php?id=' . $product_id . '&added=1');
    exit();
}
