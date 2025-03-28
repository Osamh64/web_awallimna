// استيراد الاتصال مع ملفات JavaScript و ملفات json
const connection = require('./db');
const connection = require('./center_country');
const connection = require('./save-story');

// مثال على استعلام
connection.query('SELECT * FROM users', (err, results) => {
    if (err) {
        console.error('خطأ في تنفيذ الاستعلام:', err);
        return;
    }
    console.log('نتيجة الاستعلام:', results);

    // إغلاق الاتصال بعد انتهاء الاستعلام (اختياري)
    connection.end((err) => {
        if (err) {
            console.error('خطأ في إغلاق الاتصال:', err);
            return;
        }
        console.log('تم إغلاق الاتصال بقاعدة البيانات');
    });
});

