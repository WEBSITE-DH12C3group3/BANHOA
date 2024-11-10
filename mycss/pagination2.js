$(document).ready(function () {
  var rowsShown = 8;
  var rowsTotal = $("#Table div a").length;
  var numPages = Math.ceil(rowsTotal / rowsShown);

  // Tạo phân aang
  var paginationHtml = '<ul class="pagination justify-content-center">';
  for (var i = 1; i <= numPages; i++) {
    paginationHtml +=
      '<li class="page-item" data-page="' +
      i +
      '"><a class="page-link" href="?page=' +
      i +
      '">' +
      i +
      "</a></li>";
  }
  paginationHtml += "</ul>";
  $("#pagination").html(paginationHtml);

  function showPage(pageNum) {
    var startItem = (pageNum - 1) * rowsShown;
    var endItem = startItem + rowsShown;

    $("#Table div a").hide().slice(startItem, endItem).show();

    // Đánh dấu trang hiện tại là active
    $(".pagination li").removeClass("active");
    $('.pagination li[data-page="' + pageNum + '"]').addClass("active");
  }

  // Lấy trang hiện tại từ URL
  var currentPage =
    parseInt(new URLSearchParams(window.location.search).get("page")) || 1;

  // Hiển thị trang hiện tại
  showPage(currentPage);

  // Xử lý sự kiện click trên phân trang
  $(".pagination li a").click(function (e) {
    e.preventDefault();
    var pageNum = parseInt($(this).parent().data("page"));

    showPage(pageNum);

    // Cập nhật URL
    window.history.pushState(
      {
        page: pageNum,
      },
      "",
      "?page=" + pageNum
    );
  });

  // Xử lý sự kiện popstate (khi người dùng nhấn nút Back/Forward)
  window.addEventListener("popstate", function (event) {
    var pageNum = event.state ? event.state.page : 1; // Trang mặc định là 1 nếu không có state
    showPage(pageNum);
  });
});
