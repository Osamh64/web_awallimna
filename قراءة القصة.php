<?php
// بيانات القصص (يمكن استبدالها بقراءة من ملف JSON أو قاعدة بيانات)
$stories = [
    'story1' => [
        'title' => 'القصة الأولى',
        'author' => 'محمد أحمد',
        'content' => 'هذه هي محتوى القصة الأولى...'
    ],
    'story2' => [
        'title' => 'القصة الثانية',
        'author' => 'فاطمة علي',
        'content' => 'هذه هي محتوى القصة الثانية...'
    ],
    // يمكن إضافة المزيد من القصص هنا
];

// الحصول على القصة المختارة من query string
$selectedStory = $_GET['story'] ?? null;

// بيانات القصة المختارة
$storyData = $stories[$selectedStory] ?? null;
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
<header>
    <h1>
        <div class="location">
            <a href="الموقع.html">
                <img src="Website.jpg" alt="صورة الموقع" height="50" width="50">
                <sup style="text-decoration: none;">عوالمنا</sup>
            </a>
        </div>
        <div class="User">
            <a href="تسجيل دخول.html">تسجيل دخول</a> /
            <a href="انشاء حساب.html">انشاء حساب</a>
        </div>
    </h1>
</header>
<br><br><br><br><br>
<div>
    <button id="text-big">تكبير الخط</button>
    <button id="text-small">تصغير الخط</button>
</div>
<div>
    <!-- عرض اسم القصة ومؤلفها ومحتواها -->
    <p id="story-title" style="text-align: center;"><?php echo $storyData['title'] ?? 'اسم القصة غير متوفر'; ?></p>
    <h3 id="story-author">مؤلف القصة: <?php echo $storyData['author'] ?? 'غير معروف'; ?></h3>
    <br><br>
    <article id="story-content">
        <?php echo $storyData['content'] ?? 'لم يتم العثور على محتوى القصة.'; ?>
    </article>
    <br>
    <!-- زر الإبلاغ -->
    <button id="report-button" onclick="reportStory()">الإبلاغ عن مشكلة</button>
</div>

<!-- JavaScript لتكبير وتصغير الخط -->
<script>
    function changeFontSize(size) {
        const content = document.getElementById('story-content');
        const currentSize = window.getComputedStyle(content, null).getPropertyValue('font-size');
        const newSize = parseFloat(currentSize) + size + 'px';
        content.style.fontSize = newSize;
    }

    document.getElementById('text-big').addEventListener('click', () => changeFontSize(2));
    document.getElementById('text-small').addEventListener('click', () => changeFontSize(-2));

    function reportStory() {
        const storyTitle = document.getElementById('story-title').innerText;
        alert(`تم الإبلاغ عن مشكلة في القصة: ${storyTitle}`);
    }
</script>
</body>
</html>