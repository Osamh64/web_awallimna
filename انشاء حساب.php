<?php
// التحقق من الإرسال
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // تكوين قاعدة البيانات
    $host = 'localhost';
    $db   = 'data_awallimna';
    $user = 'root';
    $pass = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('خطأ في الاتصال بقاعدة البيانات: ' . $e->getMessage());
    }

    // جمع البيانات
    $account_type = $_POST['account_type'] ?? '';
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $name = filter_input(INPUT_POST, 'account_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $country = $_POST['center_country'];
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

    $errors = [];

    // التحقق من تطابق كلمة المرور
    if ($password !== $confirm_password) {
        $errors[] = 'كلمة المرور غير متطابقة';
    }

    // التحقق من قوة كلمة المرور
    if (strlen($password) < 8) {
        $errors[] = 'كلمة المرور ضعيفة (الحد الأدنى 8 أحرف)';
    }

    // التحقق من البريد الإلكتروني
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'البريد الإلكتروني غير صالح';
    }

    // التحقق من العمر
    $age = date_diff(date_create($birth_date), date_create('now'))->y;
    if ($age < 13) {
        $errors[] = 'يجب أن تكون أكبر من 13 سنة';
    }

    // التحقق من نوع الحساب
    $valid_account_types = ['author', 'admin_author', 'super_admin_author', 
                            'reader', 'admin_reader', 'super_admin_reader'];
    if (!in_array($account_type, $valid_account_types)) {
        $errors[] = 'نوع الحساب غير صالح';
    }

    // التحقق من اسم المستخدم
    $stmt = $pdo->prepare("SELECT id FROM novelist WHERE id = ? 
                          UNION 
                          SELECT id FROM reader WHERE id = ?");
    $stmt->execute(["N_{$username}", "R_{$username}"]);
    if ($stmt->fetch()) {
        $errors[] = 'اسم المستخدم مستخدم مسبقًا';
    }

    // إذا لا توجد أخطاء - إنشاء الحساب
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $id = '';
        
        try {
            $pdo->beginTransaction();
            
            // تحديد الجدول بناءً على نوع الحساب
            switch ($account_type) {
                case 'author':
                    $id = 'N_' . uniqid();
                    $stmt = $pdo->prepare("
                        INSERT INTO novelist 
                        (id, name, email, password, address, birth_date, gender, country, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$id, $name, $email, $hashed_password, $address, $birth_date, $gender, $country]);
                    break;
                    
                case 'admin_author':
                    $id = 'AN_' . uniqid();
                    $stmt = $pdo->prepare("
                        INSERT INTO admin_novelist 
                        (id, name, email, password, address, birth_date, gender, country, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$id, $name, $email, $hashed_password, $address, $birth_date, $gender, $country]);
                    break;
                    
                case 'super_admin_author':
                    $id = 'SAN_' . uniqid();
                    $stmt = $pdo->prepare("
                        INSERT INTO super_admin_novelist 
                        (id, name, email, password, address, birth_date, gender, country, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$id, $name, $email, $hashed_password, $address, $birth_date, $gender, $country]);
                    break;
                    
                case 'reader':
                    $id = 'R_' . uniqid();
                    $stmt = $pdo->prepare("
                        INSERT INTO reader 
                        (id, name, email, password, address, birth_date, gender, country, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$id, $name, $email, $hashed_password, $address, $birth_date, $gender, $country]);
                    break;
                    
                case 'admin_reader':
                    $id = 'AR_' . uniqid();
                    $stmt = $pdo->prepare("
                        INSERT INTO admin_reader 
                        (id, name, email, password, address, birth_date, gender, country, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$id, $name, $email, $hashed_password, $address, $birth_date, $gender, $country]);
                    break;
                    
                case 'super_admin_reader':
                    $id = 'SAR_' . uniqid();
                    $stmt = $pdo->prepare("
                        INSERT INTO super_admin_reader 
                        (id, name, email, password, address, birth_date, gender, country, created_at) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                    ");
                    $stmt->execute([$id, $name, $email, $hashed_password, $address, $birth_date, $gender, $country]);
                    break;
            }
            
            $pdo->commit();
            echo '<script>alert("تم التسجيل بنجاح!"); window.location.href = "login.php";</script>';
            exit;
            
        } catch (Exception $e) {
            $pdo->rollBack();
            $errors[] = 'خطأ في إنشاء الحساب: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب - عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <style>
        /* ... نفس التنسيقات السابقة مع إضافة حقل العنوان ... */
    </style>
</head>
<body>
    <div class="header-left">
        <a href="الموقع.php">
            <img src="Website.jpg" alt="شعار الموقع">
            <h1>عوالمنا</h1>
        </a>
    </div>

    <div class="registration-container">
        <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <div><?= $error ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
            <div class="form-group">
                <label>اسم المستخدم:</label>
                <input type="text" name="username" required>
            </div>

            <div class="form-group">
                <label>الاسم الظاهر:</label>
                <input type="text" name="account_name" required>
            </div>

            <div class="form-group">
                <label>العنوان:</label>
                <input type="text" name="address" required>
            </div>

            <div class="form-group">
                <label>البريد الإلكتروني:</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>كلمة المرور:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>تأكيد كلمة المرور:</label>
                <input type="password" name="confirm_password" required>
            </div>

            <div class="form-group">
                <label>تاريخ الميلاد:</label>
                <input type="date" name="birth_date" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" required>
                <small>يجب أن يكون الحساب 18 سنة على الأقل.</small>
            </div>

            <div class="form-group">
                <label>الجنس:</label>
                <select name="gender" required>
                    <option value="">اختر</option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
            </div>

            <div class="form-group">
                <label>نوع الحساب:</label>
                <select name="account_type" required>
                    <option value="">اختر</option>
                    <option value="author">كاتب</option>
                    <option value="admin_author">أدمن كاتب</option>
                    <option value="super_admin_author">سوبر أدمن كاتب</option>
                    <option value="reader">قارئ</option>
                    <option value="admin_reader">أدمن قارئ</option>
                    <option value="super_admin_reader">سوبر أدمن قارئ</option>
                </select>
            </div>

            <div id="center_address" class="form-group">
                <label>البلد:</label>
                <select name="center_country" id="country" required>
                    <option value="">اختر البلد</option>
                </select>
            </div>

            <button type="submit">إنشاء الحساب</button>
        </form>
    </div>


    <!-- ملف الدول -->
    <script src="center_country.js"></script>
    <script id="country-script">
    document.addEventListener('DOMContentLoaded', () => {
        const countrySelect = document.getElementById('country');
        
        // تحقق من وجود الملف والمصفوفة
        if (typeof countries === 'undefined') {
            console.error('⚠️ ملف الدول لم يتم تحميله بشكل صحيح!');
            return;
        }
        
        // تحقق من وجود عنصر البلد
        if (!countrySelect) {
            console.error('⚠️ عنصر البلد غير موجود في الصفحة!');
            return;
        }
    
        // تعبئة الدول
        countries.forEach(country => {
            const option = document.createElement('option');
            option.value = country;
            option.textContent = country;
            countrySelect.appendChild(option);
        });
    });
    </script>
</body>
</html>