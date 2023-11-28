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
 
#falta que recorra ficheros, de momento usamos ruta absoluta (asumimos deuda técnica (somos del barça))
archivo_ruta = input("Introduce la ruta absoluta del archivo que quieras comprobar ")
 
separar = archivo_ruta.split('/')
nombre = separar[-1]
 
def calcular_hash_archivo(ruta_archivo, algoritmo_hash='sha256', tamaño_fragmento=65536):
    hash_calculado = hashlib.new(algoritmo_hash)
    with open(ruta_archivo, 'rb') as archivo:
        fragmento = archivo.read(tamaño_fragmento)
        while len(fragmento) > 0:
            hash_calculado.update(fragmento)
            fragmento = archivo.read(tamaño_fragmento)
    return hash_calculado.hexdigest()
 
ruta_del_archivo = archivo_ruta
hash_resultado = calcular_hash_archivo(ruta_del_archivo)
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
id_archivo = (response.json()['data']['id'])
 
url_comprobacion = f"https://www.virustotal.com/api/v3/analyses/{id_archivo}"
 
headers = {"accept": "application/json", "x-apikey": "ea3b14bec451ab4f5d2915cc6b74b92c7832aca7392c635f798b734ed5bee282"}
 
respuesta = requests.get(url_comprobacion, headers=headers)
 
 
malware = respuesta.json()['data']['attributes']['stats']['malicious']
harmeless = respuesta.json()['data']['attributes']['stats']['harmless']
if malware >= 1:
    virus = 'virus'
    ruta = '/home/jairo/Escritorio'
    ruta_virus = '/home/jairo/Escritorio/virus'
    if not os.path.exists(os.path.join(ruta, virus)):
        os.mkdir(os.path.join(ruta, virus))
        print("carpeta virus creada")
    shutil.copy(archivo_ruta, os.path.join(ruta_virus, nombre))
    print("movido a carpeta virus")
    resultado = -1   #virus
elif harmeless >= 1:
    seguro = 'seguro'
    ruta = '/home/jairo/Escritorio'
    ruta_seguro = '/home/jairo/Escritorio/seguro'
    if not os.path.exists(os.path.join(ruta, seguro)):
        os.mkdir(os.path.join(ruta, seguro))
        print("carpeta creada")
    shutil.copy(archivo_ruta, os.path.join(ruta_seguro, nombre))
    print("movido a carpeta segura")
    resultado = 1   #seguro
else:
    quarentena = 'quarentena'
    ruta = '/home/jairo/Escritorio'
    ruta_quarentena = '/home/jairo/Escritorio/quarentena'
    if not os.path.exists(os.path.join(ruta, quarentena)):
        os.mkdir(os.path.join(ruta, quarentena))
        print("carpeta creada")
    shutil.copy(archivo_ruta, os.path.join(ruta_quarentena, nombre))
    print("movido a carpeta quarentena")
    resultado = 0   #quarentena
    
print(respuesta.text)
print(nombre)
 
insertar = "INSERT INTO comprobacionn (nombre, id_archivo, resultado, hash) VALUES (%s,%s,%s,%s)"
datos = (nombre, id_archivo, resultado, hash_resultado)
cursor.execute(insertar, datos)
conexion.commit()
 
cursor.close()
conexion.close()