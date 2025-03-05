<?php
session_start();
session_destroy(); // إنهاء الجلسة
header("Location: الموقع.php"); // إعادة التوجيه إلى الصفحة الرئيسية
exit();
?>
