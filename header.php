<?php
session_start();
include_once 'Sessionss.php'; // تحميل بيانات الجلسة
?>

<header>
    <div class="location" style="text-align: center;">
        <a href="الموقع.html" style="text-decoration: none; color: inherit;">
            <img src="Website.jpg" alt="صورة الموقع" height="50" width="50">
            <h1 style="display: inline; margin: 0;">عوالمنا</h1>
        </a>
    </div>

    <form method="GET">
        البحث عن قصة: <input type="text" name="q" id="searchInput">
        <input type="submit" value="ابحث" onclick="search(); return true;">
    </form>

    <div class="header-right">
        <?php
        if (isset($_SESSION['username'])) {
            echo '<span>مرحبًا، ' . htmlspecialchars($_SESSION['username']) . '!</span>';
            echo ' | <a href="تسجيل خروج.php">تسجيل خروج</a>';
        } else {
            echo '<a href="تسجيل دخول.php">تسجيل دخول</a>';
            echo '<a href="انشاء حساب.php">انشاء حساب</a>';
        }
        ?>
    </div>
</header>
