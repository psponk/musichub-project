<?php
// เริ่ม session
session_start();

// เคลียร์ session ทั้งหมด
session_unset();

// ทำลาย session
session_destroy();

// Redirect ไปยังหน้า login.html
echo "<script>alert('ออกจากระบบแล้ว'); window.location.href = 'home.html';</script>";
exit;
?>
