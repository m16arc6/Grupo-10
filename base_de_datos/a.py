import requests
import mysql.connector
import os
import shutil
import hashlib

conexion = mysql.connector.connect(
    host="localhost",
    user="jairo",
    password="1234",
    database="virustotal"
)

create_table_query = """
CREATE TABLE IF NOT EXISTS comprobacionn (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120),
    id_archivo VARCHAR(120),
    resultado VARCHAR(2),
    hash VARCHAR(100),
    nombre_usu VARCHAR(50)
)
"""

cursor = conexion.cursor()
cursor.execute(create_table_query)
conexion.commit()

cursor.close()
conexion.close()
