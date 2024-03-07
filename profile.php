<?php
// เริ่ม session
session_start();

// ตรวจสอบว่ามี session email หรือไม่ ถ้าไม่มีให้ redirect ไปยังหน้า login
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit;
}

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

// ดึงข้อมูลผู้ใช้จาก session
$email = $_SESSION['email'];

// คิวรีข้อมูลผู้ใช้จากฐานข้อมูล
$query = "SELECT * FROM userinfo WHERE email='$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    // สร้างตัวแปร JSON เพื่อส่งค่ากลับไปยัง JavaScript ในหน้าเว็บ
    $profile_data = array();
    while ($row = $result->fetch_assoc()) {
        $profile_data['email'] = $row['email'];
        $profile_data['password'] = $row['password'];
        $profile_data['register_date'] = $row['registration_timestamp']; // สมมติว่า timestamp เก็บวันที่ลงทะเบียน
    }

    // กำหนดค่าให้กับตัวแปร $password และ $register_date
    $password = $profile_data['password'];
    $register_date = $profile_data['register_date'];

} else {
    echo "ไม่พบข้อมูลผู้ใช้";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="App.css">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <nav>
        <div>
            <a class='nav-button' href='model.html'>MUSIC HUB</a>
        </div>
        <ul>
            <li><a href='voice.html'>Voice</a></li>
            <li><a href='record.html'>Recorder</a></li>
            <li><a href='save.html'>Save</a></li>
            <li><a href='profile.php'>Profile</a></li>
        </ul>
    </nav>
    <div class='profile-container'>
        <div class='profile-username-email' id='email'>
            <p>Email :</p>
            <div class='profile-detail'><?php echo $_SESSION['email'] ; ?></div>
        </div>
        <div class='profile-username-email' id='password'>
            <p>Password :</p>
            <div class='profile-detail'><?php echo $_SESSION['password']; ?></div>
        </div>
        <div class='profile-theme' id='register-date'>
            <p>Register Date :</p>
            <div class='profile-detail'><?php echo $register_date; ?></div>
        </div>
    </div>
    <form method="post" action="logout.php">
        <button type="submit" class='profile-logout'>Logout</button>
    </form>
</body>

</html>