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
    <h1>حذف حساب</h1>
    <p>هل تريد خذف الحساب نهائي او تجميد؟</p>
    
    <form action="/delete-account" method="post">
        <input type="hidden" name="_method" value="delete">
        
        <label>سبب الحذف:</label><br>
        <input type="radio" id="no_longer_needed" name="reason" value="no_longer_needed">
        <label for="no_longer_needed">لا أحتاجه بعد</label><br>
        
        <input type="radio" id="privacy_concern" name="reason" value="privacy_concern">
        <label for="privacy_concern">قلق بشأن الخصوصية</label><br>
        
        <input type="radio" id="moving_to_another_service" name="reason" value="moving_to_another_service">
        <label for="moving_to_another_service">الانتقال إلى خدمة أخرى</label><br>
        
        <input type="radio" id="other" name="reason" value="other">
        <label for="other">أخرى (يرجى التوضيح)</label><br><br>
        
        <label for="additional_info">معلومات إضافية (اختياري):</label><br>
        <textarea id="additional_info" name="additional_info" rows="4" cols="50"></textarea><br><br>
        
        <button type="submit" name="action" value="freeze">تجميد</button>
        <button type="submit" name="action" value="delete" href="code My location/تم الحذف.php">حذف حساب نهائي</button>
    </form>
</body>
</html>
