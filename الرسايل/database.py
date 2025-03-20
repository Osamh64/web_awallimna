import mysql.connector
from mysql.connector import Error

def get_db_connection():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="your_username",  # مثلاً: root
            password="your_password",  # كلمة مرور قاعدة البيانات
            database="your_database"  # اسم قاعدة البيانات
        )
        return connection
    except Error as e:
        print(f"خطأ: {e}")
        return None

def get_user_data(email):
    connection = get_db_connection()
    if not connection:
        return None
    cursor = connection.cursor(dictionary=True)
    cursor.execute("SELECT * FROM users WHERE email = %s", (email,))
    user = cursor.fetchone()
    cursor.close()
    connection.close()
    return user