import xml.etree.cElementTree as ET

def prologoKML(archivo, nombre):
    """ Escribe en el archivo de salida el prólogo del archivo KML"""

    archivo.write('<?xml version="1.0" encoding="UTF-8"?>\n')
    archivo.write('<kml xmlns="http://www.opengis.net/kml/2.2">\n')
    archivo.write("<Document>\n")
    archivo.write("<Placemark>\n")
    archivo.write("<name>"+nombre+"</name>\n")    
    archivo.write("<LineString>\n")
    #la etiqueta <extrude> extiende la línea hasta el suelo 
    archivo.write("<extrude>1</extrude>\n")
    # La etiqueta <tessellate> descompone la línea en porciones pequeñas
    archivo.write("<tessellate>1</tessellate>\n")
    archivo.write("<coordinates>\n")

def epilogoKML(archivo):
    """ Escribe en el archivo de salida el epílogo del archivo KML"""

    archivo.write("</coordinates>\n")
    archivo.write("<altitudeMode>relativeToGround</altitudeMode>\n")
    archivo.write("</LineString>\n")
    archivo.write("<Style id='lineaRoja'>\n") 
    archivo.write("<LineStyle>\n") 
    archivo.write("<color>#ff0000ff</color>\n")
    archivo.write("<width>5</width>\n")
    archivo.write("</LineStyle>\n")
    archivo.write("</Style>\n")
    archivo.write("</Placemark>\n")
    archivo.write("</Document>\n")
    archivo.write("</kml>\n")

def decodificaCoordenadas(ruta):
    coordenadas_hitos = []
    for hito in ruta.findall('.//{http://www.uniovi.es}hito'):
        latitud = hito.find('.//{http://www.uniovi.es}coordenadas').attrib['latitud']
        longitud = hito.find('.//{http://www.uniovi.es}coordenadas').attrib['longitud']
        coordenadas_hitos.append((float(longitud), float(latitud)))
    return coordenadas_hitos
  

    

def main():
    archivoXML = 'xml/rutasEsquema.xml'

    try:
        tree = ET.parse(archivoXML)

    except IOError:
        print ('No se encuentra el archivo ', archivoXML)
        exit()
        
    except ET.ParseError:
        print("Error procesando en el archivo XML = ", archivoXML)
        exit()

    root = tree.getroot()

    rutas = root.findall('.//{http://www.uniovi.es}ruta')

    i = 0
    for ruta in rutas:
        i += 1
        coordenadas_hitos = decodificaCoordenadas(ruta)

        nombre = f'xml/ruta{i}.kml'

        with open(nombre, 'w') as archivo:
            prologoKML(archivo, archivoXML)
            for coordenada in coordenadas_hitos:
                archivo.write(f"{coordenada[0]},{coordenada[1]},0\n")
            
            epilogoKML(archivo)
    
    
if __name__ == "__main__":
    main()