function search() {
  var searchValue = document.getElementById("searchBox").value.toLowerCase();
  var rows = document.querySelectorAll("table tbody tr");
  var found = false; // Biến để kiểm tra xem có kết quả tìm kiếm nào không
  rows.forEach(function (row) {
    var match = false;
    // Duyệt qua tất cả các ô trong hàng
    for (var i = 0; i < row.cells.length; i++) {
      var cellText = row.cells[i].textContent.toLowerCase();
      if (cellText.includes(searchValue)) {
        match = true;
        found = true; // Có kết quả tìm kiếm, đặt biến found thành true
        break;
      }
    }
    // Hiển thị hoặc ẩn dòng tùy theo kết quả tìm kiếm
    row.style.display = match ? "" : "none";
  });
  noResult.style.display = found ? "none" : "block"; // Hiển thị hoặc ẩn thông báo không tìm thấy kết quả
}
