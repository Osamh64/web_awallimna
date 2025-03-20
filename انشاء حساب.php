<?php
// التحقق من الإرسال
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // تكوين قاعدة البيانات (غيّر هذه القيم حسب بياناتك)
    $host = 'localhost';
    $db   = 'your_database';
    $user = 'root';
    $pass = '';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die('خطأ في الاتصال بقاعدة البيانات: ' . $e->getMessage());
    }

    // جمع البيانات
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $account_name = filter_input(INPUT_POST, 'account_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $account_type = $_POST['account_type'];
    $country = $_POST['center_country'];

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

    // التحقق من اسم المستخدم
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $errors[] = 'اسم المستخدم مستخدم مسبقًا';
    }

    // إذا لا توجد أخطاء - إنشاء الحساب
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $pdo->prepare("
            INSERT INTO users 
            (username, account_name, email, password, birth_date, gender, account_type, country, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");
        
        if ($stmt->execute([$username, $account_name, $email, $hashed_password, $birth_date, $gender, $account_type, $country])) {
            echo '<script>alert("تم التسجيل بنجاح!"); window.location.href = "login.php";</script>';
            exit;
        } else {
            $errors[] = 'خطأ في إنشاء الحساب';
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
        /* تنسيقات CSS مدمجة */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f2f5;
        }

        .registration-container {
            max-width: 500px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .error {
            color: #dc3545;
            margin-top: 5px;
            font-size: 0.9em;
        }

        button {
            background: #28a745;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        button:hover {
            background: #218838;
        }

        .header-left {
            text-align: center;
            margin-bottom: 30px;
        }

        .header-left img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }
    </style>
</head>
<body>
    <div class="header-left">
        <a href="الموقع.php">
            <img src="Website.jpg" alt="شعار الموقع">
            <h1 >عوالمنا</h1>
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
                <input type="date" name="birth_date" max="<?= date('Y-m-d', strtotime('-13 years')) ?>" required>
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
                    <option value="writer">كاتب</option>
                    <option value="reader">قارئ</option>
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