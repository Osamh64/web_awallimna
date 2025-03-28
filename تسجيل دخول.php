<?php
require_once 'db.php';

// تحقق من أن النموذج تم إرساله
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جلب بيانات المستخدم من النموذج
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // بيانات صحيحة (مثال ثابت - في الواقع تأتي من قاعدة البيانات)
    $valid_username = 'admin';
    $valid_password = '123456';
    
    // التحقق من صحة البيانات
    if ($username === $valid_username && $password === $valid_password) {
        // في حالة النجاح نحول المستخدم لصفحة الترحيب
        header('Location: dashboard.php');
        exit();
    } else {
        // في حالة الفشل نظهر رسالة خطأ
        $login_error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام تسجيل الدخول</title>
    <style>
        /* تنسيقات أساسية */
        body { font-family: 'Arial', sans-serif; max-width: 400px; margin: 0 auto; padding: 20px; }
        .error { color: red; margin: 10px 0; }
        input { width: 100%; padding: 8px; margin: 5px 0; }
        .container { border: 1px solid #ccc; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>تسجيل الدخول</h2>
        
        <!-- إظهار رسالة الخطأ عند الفشل -->
        <?php if (isset($login_error)): ?>
            <div class="error">
                اسم المستخدم أو كلمة المرور غير صحيحة!
            </div>
        <?php endif; ?>

        <!-- النموذج يرسل البيانات لنفس الصفحة -->
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label>اسم المستخدم:</label>
            <input type="text" name="username" 
                   value="<?php echo htmlspecialchars($username ?? ''); ?>" 
                   required>
            
            <label>كلمة المرور:</label>
            <input type="password" name="password" required>
            
            <button type="submit">دخول</button>
        </form>

        <div style="margin-top: 10px;">
            <a href="forgot-password.php">نسيت كلمة المرور؟</a>
        </div>
    </div>
</body>
</html>