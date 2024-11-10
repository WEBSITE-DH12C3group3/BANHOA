<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Eden | Liên Hệ</title>
  <link
    rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
  <link
    rel="icon"
    type="image/png"
    href="/BANHOA/Front-end/public/Eden.png" />

  <style>
    body {
      background-color: #f8f9fa;
    }

    .contact-form {
      background-color: #fff;
      padding: 40px;
      border-radius: 8px;
    }

    .header {
      text-align: center;
      margin-bottom: 40px;
    }
  </style>
</head>

<body>
  <div class="container mt-4">
    <div class="header">
      <h2>Liên Hệ Với Chúng Tôi</h2>
      <p>Chúng tôi luôn sẵn sàng lắng nghe từ bạn!</p>
    </div>
    <!-- Thông báo gửi thành công -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
      <div class="alert alert-success text-center">
        Cảm ơn bạn! Tin nhắn của bạn đã được gửi thành công.
      </div>
    <?php endif; ?>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="contact-form">
          <form action="submit_contact.php" method="post">
            <div class="form-group">
              <label for="name">Tên của bạn</label>
              <input
                type="text"
                class="form-control"
                id="name"
                name="name"
                required />
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input
                type="email"
                class="form-control"
                id="email"
                name="email"
                required />
            </div>
            <div class="form-group">
              <label for="message">Nội dung liên hệ</label>
              <textarea
                class="form-control"
                id="message"
                name="message"
                rows="4"
                required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block">
              Gửi
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php include 'footer.php'; ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>