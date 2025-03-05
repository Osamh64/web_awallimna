<?php
session_start();

if (!isset($_SESSION['employee_accounts'])) {
    header("Location: index.php");
    exit();
}

$employee_accounts = $_SESSION['employee_accounts'];
$errors = [];
$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_emails = [];
    for ($i = 1; $i <= $employee_accounts; $i++) {
        $teacher_emails[] = $_POST['teacher_email_' . $i] ?? '';
    }

    // التحقق من صحة البريد الإلكتروني
    foreach ($teacher_emails as $email) {
        if (empty($email)) {
            $errors[] = 'يرجى إدخال جميع عناوين البريد الإلكتروني';
            break;
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'يرجى إدخال بريد إلكتروني صحيح';
            break;
        }
    }

    if (empty($errors)) {
        $_SESSION['teacher_emails'] = $teacher_emails;
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدخال بيانات المعلمين</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>إدخال بيانات المعلمين</h1>
        </header>

        <main class="registration-container">
            <?php if ($success): ?>
            <div class="success-message">
                تم إرسال البيانات بنجاح.
            </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <?php for ($i = 1; $i <= $employee_accounts; $i++): ?>
                <div class="form-group">
                    <label for="teacher_email_<?php echo $i; ?>">بريد المعلم <?php echo $i; ?> <span style="color: red">*</span></label>
                    <input type="email" id="teacher_email_<?php echo $i; ?>" name="teacher_email_<?php echo $i; ?>" required>
                </div>
                <?php endfor; ?>

                <button type="submit">إرسال البيانات</button>
            </form>
        </main>
    </div>
</body>
</html>