<?php
include 'header.php';
$db = new Database();
$sql = "SELECT oi.id as order_item_id, oi.quantity, 
           o.order_code, o.order_date, o.total,
           p.product_name, p.price_sale
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    JOIN products p ON oi.product_id = p.id
    ORDER BY o.id";
$result = $db->select($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>EDEN | Giỏ Hàng</title>
  <!-- Bootstrap CSS -->
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
    }

    .input-group {
      display: flex;
      justify-content: center;
      align-items: center;
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
          if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $i = 0;
            $total = 0; // Tổng giá trị giỏ hàng
            foreach ($_SESSION['cart'] as $key => $item) {
              $i++;
              $id = isset($item['id']) ? $item['id'] : 0;
              $price = isset($item['price_sale']) ? $item['price_sale'] : 0;
              $quantity = isset($item['quantity']) ? $item['quantity'] : 1;
              $name = isset($item['name']) ? $item['name'] : 'Sản phẩm không có tên';
              $image = isset($item['image']) ? $item['image'] : 'default_image.jpg';

              // Tính thành tiền cho từng sản phẩm
              $thanhtien = $price * $quantity;
              $total += $thanhtien;
          ?>
              <tr class="cart-item">
                <td><?php echo $i; ?></td>
                <td><img src="/BANHOA/Front-end/Adminn/uploads/<?php echo $image; ?>" /></td>
                <td><?php echo $name; ?></td>
                <td>
                  <div class="input-group">
                    <button
                      class="btn btn-outline-secondary"
                      onclick="updateQuantity(this, -1)">
                      -
                    </button>
                    <input
                      type="text"
                      class="form-control text-center item-quantity"
                      value="<?php echo $quantity; ?>"
                      style="max-width: 50px"
                      readonly />
                    <button
                      class="btn btn-outline-secondary"
                      onclick="updateQuantity(this, 1)">
                      +
                    </button>
                  </div>
                </td>
                <td class="item-price" data-price="<?php echo $price; ?>"><?php echo number_format($price, 0, ',', '.') ?> VND</td>

                <!-- <td class="item-total"><?php echo number_format($thanhtien, 0, ',', '.'); ?> VND</td> -->
                <td>
                  <button
                    class="btn btn-danger btn-sm"
                    onclick="removeItem(this)">
                    <i class="fa fa-trash"></i>
                  </button>
                </td>
              </tr>
          <?php
            }
          } else {
            echo "<tr><td colspan='6'>Giỏ hàng trống!</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <div class="d-flex justify-content-between py-4">
        <div class="cart-total py-4">
          Tổng cộng: <span id="cart-total"><?php echo number_format($total, 0, ',', '.'); ?> VND</span>
        </div>
        <div>
          <?php if (isset($_SESSION['user_logged_in'])): ?>
            <button><a href="thanhtoan.php">Thanh toán</a></button>
          <?php else: ?>
            <button><a href="dangky.php">Đăng ký để thanh toán</a></button>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </section>
  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function updateQuantity(button, change) {
      const quantityInput = button.closest(".input-group").querySelector(".item-quantity");
      let currentQuantity = parseInt(quantityInput.value);

      // Update quantity based on button click
      currentQuantity += change;
      if (currentQuantity < 1) currentQuantity = 1;
      quantityInput.value = currentQuantity;

      // Update item total
      const itemRow = button.closest("tr");
      const price = parseInt(itemRow.querySelector(".item-price").dataset.price);
      const itemTotal = itemRow.querySelector(".item-total");
      itemTotal.textContent = new Intl.NumberFormat("vi-VN").format(price * currentQuantity) + " VND";

      // Update cart total
      updateCartTotal();
    }

    function updateCartTotal() {
      let total = 0;
      document.querySelectorAll(".cart-item").forEach((item) => {
        const itemTotal = parseInt(item.querySelector(".item-total").textContent.replace(/[^0-9]/g, ""));
        total += itemTotal;
      });
      document.getElementById("cart-total").textContent = new Intl.NumberFormat("vi-VN").format(total) + " VND";
    }

    function removeItem(button) {
      const itemRow = button.closest("tr");
      itemRow.remove();
      updateCartTotal();
    }
  </script>
</body>

</html>