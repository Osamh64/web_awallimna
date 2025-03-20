from dotenv import load_dotenv
import os
import smtplib
from email.mime.text import MIMEText
from Messages import PASSWORD_RESET_TEMPLATE  # تأكد من وجود القالب في Messages.py
from database import get_user_data

load_dotenv()  # تحميل المتغيرات من .env

# إعدادات SMTP
SMTP_SERVER = os.getenv("SMTP_SERVER")
SMTP_PORT = int(os.getenv("SMTP_PORT"))
SENDER_EMAIL = os.getenv("SENDER_EMAIL")
SENDER_PASSWORD = os.getenv("SENDER_PASSWORD")

def send_email(template, recipient_email, **kwargs):
    try:
        # التحقق من المتغيرات المطلوبة
        required_vars = template["variables"]
        for var in required_vars:
            if var not in kwargs:
                raise ValueError(f"المتغير '{var}' غير موجود")

        # استبدال المتغيرات في النص
        formatted_body = template["body"].format(**kwargs)

        # إعداد البريد
        msg = MIMEText(formatted_body)
        msg['Subject'] = template["subject"]
        msg['From'] = SENDER_EMAIL
        msg['To'] = recipient_email

        # إرسال البريد
        with smtplib.SMTP(SMTP_SERVER, SMTP_PORT) as server:
            server.starttls()
            server.login(SENDER_EMAIL, SENDER_PASSWORD)
            server.sendmail(SENDER_EMAIL, recipient_email, msg.as_string())
        
        print("تم الإرسال بنجاح!")
    except Exception as e:
        print(f"خطأ: {e}")

# مثال استخدام
if __name__ == "__main__":
    user_email = "user@example.com"
    user_data = get_user_data(user_email)
    
    if user_data:
        send_email(
            template=PASSWORD_RESET_TEMPLATE,
            recipient_email=user_data["email"],
            اسم_المستخدم=user_data.get("username", ""),
            رمز_التحقق=user_data.get("verification_code", ""),
            البريد_الإلكتروني=user_data.get("email", ""),
            رابط_الموقع="https://awallimna.com",
            اتصل_بنا="support@awallimna.com"
        )
    else:
        print("المستخدم غير موجود!")