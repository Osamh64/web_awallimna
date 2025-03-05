<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
<?php
include 'header.php';
?>


    <main>
        <div class="search">
            <form method="GET" onsubmit="return search()">
                <input type="text" name="q" id="searchInput" placeholder="البحث عن قصة">
                <input type="submit" value="ابحث">
            </form>
        </div>

        <div class="category-box">
            <ul>
                <li><a href="الكوميديا.html" class="category-title">كوميديا</a></li>
                <li><a href="الخيال العلمي.html" class="category-title">خيال علمي</a></li>
                <li><a href="الخيال.html" class="category-title">خيال</a></li>
                <li><a href="الرومانسية.html" class="category-title">الرومانسي</a></li>
                <li><a href="الجريمة والتحقيق.html" class="category-title">جريمة وتحقيق</a></li>
                <li><a href="الرعب.html" class="category-title">الرعب</a></li>
                <li><a href="المغامرة.html" class="category-title">مغامرة</a></li>
                <li><a href="دراما.html" class="category-title">دراما</a></li>
                <li><a href="التاريخية.html" class="category-title">تاريخي</a></li>
                <li><a href="سرقة.html" class="category-title">سرقة</a></li>
                <li><a href="حرب.html" class="category-title">حرب</a></li>
                <li><a href="الفانتازي.html" class="category-title">فانتازي</a></li>
                <li><a href="اطفال.html" class="category-title">اطفال</a></li>
            </ul>
        </div>

        <div class="age-groups">
            <h2>الفئات العمرية</h2>
            <button onclick="filterByAge('0-6')">من 0 إلى 6</button>
            <button onclick="filterByAge('7-12')">من 7 إلى 12</button>
            <button onclick="filterByAge('13-17')">من 13 إلى 17</button>
        </div>

        <div class="latest-stories">
            <h2 class="new_story">أحدث القصص</h2>
        </div>
    </main>

    <footer>
        جميع الحقوق محفوظة &copy; 2024
    </footer>
</body>
</html>
