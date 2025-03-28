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
    <style>
         /* أنماط عامة */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html, body {
    width: 100%;
    height: 100%;
    font-family: Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5;
    color: var(--text-color);
    background-color: var(--secondary-color);
}

/* المتغيرات */
:root {
    --primary-color: #333;
    --secondary-color: #f4f4f4;
    --text-color: #000;
    --highlight-color: #555;
}

/* رأس الصفحة وتذييل الصفحة */
header, footer {
    background-color: var(--primary-color);
    color: #fff;
    padding: 10px 20px; /* زيادة التباعد لتحسين المظهر */
    text-align: center;
    position: fixed;
    left: 0;
    width: 100%;
    z-index: 1000;
}

header {
    top: 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

footer {
    bottom: 0;
}

/* عناصر رأس الصفحة */
.header-left, .header-right {
    display: flex;
    align-items: center;
}

.header-left img {
    height: 40px;
    margin-right: 10px;
}

.header-left a, .header-right a {
    margin-left: 15px;
    color: #fff;
    text-decoration: none;
    transition: color 0.3s ease;
}

.header-left a:hover, .header-right a:hover {
    color: var(--highlight-color);
    text-decoration: underline;
    cursor: pointer;
}

/* محتوى الصفحة الرئيسي */
main {
    padding: 80px 20px 20px; /* تعديل التباعد لتحسين المسافة بين المحتوى والرأس */
    text-align: left; /* محاذاة النص لليسار لتحسين القراءة */
}

/* الجداول */
table {
    width: 100%; /* جعل الجدول متجاوبًا */
    border: 1px solid black;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid black;
    padding: 10px;
    text-align: center;
}

th {
    background-color: #f2f2f2;
    color: #000;
}

/* قائمة القصص */
.story-list {
    margin-top: 20px;
    display: none; /* مخفية افتراضيًا */
}

/* تعديل تذييل الصفحة */
body {
    padding-bottom: 60px; /* التأكد من أن المحتوى لا يتداخل مع التذييل */
}

/* النماذج */
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px; /* تحديد الحد الأقصى لعرض النموذج */
    margin: 0 auto; /* توسيط النموذج */
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

input[type="text"], input[type="email"], select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

button {
    background-color: var(--primary-color);
    color: #fff;
    padding: 10px 20px;
    border: none;
    cursor: pointer;
    border-radius: 3px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: var(--highlight-color);
}

/* مربع الفئة */
.category-box {
    border: 1px solid #ccc;
    padding: 10px;
    margin: auto; /* توسيط مربع الفئة */
    max-width: 800px; /*تحديد عرض مناسب */
}

.category-box ul {
    list-style: none;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.category-box a {
    text-decoration: none;
    color: var(--text-color);
    padding: 5px 10px;
    border: 1px solid #ddd;
    margin: 5px;
    text-align: center;
    transition: all 0.3s ease;
}

.category-box a:hover {
    background-color: var(--primary-color);
    color: #fff;
}

/* روابط الحساب */
.account-links {
    color: var(--text-color);
    text-align: left;
    position: absolute;
    top: 10px;
    left: 80px;
}

/* صفحة الجانب */
.aside-page {
    position: relative;
}

/* الموقع */
.location {
    display: inline-block;
    text-align: center;
    user-select: none;
    vertical-align: top;
}

/* المستخدم */
.User {
    float: left;
    font-size: 14px;
    text-align: center;
    margin-left: 150px;
}

/* البحث */
.Search {
    text-align: center;
    width: 50%;
    background-color: var(--secondary-color);
    padding: 20px;
    margin: 50px auto 20px;
}

/* عنوان القصة والمؤلف */
.story-title {
    text-align: center;
    margin-bottom: 20px;
}

.story-author {
    text-align: right;
    margin-bottom: 20px;
}

/* قراءة القصة */
.Read-a-story {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 80%;
    height: 100vh;
    margin: 0 auto;
}

/* ضبط النص */
.adjust-text {
    text-align: right;
    font-size: medium;
}

#text-big {
    font-size: large;
}

#text-small {
    font-size: small;
}

/* بطاقات الاشتراك */
body.subscription {
    background-color: #f9f9f9;
    display: flex;
    align-content: center;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    flex-wrap: wrap;
    font-family: 'Raleway', sans-serif; /* إضافة خط احتياطي */
}

/* الجداول */
.tables, .tables-2 {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap; /* تحسين التوافق مع الشاشات الصغيرة */
}

.admin-info {
    align-items: right;
    background-color: #fff; /* خلفية بيضاء للقسم */
    padding: 20px;
    margin: 20px auto;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 800px; /* تحديد عرض مناسب للقسم */
}

/* قسم القصص المطلوب مراجعتها */
.review-stories {
    background-color: #fff; /* خلفية بيضاء للقسم */
    padding: 20px;
    margin: 20px auto;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 800px; /* تحديد عرض مناسب للقسم */
}

.review-stories h2 {
    text-align: center; /* توسيط العنوان */
    margin-bottom: 20px;
    color: var(--primary-color); /* استخدام لون رئيسي للنص */
}

.review-stories ul {
    list-style: none;
    padding: 0;
}

.review-stories li {
    display: flex;
    justify-content: space-between; /* توزيع المحتوى بالتساوي */
    align-items: center;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc; /* حدود رمادية خفيفة */
    border-radius: 3px;
    background-color: #f9f9f9; /* لون خلفية خفيف */
    transition: background-color 0.3s ease;
}

.review-stories li:hover {
    background-color: #f1f1f1; /* تغيير لون الخلفية عند التمرير */
}

.review-stories button {
    background-color: var(--primary-color);
    color: #fff;
    padding: 8px 12px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 14px;
}

.review-stories button:hover {
    background-color: var(--highlight-color);
}

.review-stories .approve-btn {
    margin-right: 5px; /* مسافة صغيرة بين الأزرار */
}

.review-stories .reject-btn {
    background-color: #d9534f; /* لون أحمر لزر الرفض */
}

.review-stories .reject-btn:hover {
    background-color: #c9302c; /* لون أحمر أغمق عند التمرير */
}

    </style>
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