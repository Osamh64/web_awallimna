<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <meta name="description" content="اكتشف عوالمًا لا حدود لها من الخيال والإبداع على موقعنا، حيث يلتقي الكتّاب والقرّاء ليشاركوا قصصهم ورواياتهم في مساحة آمنة وملهمة.">
    <meta name="keywords" content="قصص, روايات, قصص عالمية, روايات عالمية, كتب, أدب, كتّاب, قرّاء, إبداع, خيال, مغامرة, غموض, علمي, حب, مسابقات كتابية, منصة كتابية, تبادل القصص, تحديات كتابية, منصة روايات, كتابة, كتابة قصص, كتابة روايات, تأليف, مشاركة قصص, مشاركة روايات, موقع أدبي, موقع قصص, موقع روايات, منصة أدبية, منصة قصص, منصة روايات, مجتمع أدبي, مجتمع كتابي, مجتمع قراءة, تفاعل أدبي, تفاعل كتابي, تفاعل قراءة, إلهام كتابي, إلهام قصص, إلهام روايات, تنمية مهارات كتابية, تنمية مهارات قصصية, تنمية مهارات روائية">
</head>
<body>
    <header>
        <div class="location" style="text-align: center;">
            <a href="الموقع.php" style="text-decoration: none; color: inherit;">
                <img src="Website.jpg" alt="صورة الموقع" height="50" width="50">
                <h1 style="display: inline; margin: 0;">عوالمنا</h1>
            </a>
        </div>
    
        <?php
        function users() {
            // التحقق إذا كان التوكن موجودًا (يفترض أن التوكن يتم تخزينه في الجلسة)
            if (isset($_SESSION['user_token'])) {  // التوكن مخزن في الجلسة
                // استخراج اسم المستخدم من التوكن (افترض أنه يمكن استخراج البيانات من التوكن)
                $user_name = getUserNameFromToken($_SESSION['user_token']);
                
                // إذا كان التوكن صالحًا، عرض اسم المستخدم ورابط الخروج
                echo '<div class="header-right">';
                echo '<a href="حساب.php">مرحباً، ' . htmlspecialchars($user_name) . '</a>';
                echo '<a href="تسجيل خروج.php">تسجيل خروج</a>';
                echo '</div>';
            } else {
                // إذا لم يكن هناك توكن (أي لم يسجل الدخول بعد)
                echo '<div class="header-right">';
                echo '<a href="تسجيل دخول.php">تسجيل دخول</a>';
                echo '<a href="انشاء حساب.php">انشاء حساب</a>';
                echo '</div>';
            }
        }
        
            // دالة لاستخراج اسم المستخدم من التوكن (هذه دالة توضيحية وقد تحتاج لتعديل حسب نوع التوكن)
            function getUserNameFromToken($token) {
                // هنا يمكن أن تستخدم مكتبة JWT أو أي طريقة لاستخراج بيانات المستخدم من التوكن
                // مثال توضيحي فقط، يجب عليك معالجة التوكن بشكل آمن
                // return some_decoded_token['username'];
            
                // على سبيل المثال:
                return 'اسم المستخدم من التوكن';
            }
            
            session_start();  // بدء الجلسة
            users();  // تنفيذ الدالة
            ?>
    </header>
    <main>
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
                <li><a href="الفانتازي.php"class="category_title">فانتازي</a></li>
                <li><a href="اطفال.php"class="category_title">اطفال</a></li>
            </ul>
        </div>
        <h2 class="new_story">أحدث القصص</h2>
    </main>
    <footer>
        جميع الحقوق محفوظة &copy; 2024
    </footer>
</body>
</html>

<?php
$myarray = array (
    "Saudi Arabic" => 966,
    "Kueait" => 965
);
foreach($myarray as $key => $value){
    echo $Key . ":" . $value . "\n";
} 
?> 