<?php
// فعّل عرض الأخطاء
error_reporting(E_ALL);
ini_set('display_errors', 1);

// حدد مسار الملف
$storyPath = "القصص/القصص المنشوره/قصة العنقاء.pdf";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>عرض القصة</title>
    
    <!-- أكواد CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            text-align: center;
        }
        #book {
            width: 90%;
            max-width: 800px;
            height: 600px;
            margin: 0 auto;
            perspective: 2000px;
        }
        .page {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        #pageSound {
            display: none;
        }
    </style>

    <!-- مكتبات خارجية -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turn.js/4.1.0/turn.min.js"></script>
</head>
<body>
    <header>
        <h1>عنوان القصة</h1>
    </header>

    <div id="book"></div>
    <audio id="pageSound" src="page-flip.mp3"></audio>

    <!-- أكواد JavaScript -->
    <script>
        $(document).ready(function() {
            // تهيئة الكتاب
            const book = $('#book').turn({
                width: 800,
                height: 600,
                autoCenter: true,
                gradients: true,
                duration: 1000
            });

            // تحميل ملف PDF
            pdfjsLib.getDocument("<?php echo $storyPath; ?>").promise.then(pdf => {
                const totalPages = pdf.numPages;

                // تحميل كل صفحة
                for(let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
                    pdf.getPage(pageNumber).then(page => {
                        const viewport = page.getViewport({ scale: 1.5 });
                        const canvas = document.createElement('canvas');
                        canvas.height = viewport.height;
                        canvas.width = viewport.width;

                        // إضافة الصفحة للكتاب
                        $('#book').turn('addPage', canvas);

                        // رسم محتوى الصفحة
                        page.render({
                            canvasContext: canvas.getContext('2d'),
                            viewport: viewport
                        });
                    });
                }
            });

            // تشغيل الصوت عند التصفح
            $('#book').on('turning', function() {
                document.getElementById('pageSound').play();
            });
        });
    </script>
</body>
</html>