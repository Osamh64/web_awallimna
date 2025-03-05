<?php
echo '<!DOCTYPE html>';
echo '<html dir="rtl" lang="ar">';
echo '<head>';
echo '<meta charset="UTF-8">';
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">'; // تم إزالة تكرار تعريف الترميز
echo '<title>إنشاء حساب شخصي - عوالمنا</title>';
echo '<link rel="icon" href="Website.jpg">';
echo '<link rel="stylesheet" href="style.css">';
echo '<script src="script.js"></script>';
echo '<script src="center_country.js"></script>'; // تم تصحيح اسم الملف إذا كان هناك خطأ
echo '</head>';
echo '<body>';
echo '<div class="header-left">';
echo '<a href="index.html" class="logo-link">';
echo '<img src="Website.jpg" alt="شعار عوالمنا" height="50" width="50">';
echo 'عوالمنا';
echo '</a>';
echo '</div>';

echo '<div class="registration-container" role="main">';
echo '<form id="registrationForm" action="register.php" method="POST" onsubmit="return validateForm()">'; // تم تغيير الامتداد إلى .php
echo '<div class="error-messages"></div>'; // قسم لعرض رسائل الخطأ
echo '<div class="success-message"></div>'; // قسم لعرض رسائل النجاح

// تم إصلاح تكرار الـ IDs بإضافة "-container" إلى الـ divs الأم
echo '<div id="username-container" class="username">';
echo '<label for="username">اسم المستخدم:</label>';
echo '<input type="text" id="username" name="username" required>';
echo '</div>';

echo '<div id="account_name-container" class="account_name">';
echo '<label for="account_name">اسم الحساب:</label>'; // تم تصحيح العبارة العربية
echo '<input type="text" id="account_name" name="account_name" required>';
echo '</div>';

echo '<div id="email-container" class="email">';
echo '<label for="email">البريد الإلكتروني:</label>';
echo '<input type="email" id="email" name="email" required>';
echo '</div>';

echo '<div id="password-container" class="password">';
echo '<label for="password">كلمة المرور:</label>';
echo '<input type="password" id="password" name="password" required>';
echo '</div>';

echo '<div id="confirm_password-container" class="confirm_password">';
echo '<label for="confirm_password">تأكيد كلمة المرور:</label>';
echo '<input type="password" id="confirm_password" name="confirm_password" required>';
echo '</div>';

echo '<div id="birth_date-container" class="birth_date">';
echo '<label for="birth_date">تاريخ الميلاد:</label>';
echo '<input type="date" id="birth_date" name="birth_date" required>';
echo '</div>';

echo '<div id="gender-container" class="gender">';
echo '<label for="gender">الجنس:</label>';
echo '<select id="gender" name="gender" required>';
echo '<option value="">اختر الجنس</option>';
echo '<option value="male">ذكر</option>';
echo '<option value="female">أنثى</option>';
echo '</select>';
echo '</div>';

echo '<div id="account_type-container" class="account_type">';
echo '<label for="account_type">نوع الحساب:</label>';
echo '<select id="account_type" name="account_type" required>';
echo '<option value="">اختر نوع الحساب</option>';
echo '<option value="writer">كاتب</option>';
echo '<option value="reader">قارئ</option>';
echo '</select>';
echo '</div>';

// تم تصحيح طريقة إدراج ملف PHP
include 'center_country.php'; // تأكد من أن المسار صحيح وأن الملف يحتوي على كود HTML لاختيار الدولة

echo '<p>انشاء حساب هو اقرار منك على الموافقه على شروط الاستخدام وسياسة الخصوصية</p>';

echo '<div class="button-container">'; // تم إضافة كلاس للتحكم في تنسيق الزر
echo '<button type="submit">تسجيل الحساب</button>';
echo '</div>';
echo '</form>';
echo '</div>';
echo '</body>';
echo '</html>';
?>