<?php
// تأكد من تمرير اسم المركز عبر URL
if (!isset($_GET['center'])) {
    header("Location: الموقع.php");
    exit;
}

// تنظيف اسم المركز من أي ترميز خبيث
$center_name = htmlspecialchars(urldecode($_GET['center']));
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>طلب قبول مركز تعليمي - عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
            text-align: center;
        }
        .success-box {
            background: #d4edda;
            color: #155724;
            padding: 40px;
            border-radius: 15px;
            border: 2px solid #c3e6cb;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success-box h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }
        .success-box p {
            font-size: 1.2em;
            margin: 20px 0;
        }
        .btn {
            background: #4CAF50;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
            display: inline-block;
            margin-top: 25px;
        }
        .btn:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="success-box">
        <h2>تهانينا!</h2>
        <p>تم استلام طلب مركز <strong><?= $center_name ?></strong> بنجاح</p>
        <p>سيتم مراجعة الطلب من قبل الإدارة خلال 24-48 ساعة عمل</p>
        <p>وسنتواصل معكم عبر البريد الإلكتروني للمتابعة</p>
        <a href="الموقع.php" class="btn">العودة إلى الصفحة الرئيسية</a>
    </div>
</body>
</html>