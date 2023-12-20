<?php
class Carrusel
{
    public function __construct($nombreCap, $nombrePais)
    {
        $this->nombreCap = $nombreCap;
        $this->nombrePais = $nombrePais;
    }

    function getTenPhotos()
    {

        $this->photos = array();

        $api_key = 'd8417074d61b31be0768e824329fa769';
        $tags = $this->nombreCap;
        $perpage = 10;

        $url = 'http://api.flickr.com/services/feeds/photos_public.gne?';
        $url .= '&api_key=' . $api_key;
        $url .= '&tags=' . $tags;
        $url .= '&per_page=' . $perpage;
        $url .= '&format=json';
        $url .= '&nojsoncallback=1';

        $respuesta = file_get_contents($url);
        $json = json_decode($respuesta);

        if ($json != null) {
            for ($i = 0; $i < $perpage; $i++) {
                $URLfoto = $json->items[$i]->media->m;

                $this->photos[$i] = $URLfoto;
            }
        }
    }

    function printCarrusel()
    {
        echo '<article>';
        echo '<h3>Carrusel de imágenes</h3>';
        for ($i = 0; $i < count($this->photos); $i++) {
            echo '<img src="' . $this->photos[$i] . '" alt="Imagen 1 carousel" />';
        }

        echo '<button data-action="next" ></button>';
        echo '<button data-action="prev" ></button>';

        echo '</article>';
    }
}

class Moneda
{
    public function __construct($gmd, $euro)
    {
        $this->gmd = $gmd;
        $this->euro = $euro;
    }

    function getCambioMoneda()
    {
        $url = 'https://open.er-api.com/v6/latest/' . $this->euro;

        $respuesta = file_get_contents($url);
        $json = json_decode($respuesta);

        if ($json != null) {
            $this->gmdChange = $json->rates->GMD;
        }
    }

    function printCambioMoneda()
    {
        echo '<article><h3>Cambio de moneda EURO=>GMD</h3>';
        echo '<p> 1 EUR = ' . $this->gmdChange . ' ' . $this->gmd . '</p></article>';
    }

}

$moneda = new Moneda('GMD', 'EUR');
$carrusel = new carrusel('Banjul', 'Gambia');
$carrusel->getTenPhotos();
$moneda->getCambioMoneda();
?>
<!DOCTYPE HTML>
<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Escritorio Virtual - Viajes</title>
    <meta name="author" content="Álex Fernández Salé" />
    <meta name="description" content="Página de viajes de mi escritorio virtual" />
    <meta name="keywords" content="viajes, escritorio, virtual" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="estilo/layout.css" />
    <link rel="stylesheet" type="text/css" href="estilo/viajes.css" />
    <link rel="icon" href="multimedia/imagenes/favicon.ico" />


    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script>

    <script src="js/viajes.js"></script>
</head>

<body>
    <!-- Datos con el contenidos que aparece en el navegador -->
    <header>
        <nav>
            <a accesskey="I" tabindex="1" href="index.html">Inicio</a>
            <a accesskey="S" tabindex="2" href="sobremi.html">Sobre mi</a>
            <a accesskey="N" tabindex="3" href="noticias.html">Noticias</a>
            <a accesskey="A" tabindex="4" href="agenda.html">Agenda</a>
            <a accesskey="M" tabindex="5" href="meteorologia.html">Meteorología</a>
            <a accesskey="V" tabindex="6" href="viajes.php">Viajes</a>
            <a accesskey="J" tabindex="7" href="juegos.html">Juegos</a>
        </nav>

        <h1>Escritorio Virtual</h1>
    </header>
    <h2>Viajes</h2>
    <menu data-name="viajes-menu">
        <h3>Menu</h3>
        <button data-name="static-map-button" onclick="viaje.getStaticMap()">Obtener mapa estático</button>
        <button data-name="dynamic-map-button" onclick="viaje.getDynamicMap()">Obtener mapa dinámico</button>

        <label for="xml">Seleccione un archivo XML:</label>
        <input type="file" data-name="xml-processing" id="xml" onchange="viaje.processXML(this.files)" />

        <label for="kml">Seleccione archivos KML:</label>
        <input type="file" data-name="kml-processing" id="kml" onchange="viaje.processKMLs(this.files)" multiple />

        <label for="svg">Seleccione archivos SVG:</label>
        <input type="file" data-name="svg-processing" id="svg" onchange="viaje.processSVGs(this.files)" multiple />
    </menu>

    <?php
    echo '<section>';
    $carrusel->printCarrusel();
    $moneda->printCambioMoneda();
    echo '</section>';
    ?>
    <script>viaje.addCarrouselEvents()</script>
    <main>
    </main>
    <?php

    ?>
</body>

</html>