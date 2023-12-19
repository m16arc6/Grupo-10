import mysql.connector
 
conexion = mysql.connector.connect(
    host="localhost",
    user="jairo",
    password="1234",
)
 
cursor = conexion.cursor()
usuarios = "usuarios"
virustotal = "virustotal"
cursor.execute(f"CREATE DATABASE {virustotal}")
cursor.execute(f"CREATE DATABASE {usuarios}")

cursor.close()
conexion.close()