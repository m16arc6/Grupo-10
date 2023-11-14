import requests
import mysql.connector
import os
import shutil
 
conexion = mysql.connector.connect(
    host="localhost",
    user="jairo",
    password="1234",
    database="virustotal"
)
 
create_table_query = """
CREATE TABLE IF NOT EXISTS comprobacionn (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_archivo VARCHAR(120),
    resultado VARCHAR(2)
)
"""
 
cursor = conexion.cursor()
cursor.execute(create_table_query)
conexion.commit()
 
api_key = 'ea3b14bec451ab4f5d2915cc6b74b92c7832aca7392c635f798b734ed5bee282'
 
url = 'https://www.virustotal.com/api/v3/files'
 
#falta que recorra ficheros, de momento usamos ruta absoluta (asumimos deuda técnica (somos del barça))
archivo_ruta = input("Introduce la ruta absoluta del archivo que quieras comprobar ")
 
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
    if not os.path.exists(os.path.join(ruta, virus)):
        os.mkdir(os.path.join(ruta, virus))
        print("carpeta creada")
    shutil.copy(archivo_ruta, virus)
    print("movido a carpeta virus")
    resultado = -1   #virus
elif harmeless >= 1:
    seguro = 'seguro'
    ruta = '/home/jairo/Escritorio'
    if not os.path.exists(os.path.join(ruta, seguro)):
        os.mkdir(os.path.join(ruta, seguro))
        print("carpeta creada")
    shutil.copy(archivo_ruta, seguro)    
    print("movido a carpeta segura")
    resultado = 1   #seguro
else:
    quarentena = 'quarentena'
    ruta = '/home/jairo/Escritorio'
    if not os.path.exists(os.path.join(ruta, quarentena)):
        os.mkdir(os.path.join(ruta, quarentena))
        print("carpeta creada")
    shutil.copy(archivo_ruta, quarentena)    
    print("movido a carpeta quarentena")
    resultado = 0   #quarentena
 
print(respuesta.text)
 
insertar = "INSERT INTO comprobacionn (id_archivo, resultado) VALUES (%s,%s)"
datos = (id_archivo, resultado)
cursor.execute(insertar, datos)
conexion.commit()
 
cursor.close()
conexion.close()