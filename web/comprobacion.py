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
cursor = conexion.cursor()

# Ruta de la carpeta a recorrer
carpeta = '/var/www/html/subidas'

# Lista todos los elementos en la carpeta
elementos = os.listdir (carpeta)

# Filtra la lista para quedarte solo con archivos
archivos = [elemento for elemento in elementos if os.path.isfile(os.path.join(carpeta, elemento))]

# Cuenta los archivos
numero_archivos = len(archivos)

def calcular_hash_archivo(ruta_archivo, algoritmo_hash='sha256', tamaño_fragmento=65536):
    hash_calculado = hashlib.new(algoritmo_hash)
    with open(ruta_archivo, 'rb') as archivo:
        fragmento = archivo.read(tamaño_fragmento)
        while len(fragmento) > 0:
            hash_calculado.update(fragmento)
            fragmento = archivo.read(tamaño_fragmento)
        return hash_calculado.hexdigest()


def recorrer_carpeta(carpeta):
    for archivo in os.listdir(carpeta):
        ruta_completa = os.path.join(carpeta, archivo)
        if os.path.isfile(ruta_completa):
            api_key = 'ea3b14bec451ab4f5d2915cc6b74b92c7832aca7392c635f798b734ed5bee282'
            url = 'https://www.virustotal.com/api/v3/files'

            ruta_comprobacion = '/var/www/html/subidas/'
            nombre = archivo
            archivo_a_comprobar = os.path.join(ruta_comprobacion, archivo)
            archivo_ruta = archivo_a_comprobar



            hash_resultado = calcular_hash_archivo(archivo_a_comprobar)


            headers = {
               'x-apikey': api_key,
               'accept': 'application/json',
            }


            files = {
               'file': ('', open(archivo_ruta, 'rb'), "application/x-msdownload")
            }

            response = requests.post(url, files=files, headers=headers)

            id_archivo = response.json()['data']['id']

            url_comprobacion = f"https://www.virustotal.com/api/v3/analyses/{id_archivo}"

            headers = {"accept": "application/json", "x-apikey": "ea3b14bec451ab4f5d2915cc6b74b92c7832aca7392c635f798b734ed5bee282"}

            respuesta = requests.get(url_comprobacion, headers=headers)

            malware = respuesta.json()['data']['attributes']['stats']['malicious']
            harmless = respuesta.json()['data']['attributes']['stats']['harmless']

            if malware >= 1:
                resultado = -1   # virus
                carpeta_v = 'virus'
            elif harmless >= 1:
                resultado = 1   # seguro
                carpeta_v = 'seguro'
            else:
                resultado = 0   # cuarentena
                carpeta_v = 'cuarentena'

            ruta_carpeta = os.path.join('/var/www/html/subidas', carpeta_v    )
            if not os.path.exists(ruta_carpeta):
                os.mkdir(ruta_carpeta)           
            shutil.move(archivo_ruta, ruta_carpeta)

            insertar = "INSERT INTO comprobacionn (nombre, id_archivo, resultado, hash) VALUES (%s,%s,%s,%s)"
            datos = (nombre, id_archivo, resultado, hash_resultado)
            cursor.execute(insertar, datos)
    conexion.commit()
            #recorrer_carpeta(ruta_completa)
#        elif os.path.isdir(ruta_completa):
#            recorrer_carpeta(ruta_completa)  # Llamada recursiva para recorrer subcarpetas

# Llamada inicial para recorrer la carpeta principal
carpeta_principal = '/var/www/html/subidas'
recorrer_carpeta(carpeta_principal)