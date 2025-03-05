<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>عوالمنا - التصفح العالي</title>
    <link rel="icon" href="Website.jpg">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            direction: rtl;
        }
        header {
            background-color: #007BFF;
            padding: 15px 0;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        header img {
            vertical-align: middle;
        }
        header h1 {
            display: inline;
            margin: 0;
            color: white;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .filter-bar {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .filter-bar select, 
        .filter-bar input[type="text"], 
        .filter-bar button {
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #007BFF;
            font-size: 16px;
        }
        .filter-bar button {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out, transform 0.2s ease-in-out;
        }
        .filter-bar button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        table {
            width: 100%;
            border-collapse: collapse; /* استخدام border-collapse لتحسين مظهر الجدول */
        }
        th, td {
            text-align: right; /* محاذاة النص إلى اليمين */
            padding: 12px; /* إضافة حشوة للخلية */
            border-bottom: 1px solid #ddd; /* إضافة حدود أسفل الخلايا */
        }
        th {
            background-color: #007BFF; /* لون خلفية رأس الجدول */
            color: white; /* لون النص في رأس الجدول */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2; /* لون خلفية الصفوف الزوجية */
        }
        tr:hover {
            background-color: #e8e8e8; /* لون خلفية الصف عند التحويم */
        }
        a {
            color: #007BFF; /* لون الروابط */
            text-decoration: none; /* إزالة التسطير من الروابط */
        }
        a:hover {
            text-decoration: underline; /* إضافة التسطير عند التحويم */
        }
        .pagination {
          text-align:center; 
          margin-top:20px; 
          display:flex; 
          justify-content:center; 
          align-items:center; 
          gap:10px; /* إضافة مسافة بين الأزرار */
        }
    </style>
</head>
<body>
    <header>
        <div class="location">
            <a href="الموقع.html" style="text-decoration: none;">
                <img src="Website.jpg" alt="صورة الموقع" height="50" width="50">
                <h1>عوالمنا</h1>
            </a>
        </div>
    </header>

    <div class="container">
        <h2>جدول البيانات</h2>

        <div class="filter-bar">
            <select id="typeFilter" onchange="filterTable()">
                <option value="">اختر النوع</option>
                <option value="قصة">قصة</option>
                <option value="حساب كاتب">حساب كاتب</option>
                <option value="مركز تعليمي">مركز تعليمي</option>
            </select>
            <input type="text" id="searchInput" placeholder="ابحث هنا..." onkeyup="handleKeyUp(event)">
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>النوع</th>
                    <th>تاريخ الإنشاء</th>
                    <th>ID المسؤول</th>
                    <th>وصف</th>
                    <th>رابط</th>
                    <th>معلومات أضافية</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <!-- سيتم إضافة الصفوف هنا بواسطة JavaScript -->
            </tbody>
        </table>

        <!-- معلومات إضافية -->
        <div id="additional-info" style="display:none; margin-top:20px;">
          <h3>معلومات إضافية:</h3>
          <p id="info-content"></p>
        </div>

        <!-- أزرار التنقل بين الصفحات -->
        <div class="pagination">
          <button onclick="changePage(-1)">السابق</button>
          <span id="pageInfo"></span>
          <button onclick="changePage(1)">التالي</button>
        </div>

    </div>

    <script src="script.js"></script> <!-- تأكد من وجود ملف script.js -->
    <!-- JavaScript الداخلي هنا إذا لزم الأمر -->
</body>
</html>