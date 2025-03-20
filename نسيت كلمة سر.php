<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا</title>
    <link rel="icon" href="Website.jpg">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .container {
            text-align: center;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        header {
            position: absolute;
            top: 0;
            width: 100%;
            padding: 10px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #fff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input[type="email"], input[type="submit"] {
            padding: 10px;
            width: 100%;
            max-width: 300px;
            margin: 5px auto;
            display: block;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            display: none;
        }

        .message.active {
            display: block;
        }
    </style>
    <script>
        function handleSubmit(event) {
            event.preventDefault(); // منع الإرسال الفعلي للنموذج

            const emailInput = document.getElementById('email');
            const submitButton = document.querySelector('input[type="submit"]');
            const messageDiv = document.getElementById('message');
            const email = emailInput.value;

            // إخفاء الحقول
            emailInput.style.display = 'none';
            submitButton.style.display = 'none';

            // إظهار رسالة التأكيد وزر فتح Gmail في صفحة جديدة
            messageDiv.innerHTML = `تم إرسال البريد الإلكتروني إلى ${email}. <br><br> <button onclick="openGmail('${email}')">افتح البريد الإلكتروني</button>`;
            messageDiv.classList.add('active');
        }

        function openGmail(email) {
            // فتح صفحة Gmail مع البريد الإلكتروني
            window.open(`https://mail.google.com/mail/u/0/#inbox/${email}`, '_blank');
        }
    </script>
</head>
<body>
    <header>
        <div class="header-left">
            <a href="الموقع.php">
                <img src="Website.jpg" alt="صورة الموقع" height="50" width="50">
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
    <!--  رابط مع قاعدة البيانات الي اسمه قاعدة البيانات.sql  -->
    <header>
        <div class="location">
            <a href="الموقع.php">
                <img src="Website.jpg" alt="صورة الموقع" height="50" width="50">
                <h1>عوالمنا</h1>
            </a>
        </div>
    </header>
    <br><br><br>
        <div style="text-align: center;" class="notification-box">
        <p>تم الارسال ارجو الانتظار الرد من الاداره</p>
        <p>شكرا لكم لاستخدام موقعنا</p>
    </div>
    <footer>
        <p>&copy; 2024 عوالمنا. جميع الحقوق محفوظة.</p>
    </footer>
</body>
</html>
            </a>
        </div>
    </header>

    <div class="container">
        <h2>استعادة كلمة المرور</h2>
        <form onsubmit="handleSubmit(event)">
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <input type="submit" value="إرسال">
            </div>
        </form>
        <div id="message" class="message"></div>
    </div>

    <footer>
        جميع الحقوق محفوظة &copy; 2024
    </footer>
</body>
</html>
