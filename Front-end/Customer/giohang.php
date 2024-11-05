<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Gioi hang</title>
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
  </style>
</head>

<body>
  <hr />
  <setion class="py-5">
    <div class="container mt-5">
      <h2 class="mb-4 text-center">Giỏ Hàng</h2>
      <table class="table table-bordered text-center align-middle">
        <thead>
          <tr>
            <th scope="col">Sản phẩm</th>
            <th scope="col">Giá Tiền (VND)</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Tổng cộng (VND)</th>
            <th scope="col">Xóa</th>
          </tr>
        </thead>
        <tbody id="cart-body">
          <tr class="cart-item">
            <td>
              <img
                src="/BANHOA/Front-end/hoaicon/hoaicon1.jpg"
                alt="Hoa Hồng" />
              <span>Hoa Hồng</span>
            </td>
            <td class="item-price" data-price="256000">256,000 VND</td>
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
                  value="3"
                  style="max-width: 50px"
                  readonly />
                <button
                  class="btn btn-outline-secondary"
                  onclick="updateQuantity(this, 1)">
                  +
                </button>
              </div>
            </td>
            <td class="item-total">768,000 VND</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                onclick="removeItem(this)">
                X
              </button>
            </td>
          </tr>

          <tr class="cart-item">
            <td>
              <img
                src="/BANHOA/Front-end/hoaicon/hoaicon2.jpg"
                alt="Hoa Cúc" />
              <span>Hoa Cúc</span>
            </td>
            <td class="item-price" data-price="256000">256,000 VND</td>
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
                  value="3"
                  style="max-width: 50px"
                  readonly />
                <button
                  class="btn btn-outline-secondary"
                  onclick="updateQuantity(this, 1)">
                  +
                </button>
              </div>
            </td>
            <td class="item-total">768,000 VND</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                onclick="removeItem(this)">
                X
              </button>
            </td>
          </tr>

          <tr class="cart-item">
            <td>
              <img
                src="/BANHOA/Front-end/hoaicon/hoaicon3.jpg"
                alt="Hoa Cam" />
              <span>Hoa Cam</span>
            </td>
            <td class="item-price" data-price="256000">256,000 VND</td>
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
                  value="3"
                  style="max-width: 50px"
                  readonly />
                <button
                  class="btn btn-outline-secondary"
                  onclick="updateQuantity(this, 1)">
                  +
                </button>
              </div>
            </td>
            <td class="item-total">768,000 VND</td>
            <td>
              <button
                class="btn btn-danger btn-sm"
                onclick="removeItem(this)">
                X
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="d-flex justify-content-between py-4">
        <a href="thanhtoan.html">
          <button class="btn btn-primary">Mua Ngay</button>
        </a>

        <div class="cart-total py-4">
          Tổng cộng: <span id="cart-total">2,304,000 VND</span>
        </div>
      </div>
    </div>
  </setion>
  <?php include 'footer.php'; ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function updateQuantity(button, change) {
      const quantityInput = button
        .closest(".input-group")
        .querySelector(".item-quantity");
      let currentQuantity = parseInt(quantityInput.value);

      // Update quantity based on button click
      currentQuantity += change;
      if (currentQuantity < 1) currentQuantity = 1;
      quantityInput.value = currentQuantity;

      // Update item total
      const itemRow = button.closest("tr");
      const price = parseInt(
        itemRow.querySelector(".item-price").dataset.price
      );
      const itemTotal = itemRow.querySelector(".item-total");
      itemTotal.textContent =
        new Intl.NumberFormat("vi-VN").format(price * currentQuantity) +
        " VND";

      // Update cart total
      updateCartTotal();
    }

    function updateCartTotal() {
      let total = 0;
      document.querySelectorAll(".cart-item").forEach((item) => {
        const itemTotal = parseInt(
          item.querySelector(".item-total").textContent.replace(/[^0-9]/g, "")
        );
        total += itemTotal;
      });
      document.getElementById("cart-total").textContent =
        new Intl.NumberFormat("vi-VN").format(total) + " VND";
    }

    function removeItem(button) {
      const itemRow = button.closest("tr");
      itemRow.remove();
      updateCartTotal();
    }
  </script>
</body>

</html>