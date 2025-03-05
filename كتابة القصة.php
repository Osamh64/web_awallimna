<?php
$add_story = fopen('$title', 'a');
$name_author = ('$author_id');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا - كتابة قصة جديدة</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        form { display: flex; flex-direction: column; }
        label, input, textarea, select { margin-bottom: 10px; }
        input[type="submit"] { cursor: pointer; }
    </style>
</head>
<body>
    <!-- ياخذ اسم كاتب القصة مع id حقه -->
    <h1>إرسال قصة جديدة</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="title">عنوان القصة:</label>
        <input type="text" id="title" name="title" required>

        <label for="short_description">وصف موجز للقصة:</label>
        <textarea id="short_description" name="short_description" rows="3" required></textarea>

        <label for="content">نص القصة:</label>
        <textarea id="content" name="content" rows="10" required></textarea>

        <label for="category">اختر تصنيف القصة:</label>
        <select id="category" name="category" required>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="إرسال القصة">
    </form>
</body>
</html>