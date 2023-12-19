import mysql.connector

conexion = mysql.connector.connect(
    host="localhost",
    user="jairo",
    password="1234",
)

cursor = conexion.cursor()

usuarios = "usuarios"
virustotal = "virustotal"

cursor.execute(f"CREATE DATABASE IF NOT EXISTS {usuarios}")
conexion.select_db(usuarios)

create_table_query = """
CREATE TABLE IF NOT EXISTS comprobacionn (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120),
    apellido VARCHAR(120),
    passwd VARCHAR(15),
    departamento_empresa VARCHAR(30)
)
"""

cursor.execute(create_table_query)

cursor.close()
conexion.close()
