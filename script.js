const mysql = require('mysql');
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'data_awallimna',
});

connection.connect((err) => {
    if (err) {
        console.error('خطأ في الاتصال بقاعدة البيانات:', err);
        return;
    }
    console.log('تم الاتصال بقاعدة البيانات بنجاح');
});

const connection = require('./db');

// مثال على استعلام
connection.query('SELECT * FROM users', (err, results) => {
    if (err) {
        console.error('خطأ في تنفيذ الاستعلام:', err);
        return;
    }
    console.log('نتيجة الاستعلام:', results);
});

// إغلاق الاتصال بعد الانتهاء (اختياري)
connection.end((err) => {
    if (err) {
        console.error('خطأ في إغلاق الاتصال:', err);
        return;
    }
    console.log('تم إغلاق الاتصال بقاعدة البيانات');
});