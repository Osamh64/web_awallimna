<?php
// ملف الاتصال بقاعدة البيانات

$host = 'localhost';
$user = 'root';
$password = ''; // تأكد من إضافة كلمة المرور الصحيحة
$database = 'data_awallimna'; // اسم قاعدة البيانات

// الاتصال بقاعدة البيانات
$conn = new mysqli($host, $user, $password, $database);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("خطأ في الاتصال بقاعدة البيانات: " . $conn->connect_error);
}
echo "تم الاتصال بقاعدة البيانات بنجاح";

// يمكنك استخدام $conn لعمليات قاعدة البيانات الأخرى هنا

// إغلاق الاتصال
$conn->close();
?>
