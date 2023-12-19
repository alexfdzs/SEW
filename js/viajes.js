class Viaje {

    constructor() {
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this), this.verErrores.bind(this));
    }

    getPosicion(posicion) {
        this.longitud = posicion.coords.longitude;
        this.latitud = posicion.coords.latitude;
        this.precision = posicion.coords.accuracy;
        this.altitud = posicion.coords.altitude;
        this.precisionAltitud = posicion.coords.altitudeAccuracy;
        this.rumbo = posicion.coords.heading;
        this.velocidad = posicion.coords.speed;
    }

    verErrores(error) {
        switch (error.code) {
            case error.PERMISSION_DENIED:
                alert("El usuario no permite la petición de geolocalización");
                break;
            case error.POSITION_UNAVAILABLE:
                alert("Información de geolocalización no disponible");
                break;
            case error.TIMEOUT:
                alert("La petición de geolocalización ha caducado");
                break;
            case error.UNKNOWN_ERROR:
                alert("Se ha producido un error desconocido");
                break;
        }
    }

    getStaticMap() {
        $('main').html("");

        var apikey = "sk.eyJ1IjoidW8yNzkzNzUiLCJhIjoiY2xxOW1xd3J0MW43OTJqbnU0azlpcTh1MSJ9.jqeUFhUwdt5uP_llHRDBlg";

        var tamaño = "800x600";
        var zoom = 14;

        this.mapImg = `https://api.mapbox.com/styles/v1/mapbox/streets-v12/static/pin-l(${this.longitud},${this.latitud})/${this.longitud},${this.latitud},${zoom}/${tamaño}?access_token=${apikey}`;

        $('main').html(`<img src="${this.mapImg}" alt= "Mapa estático de MapBox"/>`);
    }

    getDynamicMap() {
        $('main').html("");

        mapboxgl.accessToken = 'pk.eyJ1IjoidW8yNzkzNzUiLCJhIjoiY2xxOW1uODduMW41eTJqbnV6d2dvcHp5OCJ9.k6P7Cot96BUWDxEusrLwqQ';
        var map = new mapboxgl.Map({
            container: document.querySelector('main'),
            center: [this.longitud, this.latitud],
            zoom: 9
        });

        var marker = new mapboxgl.Marker({ color: 'red' })
            .setLngLat([this.longitud, this.latitud])
            .addTo(map);
    }

    processXML(files) {
        $('main').html("");
        var file = files[0];

        if (file.type.match(/text.*/)) {
            var lector = new FileReader();
            lector.onload = function (evento) {

                let parser = new DOMParser();

                let xmlDoc = parser.parseFromString(lector.result, "text/xml");

                let rutas = xmlDoc.getElementsByTagName('ruta');

                let htmlContent = "";
                for (let ruta of rutas) {
                    htmlContent += '<article>';
                    htmlContent += '<h4>' + ruta.getAttribute("nombre") + '</h4>';
                    let tipo = ruta.getElementsByTagName('tipo')[0];
                    htmlContent += `<p>Tipo: ${tipo.textContent}</p>`;
                    let medio_transporte = ruta.getElementsByTagName('medio_transporte')[0];
                    htmlContent += `<p>Medio de transporte: ${medio_transporte.textContent}</p>`;
                    let date = ruta.getElementsByTagName('duracion')[0];
                    htmlContent += `<p>Duracion:  ${date.textContent}</p>`;
                    let agencia = ruta.getElementsByTagName('agencia')[0];
                    htmlContent += `<p>Agencia:  ${agencia.textContent}</p>`;
                    let descripcion = ruta.getElementsByTagName('descripcion')[0];
                    htmlContent += `<p>Descripción:  ${descripcion.textContent}</p>`;
                    let personas_adecuadas = ruta.getElementsByTagName('personas_adecuadas')[0];
                    htmlContent += `<p>Personas adecuadas:  ${personas_adecuadas.textContent}</p>`;
                    let inicio_ruta = ruta.getElementsByTagName('inicio_ruta')[0];
                    htmlContent += `<p>Incicio ruta:</p>`;
                    htmlContent += `<ul>`
                    htmlContent += `<li>Lugar: ${inicio_ruta.getAttribute("lugar")}</li>`;
                    htmlContent += `<li>Dirección: ${inicio_ruta.getAttribute("direccion")}</li>`;
                    let inicio_coords = inicio_ruta.getElementsByTagName('coordenadas')[0];
                    htmlContent += `<li>Coordenadas: [Lat: ${inicio_coords.getAttribute("latitud")}, Long: ${inicio_coords.getAttribute("longitud")}, Altitud: ${inicio_coords.textContent} ${inicio_coords.getAttribute("alt_measure")}</li>`;
                    htmlContent += `</ul>`
                    htmlContent += '<p>Referencias: </p>';
                    htmlContent += '<ul>'
                    let referencias = ruta.getElementsByTagName('referencia')
                    for (let ref of referencias) {
                        htmlContent += `<li>${ref.textContent}</li>`;
                    }
                    htmlContent += '</ul>';
                    let recomendacion = ruta.getElementsByTagName('recomendacion')[0];
                    htmlContent += `<p>Recomendiación: ${recomendacion.textContent}</p>`;
                    let hitos = ruta.getElementsByTagName('hito');
                    htmlContent += `<p>Hitos de la ruta: </p>`;
                    htmlContent += '<ol>'
                    for (let hito of hitos) {
                        htmlContent += `<li> ${hito.getAttribute("nombre")}`;
                        htmlContent += '<ul>'
                        htmlContent += `<li>Descripción: ${hito.getElementsByTagName('descripcion')[0].textContent}</li>`
                        let hito_coords = hito.getElementsByTagName('coordenadas')[0];
                        htmlContent += `<li>Coordenadas: [Lat: ${hito_coords.getAttribute("latitud")}, Long: ${hito_coords.getAttribute("longitud")}, Altitud: ${hito_coords.textContent} ${hito_coords.getAttribute("alt_measure")}</li>`;
                        htmlContent += '<li>Galería fotográfica:'
                        htmlContent += '<ul>'
                        let galeria = hito.getElementsByTagName('foto');
                        for (let foto of galeria) {
                            htmlContent += `<li><picture>`
                            htmlContent += `<source media="(max-width:799px)" srcset="${foto.textContent.replace('.png', '_tablet.png')}" />`
                            htmlContent += `<source media="(max-width:495px)" srcset="${foto.textContent.replace('.png', '_movil.png')}" />`
                            htmlContent += `<img src=${foto.textContent} alt="${ruta.getAttribute("nombre")}"/>`
                            htmlContent += `</picture></li>`
                        }
                        htmlContent += '</ul></li>'
                        htmlContent += '</ul></li>'
                    }
                    htmlContent += '</ol>'
                    htmlContent += '</article>';
                }

                $('main').html(htmlContent);
            }
            lector.readAsText(file);
        }

    }

    processKMLs(files) {
        $('main').html("");

        mapboxgl.accessToken = 'pk.eyJ1IjoidW8yNzkzNzUiLCJhIjoiY2xxOW1uODduMW41eTJqbnV6d2dvcHp5OCJ9.k6P7Cot96BUWDxEusrLwqQ';
        var map = new mapboxgl.Map({
            container: document.querySelector('main'),
            center: [this.longitud, this.latitud],
            zoom: 9
        });

        this.processKMLsRec(files, 0, map);
    }

    processKMLsRec(files, idx, map) {
        if (idx >= files.length) {
            return;
        }

        var file = files[idx];
        var lector = new FileReader();

        lector.onload = function (event) {
            console.log(lector.result);

            let coordsToMap = new Array();

            let parser = new DOMParser();

            let xmlDoc = parser.parseFromString(lector.result, "text/xml");

            let coordsXML = xmlDoc.getElementsByTagName('coordinates')[0];

            let coords = coordsXML.textContent.split('\n');

            for (let idx = 1; idx < coords.length - 1; idx++) {
                let coordPairs = coords[idx].split(',');
                let lng = parseFloat(coordPairs[0]);
                let lat = parseFloat(coordPairs[1]);
                coordsToMap.push([lng, lat]);
            }

            map.on('load', () => {
                var random = Math.random(10);
                map.addSource(`route${random}`, {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'properties': {},
                        'geometry': {
                            'type': 'LineString',
                            'coordinates': coordsToMap
                        }
                    }
                });
                map.addLayer({
                    'id': `route${random}`,
                    'type': 'line',
                    'source': `route${random}`,
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': 'red',
                        'line-width': 4
                    }
                });
            });

            this.processKMLsRec(files, idx + 1, map);
        }.bind(this);
        lector.readAsText(file);
    }

    processSVGs(input) {
        $('main').html("");

        this.processSVGsRec(input, 0);
    }

    processSVGsRec(files, idx) {
        if (idx >= files.length) {
            return;
        }
        var file = files[idx];
        var lector = new FileReader();

        lector.onload = function (event) {
            $('main').append($(lector.result));

            this.processSVGsRec(files, idx + 1);
        }.bind(this);
        lector.readAsText(file);
    }

    addCarrouselEvents() {
        const slides = document.querySelectorAll("img");

        // select next slide button
        const nextSlide = document.querySelector("button[data-action='next']");

        // current slide counter
        let curSlide = 3;
        // maximum number of slides
        let maxSlide = slides.length - 1;

        // add event listener and navigation functionality
        nextSlide.addEventListener("click", function () {
            // check if current slide is the last and reset current slide
            if (curSlide === maxSlide) {
                curSlide = 0;
            } else {
                curSlide++;
            }

            //   move slide by -100%
            slides.forEach((slide, indx) => {
                var trans = 100 * (indx - curSlide);
                $(slide).css('transform', 'translateX(' + trans + '%)')
            });
        });

        // select next slide button
        const prevSlide = document.querySelector("button[data-action='prev']");

        // add event listener and navigation functionality
        prevSlide.addEventListener("click", function () {
            // check if current slide is the first and reset current slide to last
            if (curSlide === 0) {
                curSlide = maxSlide;
            } else {
                curSlide--;
            }

            //   move slide by 100%
            slides.forEach((slide, indx) => {
                var trans = 100 * (indx - curSlide);
                $(slide).css('transform', 'translateX(' + trans + '%)')
            });
        });
    }
}


viaje = new Viaje();
