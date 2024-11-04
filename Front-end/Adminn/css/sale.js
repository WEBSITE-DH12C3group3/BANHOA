const saleInput = document.getElementById("sale");

saleInput.addEventListener("input", () => {
  let value = parseInt(saleInput.value);

  if (isNaN(value) || value < 1) {
    saleInput.value = 1;
  } else if (value > 99) {
    saleInput.value = 99;
  }
});

// Kiểm tra lại giá trị trước khi gửi form
const form = document.querySelector("form"); // Thay 'form' bằng selector của form của bạn

form.addEventListener("submit", (event) => {
  let sale = parseInt(saleInput.value);

  if (isNaN(sale) || sale < 1 || sale > 99) {
    alert("Giá trị sale phải nằm trong khoảng từ 1 đến 99.");
    event.preventDefault(); // Ngăn chặn form submit
  }

  // ... other form submission logic
});
