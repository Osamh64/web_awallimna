const mysql = require('mysql2');

// إنشاء اتصال بقاعدة البيانات
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '', // تأكد من إضافة كلمة المرور الصحيحة
    database: 'data_awallimna', // اسم قاعدة البيانات
});

// الاتصال بقاعدة البيانات
connection.connect((err) => {
    if (err) {
        console.error('خطأ في الاتصال بقاعدة البيانات:', err);
        return;
    }
    console.log('تم الاتصال بقاعدة البيانات بنجاح');
});

// تصدير الاتصال لاستخدامه في ملفات أخرى
module.exports = connection;