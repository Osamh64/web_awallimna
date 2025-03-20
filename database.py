# database.py
import mysql.connector
from mysql.connector import Error

def create_connection():
    connection = None
    try:
        connection = mysql.connector.connect(
            host='localhost',
            user='root',
            password='',
            database='data_awallimna'
        )
        print("Connected to MySQL database")
    except Error as e:
        print(f"The error '{e}' occurred")
    return connection