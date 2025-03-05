// وظيفة حفظ القصة للقراءة لاحقاً
function saveForLater(storyId) {
    // التحقق من تسجيل دخول المستخدم
    if (!isUserLoggedIn()) {
        window.location.href = 'تسجيل دخول.php';
        return;
    }

    // إرسال طلب حفظ القصة
    fetch('save-story.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            story_id: storyId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSaveConfirmation();
            updateSaveButton(storyId);
        } else {
            alert('حدث خطأ أثناء حفظ القصة. الرجاء المحاولة مرة أخرى.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء حفظ القصة. الرجاء المحاولة مرة أخرى.');
    });
}

// عرض رسالة تأكيد الحفظ
function showSaveConfirmation() {
    const confirmation = document.createElement('div');
    confirmation.className = 'save-confirmation';
    confirmation.textContent = 'تم حفظ القصة للقراءة لاحقاً';
    document.body.appendChild(confirmation);

    // إظهار الرسالة
    setTimeout(() => {
        confirmation.classList.add('show');
    }, 100);

    // إخفاء الرسالة بعد 3 ثواني
    setTimeout(() => {
        confirmation.classList.remove('show');
        setTimeout(() => {
            confirmation.remove();
        }, 300);
    }, 3000);
}

// تحديث شكل الزر بعد الحفظ
function updateSaveButton(storyId) {
    const button = document.querySelector(`[data-story-id="${storyId}"]`);
    if (button) {
        button.innerHTML = '<i class="fas fa-bookmark"></i> تم الحفظ';
        button.style.backgroundColor = '#4CAF50';
        button.disabled = true;
    }
}

// التحقق من تسجيل دخول المستخدم
function isUserLoggedIn() {
    // يمكنك تعديل هذه الوظيفة حسب نظام تسجيل الدخول لديك
    return document.cookie.includes('user_logged_in=true');
}
