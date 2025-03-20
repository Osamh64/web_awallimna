<?php
// يجب بدء الجلسة في الأعلى قبل أي إخراج لتجنب أخطاء الهيدر
session_start();

// دالة استخراج اسم المستخدم من التوكن
function getUserNameFromToken(string $token): string
{
    // هنا يجب استخدام مكتبة JWT أو طريقة آمنة لفك التشفير
    // هذا مثال افتراضي فقط
    return 'Guest';
}

function users() {
    if (isset($_SESSION['user_token'])) {
        // استخراج اسم المستخدم من التوكن
        $user_name = getUserNameFromToken($_SESSION['user_token']);
        ?>
        <div class="header-right">
            <!-- ترحيب آمن مع تهريب XSS -->
            <a href="تسجيل دخول.php">تسجيل دخول <?= htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8') ?></a>
            <a href="انشاء حساب.php">انشاء حساب</a>
        </div>
        <?php
    } else {
        ?>
        <div class="header-right">
            <a href="تسجيل دخول.php">تسجيل دخول</a>
            <a href="انشاء حساب.php">انشاء حساب</a>
        </div>
        <?php
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا</title>
    <link rel="icon" href="website.jpg"> <!-- تصحيح اسم الأيقونة ليكون متناسقًا -->
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <meta name="description" content="اكتشف عوالمًا لا حدود لها من الخيال والإبداع على موقعنا، حيث يلتقي الكتّاب والقرّاء ليشاركوا قصصهم ورواياتهم في مساحة آمنة وملهمة.">
    <meta name="keywords" content="قصص, روايات, قصص عالمية, روايات عالمية, كتب, أدب, كتّاب, قرّاء, إبداع, خيال, مغامرة, غموض, علمي, حب, مسابقات كتابية, منصة كتابية, تبادل القصص, تحديات كتابية, منصة روايات, كتابة, كتابة قصص, كتابة روايات, تأليف, مشاركة قصص, مشاركة روايات, موقع أدبي, موقع قصص, موقع روايات, منصة أدبية, منصة قصص, منصة روايات, مجتمع أدبي, مجتمع كتابي, مجتمع قراءة, تفاعل أدبي, تفاعل كتابي, تفاعل قراءة, إلهام كتابي, إلهام قصص, إلهام روايات, تنمية مهارات كتابية, تنمية مهارات قصصية, تنمية مهارات روائية">
</head>
<body>
    <header>
        <div class="location" style="text-align: center;">
            <a href="الموقع.php" style="text-decoration: none; color: inherit;">
                <!-- تصحيح النص البديل للصورة -->
                <img src="website.jpg" alt="شعار الموقع" height="50" width="50">
                <h1 style="display: inline; margin: 0;">عوالمنا</h1>
            </a>
        </div>
        <?php users(); ?> <!-- استدعاء الدالة بعد التهيئة الصحيحة -->
    </header>
    <main>
        <br>
        <div class="category-box">
            <ul>
                <li><a href="الكوميديا.php" class="category_title">كوميديا</a></li>
                <li><a href="الخيال العلمي.php" class="category_title">خيال علمي</a></li>
                <li><a href="الخيال.php" class="category_title">خيال</a></li>
                <li><a href="الرومانسية.php" class="category_title">الرومانسي</a></li>
                <li><a href="الجريمة والتحقيق.php" class="category_title">جريمة وتحقيق</a></li>
                <li><a href="الرعب.php" class="category_title">الرعب</a></li>
                <li><a href="المغامرة.php" class="category_title">مغامرة</a></li>
                <li><a href="دراما.php" class="category_title">دراما</a></li>
                <li><a href="التاريخية.php" class="category_title">تاريخي</a></li>
                <li><a href="سرقة.php" class="category_title">سرقة</a></li>
                <li><a href="حرب.php" class="category_title">حرب</a></li>
                <li><a href="الفانتازي.php" class="category_title">فانتازي</a></li>
                <li><a href="اطفال.php" class="category_title">اطفال</a></li>
            </ul>
        </div>
        <h2 class="new_story">أحدث القصص</h2>
    </main>
    <footer>
        جميع الحقوق محفوظة &copy; 2024
    </footer>
</body>
</html>