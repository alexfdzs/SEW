import xml.etree.ElementTree as ET

def obtener_datos(ruta):
    datos= []
    distancia_acumulada = 0

    for hito in ruta.findall('.//{http://www.uniovi.es}hito'):
        nombre = hito.attrib['nombre']
        distancia = 10 + float(hito.find('.//{http://www.uniovi.es}distancia').text)*50
        altitud = 80 - float(hito.find('.//{http://www.uniovi.es}coordenadas').text)

        distancia_acumulada += distancia
        datos.append((distancia_acumulada, altitud, nombre))


    return datos

def generar_svg(archivo, datos):
    svg_content = f'<?xml version="1.0" encoding="UTF-8" ?>\n'
    svg_content += f'<svg xmlns="http://www.w3.org/2000/svg" version="2.0">\n'

    puntos = ' '.join([f'{distancia},{altitud}' for distancia, altitud, _ in datos])
    svg_content += f'<polyline points="{puntos}" style="fill:white;stroke:red;stroke-width:4" />\n'

    max_altitud = max(tupla[1] for tupla in datos)
    for distancia, altitud, nombre in datos:
        svg_content += f'<text x="{distancia}" y="{165}" style="writing-mode: tb; glyph-orientation-vertical: 0;">\n'
        svg_content += f'{nombre}\n'
        svg_content += f'</text>\n'
    
    svg_content += f'</svg>'

    with open(archivo, 'w') as f:
        f.write(svg_content)

def main():
    archivoXML = 'xml/rutasEsquema.xml'

    tree = ET.parse(archivoXML)
    root = tree.getroot()

    i= 0
    for ruta in root.findall('.//{http://www.uniovi.es}ruta'):
        i += 1
        datos = obtener_datos(ruta)
        archivo = f'xml/perfil{i}.svg'
        generar_svg(archivo, datos)
            


if __name__ == "__main__":
    main()