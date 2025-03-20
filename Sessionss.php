<?php
// بدء الجلسة
session_start();

// تخزين المتغيرات الأساسية فقط
$_SESSION['username'] = "Osama"; // اسم المستخدم
$_SESSION['user_role'] = "Admin"; // دور المستخدم
$_SESSION['user_token'] = "user_token_123"; // توكن المصادقة
?>
