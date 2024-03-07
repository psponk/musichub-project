<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลจากแบบฟอร์ม
    $email = $_POST['email'];
    $userPassword = $_POST['password'];  // Change this variable name to avoid conflict

    // เชื่อมต่อกับฐานข้อมูล MySQL
    $host = 'localhost'; // หรือที่อยู่ของ MySQL Server
    $username = 'root'; // ชื่อผู้ใช้ฐานข้อมูล
    $dbPassword = ''; // รหัสผ่านฐานข้อมูล, use a different variable name
    $database = 'musichub'; // ชื่อฐานข้อมูล

    $conn = new mysqli($host, $username, $dbPassword, $database);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตรวจสอบว่าอีเมลซ้ำหรือไม่
    $checkEmailQuery = "SELECT * FROM userinfo WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        // มีอีเมลนี้ในฐานข้อมูลแล้ว
        echo "<script>alert('อีเมลถูกใช้แล้ว'); window.location.href = 'register.html';</script>";
    } else {
        // อีเมลยังไม่ถูกใช้งาน
        // เพิ่มข้อมูลลงในฐานข้อมูล
        $insertQuery = "INSERT INTO userinfo (email, password) VALUES ('$email', '$userPassword')";

        if ($conn->query($insertQuery) === TRUE) {
            // ลงทะเบียนเรียบร้อย
            echo "<script>alert('ลงทะเบียนสำเร็จแล้ว'); window.location.href = 'login.html';</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    }

    // ปิดการเชื่อมต่อกับฐานข้อมูล
    $conn->close();
}
?>
