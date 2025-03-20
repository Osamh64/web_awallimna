<?php
// 1. التأكد من أن الجلسة لم تبدأ بعد قبل استدعائها
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. تضمين ملفات النظام الأساسية
include_once 'Sessionss.php'; // يفضل استخدام مسار مطلق أو const
include_once 'header.php';

// 3. التحقق من وجود مستخدم مسجل
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// 4. جلب بيانات المستخدم من قاعدة البيانات
$user_id = $_SESSION['user_id'];
$user_stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->execute([$user_id]);
$user = $user_stmt->fetch(PDO::FETCH_ASSOC);

// 5. جلب القصص مع التقييمات المتوسطة باستخدام JOIN لتحسين الأداء
$stories_stmt = $pdo->prepare("
    SELECT s.*, AVG(r.rating) AS avg_rating
    FROM stories s
    LEFT JOIN ratings r ON s.id = r.story_id
    WHERE s.author_id = ?
    GROUP BY s.id
");
$stories_stmt->execute([$user_id]);
$stories = $stories_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة <?= htmlspecialchars($user['name'] ?? 'غير معروف') ?></title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <div class="location">
        <a href="الموقع.php">
            <img src="Website.jpg" alt="شعار الموقع" height="50" width="50" loading="lazy">
            <sup>عوالمنا</sup>
        </a>
    </div>

    <div class="personal-info">
        <h1><?= htmlspecialchars($user['name'] ?? 'مستخدم جديد') ?></h1>
        
        <table class="info-table">
            <tr>
                <th>الاسم</th>
                <td><?= htmlspecialchars($user['name'] ?? '') ?></td>
            </tr>
            <tr>
                <th>تاريخ الانضمام</th>
                <td><?= date('Y-m-d', strtotime($user['created_at'] ?? '')) ?></td>
            </tr>
            <tr>
                <th>البريد الإلكتروني</th>
                <td><?= htmlspecialchars($user['email'] ?? '') ?></td>
            </tr>
        </table>

        <h2>القصص</h2>
        <table class="stories-table">
            <thead>
                <tr>
                    <th>العنوان</th>
                    <th>التقييم</th>
                    <th>تاريخ النشر</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($stories): ?>
                    <?php foreach ($stories as $story): ?>
                        <tr>
                            <td><?= htmlspecialchars($story['title']) ?></td>
                            <td>
                                <meter 
                                    min="0" max="5" 
                                    low="2" high="4" 
                                    optimum="5"
                                    value="<?= round($story['avg_rating'] ?? 0, 1) ?>"
                                >
                                    <?= round($story['avg_rating'] ?? 0, 1) ?>/5
                                </meter>
                            </td>
                            <td><?= date('Y-m-d', strtotime($story['created_at'])) ?></td>
                            <td>
                                <a href="view_story.php?id=<?= $story['id'] ?>" class="read-btn">قراءة</a>
                                <a href="edit_story.php?id=<?= $story['id'] ?>" class="edit-btn">تعديل</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">لا توجد قصص مضافة</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="actions">
        <a href="الاشتراكات.php" class="subscriptions-btn">إدارة الاشتراكات</a>
        <a href="كتابة_القصة.php" class="add-story-btn">إضافة قصة جديدة</a>
        <a href="delete_account.php" class="delete-account-btn" onclick="return confirm('هل أنت متأكد؟')">حذف الحساب</a>
    </div>
</body>
</html>