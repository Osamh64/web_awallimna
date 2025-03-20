            <?php
            session_start();
            require 'IDs.php'; // لاستخدام دالة generateID()

            // اتصال بقاعدة البيانات
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
                $title = htmlspecialchars($_POST['title'] ?? '');
                $short_description = htmlspecialchars($_POST['short_description'] ?? '');
                $content = htmlspecialchars($_POST['content'] ?? '');
                $author_id = $_SESSION['user_id'] ?? ''; // التأكد من وجود كاتب مسجل دخوله
                $status = $_POST['status'] ?? 'غير منشورة';
                $categories = $_POST['categories'] ?? [];
                
                // التحقق من البيانات الأساسية
                $errors = [];
                if (empty($title)) $errors[] = "عنوان القصة مطلوب";
                if (empty($short_description)) $errors[] = "الوصف الموجز مطلوب";
                if (empty($content)) $errors[] = "محتوى القصة مطلوب";
                if (empty($author_id)) $errors[] = "يجب تسجيل الدخول ككاتب";
                if (!in_array($status, ['منشورة', 'غير منشورة'])) $errors[] = "حالة النشر غير صحيحة";
                if (empty($categories)) $errors[] = "اختر تصنيفًا واحدًا على الأقل";

                // التحقق من تكرار العنوان
                $stmtCheck = $conn->prepare("SELECT id FROM stories WHERE title = ?");
                $stmtCheck->bind_param("s", $title);
                $stmtCheck->execute();
                $stmtCheck->store_result();
                if ($stmtCheck->num_rows > 0) {
                    $errors[] = "عنوان القصة موجود مسبقًا";
                }
                $stmtCheck->close();

                // معالجة رفع الملف PDF
                if (!empty($_FILES['pdf_file'])) {
                    $pdfFile = $_FILES['pdf_file'];
                    $uploadDir = 'uploads/';
                    $uploadFile = $uploadDir . generateID('subscription', uniqid()) . '_' . basename($pdfFile['name']);
                    
                    // التحقق من الامتداد
                    $allowedExtensions = ['pdf'];
                    $fileExtension = strtolower(pathinfo($pdfFile['name'], PATHINFO_EXTENSION));
                    if (!in_array($fileExtension, $allowedExtensions)) {
                        $errors[] = "يجب رفع ملف PDF فقط";
                    }

                    // التحقق من حجم الملف
                    if ($pdfFile['size'] > 5 * 1024 * 1024 * 1024 * 1024) {
                        $errors[] = "حجم الملف يجب ان يكون اقل من 5GB";
                    }

                    // إنشاء مجلد التحميل إذا لم يوجد
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                } else {
                    $errors[] = "يرجى رفع ملف PDF";
                }

                // إذا لم تكن هناك أخطاء
                if (empty($errors)) {
                    // توليد ID القصة
                    $lastStoryID = $conn->query("SELECT id FROM stories ORDER BY id DESC LIMIT 1")->fetch_assoc()['id'] ?? 'S_000';
                    $number = intval(substr($lastStoryID, 2)) + 1;
                    $story_id = 'S_' . str_pad($number, 3, '0', STR_PAD_LEFT);

                    // نقل ملف PDF
                    if (!move_uploaded_file($pdfFile['tmp_name'], $uploadFile)) {
                        $errors[] = "فشل رفع الملف";
                    } else {
                        // إدراج القصة
                        $stmt = $conn->prepare("INSERT INTO stories 
                            (id, title, short_description, content, author_id, status, pdf_path) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
                        $stmt->bind_param("sssssss", $story_id, $title, $short_description, $content, $author_id, $status, $uploadFile);
                        
                        if ($stmt->execute()) {
                            // إدراج التصنيفات
                            $stmtCat = $conn->prepare("INSERT INTO story_categories (story_id, category_id) VALUES (?, ?)");
                            foreach ($categories as $category_id) {
                                $stmtCat->bind_param("si", $story_id, $category_id);
                                $stmtCat->execute();
                            }
                            $stmtCat->close();
                            
                            // تحويل إلى صفحة النجاح
                            header("Location: قصة_ناجحة.php?title=" . urlencode($title));
                            exit;
                        } else {
                            $errors[] = "حدث خطأ: " . $stmt->error;
                        }
                        $stmt->close();
                    }
                }
            }
            $conn->close();
            ?>

            <!DOCTYPE html>
            <html lang="ar" dir="rtl">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>كتابة قصة جديدة - عوالمنا</title>
                <link rel="icon" href="Website.jpg">
                <style>
                    body {
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #f5f5f5;
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
                    label {
                        display: block;
                        margin-bottom: 8px;
                        font-weight: bold;
                    }
                    input, textarea, select {
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        font-size: 16px;
                        margin-bottom: 15px;
                    }
                    .categories {
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);
                        gap: 15px;
                        margin-bottom: 20px;
                    }
                    .categories label {
                        font-weight: normal;
                        display: flex;
                        align-items: center;
                    }
                    input[type="file"] {
                        margin-top: 10px;
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
                </style>
            </head>
            <body>
                <?php if (!empty($errors)): ?>
                    <?php foreach ($errors as $error): ?>
                        <div class="alert error"><?= $error ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="form-container">
                    <h1>كتابة قصة جديدة</h1>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>عنوان القصة:</label>
                            <input type="text" name="title" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label>وصف موجز:</label>
                            <textarea name="short_description" rows="3" required><?= htmlspecialchars($_POST['short_description'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group">
                            <label>محتوى القصة:</label>
                            <textarea name="content" rows="10" required><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                        </div>
                        <div class="form-group categories">
                            <label><strong>التصنيفات:</strong></label>
                            <?php
                            // جلب التصنيفات من قاعدة البيانات
                            $stmt = $conn->prepare("SELECT id, name FROM categories");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($category = $result->fetch_assoc()):
                            ?>
                                <label>
                                    <input type="checkbox" name="categories[]" value="<?= $category['id'] ?>">
                                    <?= htmlspecialchars($category['name']) ?>
                                </label>
                            <?php endwhile; ?>
                            $stmt->close();
                        ?>
                        </div>
                        <div class="form-group">
                            <label>رفع ملف PDF:</label>
                            <input type="file" name="pdf_file" accept=".pdf" required>
                        </div>
                        <input type="submit" value="نشر القصة">
                    </form>
                </div>
            </body>
            </html>