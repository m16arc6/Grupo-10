import mysql.connector
 
conexion = mysql.connector.connect(
    host="localhost",
    user="jairo",
    password="1234",
)
 
cursor = conexion.cursor()
virustotal = "virustotal"
cursor.execute(f"CREATE DATABASE {virustotal}")
 
cursor.close()
conexion.close()