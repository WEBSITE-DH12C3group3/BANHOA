<?php
class Database
{
    private $host = "localhost";  // Địa chỉ máy chủ
    private $user = "root";       // Tên người dùng MySQL
    private $pass = "";           // Mật khẩu MySQL
    private $dbname = "websitehoa";  // Tên cơ sở dữ liệu

    public $conn;

    // Kết nối cơ sở dữ liệu
    public function __construct()
    {
        $this->connect();
    }

    // Phương thức kết nối
    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }

    // Phương thức chèn dữ liệu
    public function insert($query)
    {
        $insert_row = $this->conn->query($query);
        if ($insert_row) {
            return true;  // Chèn thành công
        } else {
            // Xử lý lỗi nếu có
            die("Lỗi: " . $this->conn->error);
        }
    }

    // Phương thức SELECT
    public function select($query)
    {
        $result = $this->conn->query($query) or
            die($this->conn->error . __LINE__);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    public function update($query)
    {
        $result = $this->conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function delete($query)
    {
        $result = $this->conn->query($query);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}
