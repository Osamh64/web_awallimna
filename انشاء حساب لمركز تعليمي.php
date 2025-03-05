<?php
// بدء الجلسة
session_start();

// تهيئة متغيرات الخطأ والنجاح
$errors = [];
$success = false;

// التحقق من أن الطلب هو POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام البيانات من النموذج
    $owner_name = $_POST['owner_name'] ?? '';
    $center_name = $_POST['center_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $center_address = $_POST['center_address'] ?? '';
    $employee_accounts = $_POST['employee_accounts'] ?? '';
    $email_type = $_POST['email_type'] ?? '';

    // التحقق من صحة اسم المالك
    if (empty($owner_name)) {
        $errors['owner_name'] = 'يرجى إدخال اسم المالك';
    }

    // التحقق من صحة اسم المركز
    if (empty($center_name)) {
        $errors['center_name'] = 'يرجى إدخال اسم المركز';
    }

    // التحقق من صحة البريد الإلكتروني
    if (empty($email)) {
        $errors['email'] = 'يرجى إدخال البريد الإلكتروني';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'يرجى إدخال بريد إلكتروني صحيح';
    }

    // التحقق من صحة كلمة المرور
    if (empty($password)) {
        $errors['password'] = 'يرجى إدخال كلمة المرور';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل';
    }

    // التحقق من تطابق كلمة المرور
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'كلمات المرور غير متطابقة';
    }

    // التحقق من صحة عنوان المركز
    if (empty($center_address)) {
        $errors['center_address'] = 'يرجى إدخال عنوان المركز';
    }

    // التحقق من صحة عدد حسابات المعلمين
    if (empty($employee_accounts)) {
        $errors['employee_accounts'] = 'يرجى إدخال عدد حسابات المعلمين';
    } elseif (!is_numeric($employee_accounts) || intval($employee_accounts) < 1) {
        $errors['employee_accounts'] = 'يرجى إدخال رقم صحيح أكبر من الصفر';
    }

    // التحقق من اختيار نوع البريد الإلكتروني
    if (empty($email_type)) {
        $errors['email_type'] = 'يرجى اختيار نوع البريد الإلكتروني';
    }

    // إذا لم تكن هناك أخطاء، قم بمعالجة البيانات
    if (empty($errors)) {
        // تشفير كلمة المرور للأمان
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        try {
            // اتصال بقاعدة البيانات (قم بتعديل المعلومات حسب إعدادات قاعدة البيانات الخاصة بك)
            $servername = "localhost";
            $username = "root";
            $db_password = "";
            $dbname = "awalimna_db";
            
            $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // إعداد الاستعلام لإدخال البيانات
            $stmt = $conn->prepare("INSERT INTO centers (owner_name, center_name, email, password, center_address, employee_accounts, email_type, created_at) 
                                   VALUES (:owner_name, :center_name, :email, :password, :center_address, :employee_accounts, :email_type, NOW())");
            
            // ربط القيم بالاستعلام
            $stmt->bindParam(':owner_name', $owner_name); // اسم المالك
            $stmt->bindParam(':center_name', $center_name); // اسم المركز التعليمي
            $stmt->bindParam(':email', $email); // البريد الإلكتروني لمالك التعليمي
            $stmt->bindParam(':password', $hashed_password); // كلمة السر
            $stmt->bindParam(':center_address', $center_address); // الموقع
            $stmt->bindParam(':employee_accounts', $employee_accounts); // عدد حسابات المعلمين
            $stmt->bindParam(':email_type', $email_type); // نوع البريد الالكتروني
            
            // تنفيذ الاستعلام
            $stmt->execute();
            
            // تعيين رسالة النجاح
            $success = true;
            
            // إعادة التوجيه بعد فترة زمنية
            header("refresh:3;url=تم الارسال مركز تعليمي.php");
            
        } catch(PDOException $e) {
            $errors['database'] = "حدث خطأ أثناء حفظ البيانات: " . $e->getMessage();
        }
        
        // إغلاق الاتصال
        $conn = null;
    }
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="صفحة إنشاء حساب مركز تعليمي في موقع عوالمنا التعليمي">
    <title>إنشاء حساب مركز تعليمي - عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="style.css">
    <!-- تضمين الخط العربي ناتو سانس -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
        }
        
        body {
            font-family: 'Noto Sans Arabic', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: var(--dark-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        .location {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }
        
        .logo-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .logo-link img {
            margin-left: 10px;
            border-radius: 50%;
        }
        
        h1 {
            text-align: center;
            margin: 0;
            font-size: 1.8rem;
        }
        
        .registration-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin: 2rem auto;
            max-width: 600px;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .address-group {
            display: flex;
            gap: 10px;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark-color);
        }
        
        input, select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            font-family: 'Noto Sans Arabic', sans-serif;
            transition: border-color 0.3s;
        }
        
        input:focus, select:focus {
            border-color: var(--secondary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        input.error-input, select.error-input {
            border-color: var(--accent-color);
        }
        
        button {
            background-color: var(--secondary-color);
            color: white;
            border: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s;
            font-family: 'Noto Sans Arabic', sans-serif;
        }
        
        button:hover {
            background-color: #2980b9;
        }
        
        .location-btn {
            background-color: #27ae60;
            flex-shrink: 0;
        }
        
        .location-btn:hover {
            background-color: #219d55;
        }
        
        .error-message {
            color: var(--accent-color);
            font-size: 0.9rem;
            margin-top: 0.5rem;
            display: block;
        }
        
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        footer {
            text-align: center;
            padding: 1.5rem 0;
            margin-top: 2rem;
            color: #7f8c8d;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .registration-container {
                padding: 1.5rem;
                margin: 1rem;
            }
            
            h1 {
                font-size: 1.5rem;
            }
            
            .address-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .location-btn {
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="location">
                <a href="الموقع.php" class="logo-link">
                    <img src="Website.jpg" alt="شعار عوالمنا" height="50" width="50">
                    <span>عوالمنا</span>
                </a>
            </div>
            <h1>إنشاء حساب مركز تعليمي جديد</h1>
        </header>

        <main id="centerRegistrationForm" class="registration-container">
            <?php if ($success): ?>
            <div class="success-message">
                تم إرسال طلبك بنجاح. سيتم مراجعته من قبل الإدارة والرد عليك قريباً.
                <br>جاري تحويلك إلى صفحة التأكيد...
            </div>
            <?php endif; ?>

            <?php if (isset($errors['database'])): ?>
            <div class="error-message" style="background-color: #f8d7da; padding: 10px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #f5c6cb;">
                <?php echo $errors['database']; ?>
            </div>
            <?php endif; ?>

            <form id="center_Registration_Form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="owner_name">اسم المالك <span style="color: red">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" value="<?php echo isset($_POST['owner_name']) ? htmlspecialchars($_POST['owner_name']) : ''; ?>" required placeholder="أدخل الاسم الكامل للمالك" class="<?php echo isset($errors['owner_name']) ? 'error-input' : ''; ?>">
                    <?php if (isset($errors['owner_name'])): ?>
                    <span class="error-message"><?php echo $errors['owner_name']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="center_name">اسم المركز التعليمي <span style="color: red">*</span></label>
                    <input type="text" id="center_name" name="center_name" value="<?php echo isset($_POST['center_name']) ? htmlspecialchars($_POST['center_name']) : ''; ?>" required placeholder="أدخل اسم المركز التعليمي" class="<?php echo isset($errors['center_name']) ? 'error-input' : ''; ?>">
                    <?php if (isset($errors['center_name'])): ?>
                    <span class="error-message"><?php echo $errors['center_name']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="email">البريد الإلكتروني <span style="color: red">*</span></label>
                    <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required placeholder="example@domain.com" dir="ltr" class="<?php echo isset($errors['email']) ? 'error-input' : ''; ?>">
                    <?php if (isset($errors['email'])): ?>
                    <span class="error-message"><?php echo $errors['email']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="password">كلمة المرور <span style="color: red">*</span></label>
                    <input type="password" id="password" name="password" required placeholder="أدخل كلمة مرور قوية" minlength="8" class="<?php echo isset($errors['password']) ? 'error-input' : ''; ?>">
                    <?php if (isset($errors['password'])): ?>
                    <span class="error-message"><?php echo $errors['password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">تأكيد كلمة المرور <span style="color: red">*</span></label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="أعد إدخال كلمة المرور" class="<?php echo isset($errors['confirm_password']) ? 'error-input' : ''; ?>">
                    <?php if (isset($errors['confirm_password'])): ?>
                    <span class="error-message"><?php echo $errors['confirm_password']; ?></span>
                    <?php endif; ?>
                </div>
                
                <?php
            include 'center_country.php';
            ?>
                
                <div class="form-group">
                    <label for="employee_accounts">عدد حسابات المعلمين <span style="color: red">*</span></label>
                    <input type="number" id="employee_accounts" name="employee_accounts" value="<?php echo isset($_POST['employee_accounts']) ? htmlspecialchars($_POST['employee_accounts']) : ''; ?>" required min="1" placeholder="أدخل رقماً صحيحاً" class="<?php echo isset($errors['employee_accounts']) ? 'error-input' : ''; ?>">
                    <?php if (isset($errors['employee_accounts'])): ?>
                    <span class="error-message"><?php echo $errors['employee_accounts']; ?></span>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="email_type">نوع البريد الإلكتروني <span style="color: red">*</span></label>
                    <select id="email_type" name="email_type" required class="<?php echo isset($errors['email_type']) ? 'error-input' : ''; ?>">
                        <option value="" disabled <?php echo !isset($_POST['email_type']) ? 'selected' : ''; ?>>اختر نوع البريد الإلكتروني</option>
                        <option value="خاص" <?php echo (isset($_POST['email_type']) && $_POST['email_type'] == 'خاص') ? 'selected' : ''; ?>>خاص</option>
                        <option value="مخصص" <?php echo (isset($_POST['email_type']) && $_POST['email_type'] == 'مخصص') ? 'selected' : ''; ?>>مخصص</option>
                    </select>
                    <?php if (isset($errors['email_type'])): ?>
                    <span class="error-message"><?php echo $errors['email_type']; ?></span>
                    <?php endif; ?>
                </div>
                
                <button type="submit">إنشاء الحساب</button>
            </form>
        </main>

        <footer>
            <p>جميع الحقوق محفوظة &copy; عوالمنا 2024</p>
        </footer>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const locationButton = document.getElementById('getLocationBtn');
            const addressInput = document.getElementById('center_address');
            
            locationButton.addEventListener('click', function() {
                // التحقق من دعم المتصفح لخدمة تحديد الموقع
                if (navigator.geolocation) {
                    // عرض رسالة انتظار
                    addressInput.value = "جاري تحديد الموقع...";
                    
                    // الحصول على الموقع الحالي
                    navigator.geolocation.getCurrentPosition(
                        // نجاح الحصول على الموقع
                        function(position) {
                            // استخدام خدمة Geocoding لتحويل الإحداثيات إلى عنوان
                            getAddressFromCoordinates(position.coords.latitude, position.coords.longitude);
                        },
                        // فشل الحصول على الموقع
                        function(error) {
                            let errorMessage = "تعذر تحديد الموقع: ";
                            
                            switch(error.code) {
                                case error.PERMISSION_DENIED:
                                    errorMessage += "لم يتم منح الإذن لتحديد الموقع.";
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    errorMessage += "معلومات الموقع غير متاحة.";
                                    break;
                                case error.TIMEOUT:
                                    errorMessage += "انتهت مهلة طلب تحديد الموقع.";
                                    break;
                                case error.UNKNOWN_ERROR:
                                    errorMessage += "حدث خطأ غير معروف.";
                                    break;
                            }
                            
                            addressInput.value = "";
                            alert(errorMessage);
                        },
                        // خيارات تحديد الموقع
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert("متصفحك لا يدعم خدمة تحديد الموقع.");
                }
            });
            
            // دالة لتحويل الإحداثيات إلى عنوان باستخدام OpenStreetMap Nominatim API
            function getAddressFromCoordinates(latitude, longitude) {
                const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1`;
                
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            // تنسيق العنوان للعرض
                            let formattedAddress = formatAddress(data);
                            addressInput.value = formattedAddress;
                        } else {
                            addressInput.value = "تعذر الحصول على العنوان، يرجى كتابته يدوياً.";
                        }
                    })
                    .catch(error => {
                        console.error("خطأ في الحصول على العنوان:", error);
                        addressInput.value = "تعذر الحصول على العنوان، يرجى كتابته يدوياً.";
                    });
            }
            
            // دالة لتنسيق العنوان من بيانات Nominatim
            function formatAddress(data) {
                const address = data.address;
                const components = [];
                
                // ترتيب مكونات العنوان للعرض بشكل أفضل
                if (address.country) components.push(address.country);
                if (address.state || address.province) components.push(address.state || address.province);
                if (address.city || address.town || address.village) components.push(address.city || address.town || address.village);
                if (address.suburb || address.neighbourhood) components.push(address.suburb || address.neighbourhood);
                if (address.road) components.push(address.road);
                
                return components.join("، ");
            }
        });
    </script>
</body>
</html>