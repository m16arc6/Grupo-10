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
    hash VARCHAR(100)
)
"""

cursor = conexion.cursor()
cursor.execute(create_table_query)
conexion.commit()

api_key = 'ea3b14bec451ab4f5d2915cc6b74b92c7832aca7392c635f798b734ed5bee282'
url = 'https://www.virustotal.com/api/v3/files'

ruta_comprobacion = input("Introduce la ruta al directorio: ")

archivo_ruta = ruta_comprobacion

def calcular_hash_archivo(ruta_archivo, algoritmo_hash='sha256', tamaño_fragmento=65536):
    hash_calculado = hashlib.new(algoritmo_hash)
    with open(ruta_archivo, 'rb') as archivo:
        fragmento = archivo.read(tamaño_fragmento)
        while len(fragmento) > 0:
            hash_calculado.update(fragmento)
            fragmento = archivo.read(tamaño_fragmento)
    return hash_calculado.hexdigest()

hash_resultado = calcular_hash_archivo(archivo_ruta)

print(hash_resultado)

headers = {
    'x-apikey': api_key,
    'accept': 'application/json',
}

files = {
    'file': ('', open(archivo_ruta, 'rb'), "application/x-msdownload")
}

response = requests.post(url, files=files, headers=headers)

print(response.status_code)
print(response.json()['data']['id'])
id_archivo = response.json()['data']['id']

url_comprobacion = f"https://www.virustotal.com/api/v3/analyses/{id_archivo}"

headers = {"accept": "application/json", "x-apikey": "ea3b14bec451ab4f5d2915cc6b74b92c7832aca7392c635f798b734ed5bee282"}

respuesta = requests.get(url_comprobacion, headers=headers)

malware = respuesta.json()['data']['attributes']['stats']['malicious']
harmless = respuesta.json()['data']['attributes']['stats']['harmless']

if malware >= 1:
    resultado = -1   # virus
    carpeta = 'virus'
elif harmless >= 1:
    resultado = 1   # seguro
    carpeta = 'seguro'
else:
    resultado = 0   # cuarentena
    carpeta = 'cuarentena'

ruta_carpeta = os.path.join('/home/jairo/Escritorio', carpeta)
if not os.path.exists(ruta_carpeta):
    os.mkdir(ruta_carpeta)
    print(f"carpeta {carpeta} creada")

shutil.copy(archivo_ruta, os.path.join(ruta_carpeta, os.path.basename(archivo_ruta)))
print(f"movido a carpeta {carpeta}")

print(respuesta.text)
print(os.path.basename(archivo_ruta))

insertar = "INSERT INTO comprobacionn (nombre, id_archivo, resultado, hash) VALUES (%s,%s,%s,%s)"
datos = (os.path.basename(archivo_ruta), id_archivo, resultado, hash_resultado)
cursor.execute(insertar, datos)
conexion.commit()

cursor.close()
conexion.close()
