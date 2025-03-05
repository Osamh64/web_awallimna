<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا - اعادة تعيين كلمة السر</title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <a href="الموقع.html">
                    <img src="Website.jpg" alt="صورة الموقع" height="50" width="50">
                </a>
            </div>
            <div class="header-center">
                <h1>عوالمنا</h1>
            </div>
        </div>
    </header>

    <main>
        <div class="registration-container" role="main">
            <h2>اعادة تعيين كلمة السر</h2>
            <form onsubmit="handleSubmit(event)">
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="إرسال">
                </div>
            </form>
</body>
</html>