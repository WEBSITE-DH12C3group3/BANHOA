<?php
include '/xampp/htdocs/BANHOA/database/connect.php';

$db = new Database();
function containsScript($input)
{
    return preg_match('/<script\b[^>]*>(.*?)<\/script>/is', $input);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $price = isset($_POST['price']) ? trim($_POST['price']) : '';
    $stock = isset($_POST['stock']) ? trim($_POST['stock']) : '';
    $category_id = isset($_POST['category_id']) ? trim($_POST['category_id']) : '';
    $sale = isset($_POST['sale']) ? trim($_POST['sale']) : '';
    $remark = isset($_POST['remark']) ? trim($_POST['remark']) : '';

    if (containsScript($name) || containsScript($description) || containsScript($price)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Dữ liệu không hợp lệ!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }
    // Kiểm tra tên sản phẩm
    if (empty($name)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Tên sản phẩm không được để trống!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif (strlen($name) > 220) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Tên quá dài, tối đa 220 ký tự!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif (!preg_match('/^[\p{L}\p{N} ]+$/u', $name)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Tên chỉ được chứa chữ cái, số và khoảng trắng!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    $check_sql = "SELECT COUNT(*) as count FROM products WHERE product_name = ?";
    $stmt = $db->conn->prepare($check_sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Tên sản phẩm đã tồn tại!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Kiểm tra giá
    if (empty($price)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giá không được để trống!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif (!is_numeric($price)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giá phải là số hợp lệ!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif ((float)$price <= 0) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giá sản phẩm phải lớn hơn 0!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif ($price > 100000000) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giá sản phẩm không được lớn hơn 100 triệu đồng!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    // Kiểm tra mô tả
    if (empty($description)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Mô tả không được để trống!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif (strlen($description) > 1000) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Mô tả quá dài!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    // Kiểm tra danh mục
    if (empty($category_id)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Phải chọn danh mục sản phẩm!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    // Kiểm tra nổi bật
    if ($remark === '') {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Vui lòng chọn sản phẩm có nổi bật hay không!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    // Kiểm tra Số lượng
    if (empty($stock)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Số lượng không được để trống!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif ((int)$stock < 0) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Số lượng phải lớn hơn 0!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif ($stock > 1000000) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Số lượng vượt quá giới hạn cho phép!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    // Kiểm tra giảm giá
    if (empty($sale)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giảm giá không được để trống!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif (!is_numeric($sale)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giảm giá phải là số hợp lệ!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif ((int)$sale < 0) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giảm giá phải là số không âm!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    } elseif ($sale > 100) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Giảm giá không được lớn hơn 100%!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }
    // Kiểm tra ảnh
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != UPLOAD_ERR_OK) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Phải chọn ảnh sản phẩm!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    $image = $_FILES['image']['name'];
    $file_type = strtolower(pathinfo($image, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_type, $allowed_types)) {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Định dạng ảnh không hợp lệ!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        exit();
    }

    // Upload ảnh
    $target_path = "../uploads/" . basename($image);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
        // Chuẩn bị thêm dữ liệu
        $stmt = $db->conn->prepare("INSERT INTO products (product_name, image, description, price, sale, stock, category_id, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdiisi", $name, $image, $description, $price, $sale, $stock, $category_id, $remark);

        if ($stmt->execute()) {
            if ($remark == 1) {
                echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Thêm sản phẩm thành công và được gắn cờ nổi bật!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
            } else {
                echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #4CAF50; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Thêm sản phẩm thành công!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
            }
        } else {
            echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Lỗi khi thêm sản phẩm!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
        }

        $stmt->close();
    } else {
        echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Lỗi khi tải ảnh lên!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
    }
} else {
    echo "<div id='custom-alert' style='position: fixed; top: 20px; left: 50%; transform: translateX(-50%); background-color: #ff4444; color: white; padding: 15px; border-radius: 5px; z-index: 1000;'>Yêu cầu không hợp lệ!</div>
<script>
    setTimeout(function() {
        document.getElementById('custom-alert').style.display = 'none';
        window.location.href = 'product.php';
    }, 2000);
</script>";
}
?>