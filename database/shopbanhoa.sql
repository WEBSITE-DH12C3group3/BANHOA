-- Tạo cơ sở dữ liệu
CREATE DATABASE websitehoa;
USE websitehoa;

-- 1. Tạo bảng categories (danh mục sản phẩm)
CREATE TABLE categories (
    id VARCHAR(10) PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

-- 2. Tạo bảng products (sản phẩm)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    sale INT(3),
    price_sale DECIMAL(10, 2),
    stock INT NOT NULL,
    remark TINYINT(1) DEFAULT 0,
    category_id VARCHAR(10) NOT NULL,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- 3. Tạo bảng users (người dùng)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('customer', 'admin') DEFAULT 'customer',  -- Phân quyền người dùng
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Tạo bảng orders (đơn hàng)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(8) NOT NULL,
    user_id INT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(50),
    total DECIMAL(10, 2),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 5. Tạo bảng order_items (chi tiết các sản phẩm trong từng đơn hàng)
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 6. Tạo bảng cart_items (giỏ hàng)
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- 7. Tạo bảng payments (thanh toán)
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    payment_method VARCHAR(50),
    amount DECIMAL(10, 2),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);
