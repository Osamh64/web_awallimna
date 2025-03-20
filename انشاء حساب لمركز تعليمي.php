<?php
// دالة توليد كلمة المرور العشوائية
function randomPassword() {
    $alphabet = array_merge(
        range('0', '9'),
        range('a', 'z'),
        range('A', 'Z'),
        str_split('!@#$%^&*()_+{}[]:;\"\'<>,.?/|\\')
    );
    $password = '';
    for ($i = 0; $i < 25; $i++) {
        $password .= $alphabet[array_rand($alphabet)];
    }
    return $password;
}

// معالجة توليد كلمة المرور عبر AJAX
if (isset($_GET['generate_password'])) {
    echo randomPassword();
    exit;
}

// اتصال قاعدة البيانات
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data_awallimna";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// معالجة إرسال النموذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // تنظيف المدخلات
    $owner_name = htmlspecialchars($_POST['owner_name'] ?? '');
    $center_name = htmlspecialchars($_POST['center_name'] ?? '');
    $email_input = $_POST['email'] ?? '';
    $selected_domain = $_POST['domain'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $center_address = htmlspecialchars($_POST['center_address'] ?? '');
    $employee_accounts = (int)($_POST['employee_accounts'] ?? 0);
    $email_type = htmlspecialchars($_POST['email_type'] ?? '');

    // التحقق من البريد الإلكتروني
    $email = '';
    if (!empty($email_input)) {
        if (strpos($email_input, '@') !== false) {
            // بريد كامل
            $email = filter_var($email_input, FILTER_VALIDATE_EMAIL) ? $email_input : '';
        } else {
            // بريد بدون نطاق
            if (!empty($selected_domain)) {
                $email = $email_input . '@' . $selected_domain;
                $email = filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : '';
            } else {
                $email = '';
            }
        }
    }

    // التحقق من البيانات
    $errors = [];
    if (empty($owner_name)) $errors[] = "اسم المالك مطلوب";
    if (empty($center_name)) $errors[] = "اسم المركز مطلوب";
    if (empty($email)) $errors[] = "البريد الإلكتروني غير صحيح";
    if (strlen($password) != 25) $errors[] = "كلمة المرور يجب أن تكون 25 حرفًا بالضبط";
    if ($password !== $confirm_password) $errors[] = "كلمات المرور غير متطابقة";
    if ($employee_accounts < 1) $errors[] = "عدد الحسابات يجب أن يكون 1 على الأقل";
    if (!in_array($email_type, ['خاص', 'مخصص'])) $errors[] = "نوع البريد غير صحيح";

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO `centers` 
            (owner_name, center_name, email, password, center_address, employee_accounts, email_type) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $owner_name, $center_name, $email, $hashed_password, $center_address, $employee_accounts, $email_type);
        
        if ($stmt->execute()) {
            echo "<div class='alert success'>تم حفظ البيانات بنجاح</div>";
        } else {
            echo "<div class='alert error'>حدث خطأ: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        foreach ($errors as $error) {
            echo "<div class='alert error'>$error</div>";
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انشاء حساب لمركز تعليمي - عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        header {
            background: #4CAF50;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        .input-group {
            display: flex;
            gap: 10px;
        }
        .input-group input {
            flex: 1;
        }
        .input-group select {
            width: 150px;
        }
        .location-picker-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
            margin-top: 10px;
        }
        #map {
            height: 300px;
            margin: 20px 0;
            border-radius: 5px;
            display: none;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background 0.3s;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">
            <a href="الموقع.php" style="text-decoration: none; color: inherit;">
                <img src="Website.jpg" alt="شعار الموقع" height="50" width="50">
                <h1>عوالمنا</h1>
            </a>
        </div>
        <h2>انشاء حساب لمركز تعليمي</h2>
    </header>
    <div class="form-container">
        <form action="" method="post">
            <div class="form-group">
                <label>اسم المالك:</label>
                <input type="text" name="owner_name" value="<?= htmlspecialchars($_POST['owner_name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>اسم المركز التعليمي:</label>
                <input type="text" name="center_name" value="<?= htmlspecialchars($_POST['center_name'] ?? '') ?>" required>
            </div>
            <div class="form-group">
                <label>البريد الإلكتروني:</label>
                <div class="input-group">
                    <input type="text" 
                           name="email" 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                           placeholder="أدخل البريد أو اسم المستخدم"
                           required
                           pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$|^[a-zA-Z0-9._%+-]+$"
                           title="أدخل بريدًا صحيحًا أو اسم مستخدم">
                    <select name="domain" required>
                        <option value="">اختر النطاق</option>
                        <option value="gmail.com" <?= ($_POST['domain'] ?? '') == 'gmail.com' ? 'selected' : '' ?>>@gmail.com</option>
                        <option value="outlook.com" <?= ($_POST['domain'] ?? '') == 'outlook.com' ? 'selected' : '' ?>>@outlook.com</option>
                        <option value="yahoo.com" <?= ($_POST['domain'] ?? '') == 'yahoo.com' ? 'selected' : '' ?>>@yahoo.com</option>
                        <option value="hotmail.com" <?= ($_POST['domain'] ?? '') == 'hotmail.com' ? 'selected' : '' ?>>@hotmail.com</option>
                    </select>
                </div>
            </div>
            <div id="password" class="form-group">
                    <label>كلمة المرور:</label>
                    <input type="password" 
                           name="password" 
                           id="passwordField"
                           required 
                           minlength="25"
                           maxlength="25"
                           placeholder="انقر لتوليد كلمة مرور"
                           pattern=".{25}"
                           title="يجب أن تكون 25 حرفًا بالضبط">
                    <div id="passwordOptions" style="display: none; margin-top: 10px;">
                        <button type="button" onclick="generateNewPassword()">توليد كلمة مرور عشوائية</button>
                    </div>
                </div>
            <div class="form-group">
                <label>تأكيد كلمة المرور:</label>
                <input type="password" 
                       name="confirm_password"
                       id="confirmPasswordField"
                       value="<?= htmlspecialchars($_POST['confirm_password'] ?? '') ?>"
                       required
                       minlength="25"
                       maxlength="25">
            </div>
            <div class="form-group">
                <label>عنوان المركز التعليمي:</label>
                <input type="text" id="center_address" name="center_address" value="<?= htmlspecialchars($_POST['center_address'] ?? '') ?>" required>
                <button type="button" class="location-picker-btn" onclick="getLocation()">حدد الموقع</button>
            </div>
            <div id="map"></div>
            <div class="form-group">
                <label>عدد حسابات المعلمين:</label>
                <input type="number" name="employee_accounts" 
                       value="<?= (int)($_POST['employee_accounts'] ?? 1) ?>" 
                       required min="1">
            </div>
            <div class="form-group">
                <label>نوع البريد الإلكتروني:</label>
                <select name="email_type" required>
                    <option value="">اختر نوع البريد</option>
                    <option value="خاص" <?= ($_POST['email_type'] ?? '') == 'خاص' ? 'selected' : '' ?>>خاص</option>
                    <option value="مخصص" <?= ($_POST['email_type'] ?? '') == 'مخصص' ? 'selected' : '' ?>>مخصص</option>
                </select>
            </div>
            <input type="submit" value="ارسال">
        </form>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
                document.getElementById('map').style.display = 'block';
            } else {
                alert("الموقع الجغرافي غير مدعوم في هذا المتصفح");
            }
        }
        function showPosition(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const map = L.map('map').setView([lat, lng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            L.marker([lat, lng]).addTo(map)
                .bindPopup('موقع المركز')
                .openPopup();
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('center_address').value = data.display_name;
                });
        }
        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("الرجاء السماح باستخدام الموقع الجغرافي");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("معلومات الموقع غير متاحة");
                    break;
                case error.TIMEOUT:
                    alert("طلب الموقع استغرق وقتاً طويلاً");
                    break;
            }
        }
        document.getElementById('passwordField').addEventListener('focus', function() {
            document.getElementById('passwordOptions').style.display = 'block';
        });
        function generateNewPassword() {
            const chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+{}[]:;<>,.?/';
            let password = '';
            for(let i = 0; i < 25; i++) {
                password += chars[Math.floor(Math.random() * chars.length)];
            }
            document.getElementById('passwordField').value = password;
            document.getElementById('confirmPasswordField').value = password;
        }
    </script>
</body>
</html>