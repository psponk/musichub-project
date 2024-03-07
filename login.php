<?php
// เริ่ม session
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลที่ส่งมาจากฟอร์ม
    $email = $_POST['email'];
    $password = $_POST['password'];

    // เชื่อมต่อกับฐานข้อมูล MySQL
    $host = 'localhost'; // หรือที่อยู่ของ MySQL Server
    $db_username = 'root'; // ชื่อผู้ใช้ฐานข้อมูล
    $db_password = ''; // รหัสผ่านฐานข้อมูล
    $database = 'musichub'; // ชื่อฐานข้อมูล

    $conn = new mysqli($host, $db_username, $db_password, $database);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบการล็อกอิน
    $query = "SELECT * FROM userinfo WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // ถ้าการล็อกอินสำเร็จ ให้เก็บข้อมูลผู้ใช้ใน session
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        while ($row = $result->fetch_assoc()) {
            $_SESSION['id'] = $row['id'];
        }
        // ส่งผู้ใช้ไปยังหน้า home.html
        echo "<script>alert('login สำเร็จแล้ว') ; window.location.href = 'model.html';</script>";
    } else {
        // ถ้าไม่สำเร็จ ให้ redirect กลับไปที่หน้า login พร้อมส่งข้อความแจ้งเตือนผิดพลาด
        echo "<script>alert('อีเมลหรือรหัสผ่านไม่ถูกต้อง'); window.location.href = 'login.html';</script>";
        exit;
    }

    $conn->close();
}
?>
