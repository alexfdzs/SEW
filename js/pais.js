class Pais {
    constructor(nombre, capital, latCapital, lonCapital) {
        this.nombre = nombre;
        this.capital = capital;
        this.latCapital = latCapital;
        this.lonCapital = lonCapital;

        this.fillRest();
    }

    fillRest() {
        this.poblacion = 2640000;
        this.gobierno = "República presidencialista no democrática";
        this.religion = "Musulmana"
    }

    getName() {
        return this.nombre;
    }

    getCapital() {
        return this.capital;
    }

    getPoblacion() {
        return this.poblacion.toString();
    }

    getGobierno() {
        return this.gobierno;
    }

    getReligion() {
        return this.religion;
    }

    getSecondaryInformation() {
        var res = "<ul>\n";
        res += "\t<li>Poblacion: " + this.poblacion.toString() + "</li>\n";
        res += "\t<li>Forma de gobierno: " + this.gobierno + "</li>\n";
        res += "\t<li>Religión mayoritaria: " + this.religion + "</li>\n";
        res += "</ul>";

        return res;
    }

    writeCoordinates() {
        document.write("<p>Coordenadas de la capital: " + this.latCapital + ", " + this.lonCapital + "</p>");
    }

    getMeteo() {
        var meteoAPI = `https://api.openweathermap.org/data/2.5/forecast?lat=${this.latCapital}&lon=${this.lonCapital}&units=metric&appid=c73feae5e14be77475d6522652fd6468`;

        document.write('<section></section>');

        $.ajax({
            dataType: 'json',
            url: meteoAPI,
            method: 'GET',
            success: function (data) {
                let allMeteos = data.list;

                let fiveDays = new Array();

                fiveDays.push(allMeteos[0]);

                allMeteos.forEach(element => {
                    if(element.dt_txt.split(' ')[1] == '12:00:00'){
                        fiveDays.push(element);
                    }
                    
                });

                fiveDays.forEach(day => {
                    let htmlContent = '<meteo>';
                    htmlContent += `<h4>${day.dt_txt.split(' ')[0]}</h4>`;
                    htmlContent += `<content>`
                    htmlContent += `<data>`
                    htmlContent += `<p>Temperatura máxima: ${day.main.temp_max} ºC</p>`;
                    htmlContent += `<p>Temperatura mínima: ${day.main.temp_min} ºC</p>`;
                    htmlContent += `<p>Porcentaje de humedad: ${day.main.humidity} %</p>`;
                    htmlContent += `<p>Velocidad del viento: ${day.wind.speed} m/s</p>`;
                    htmlContent += `</data>`;
                    htmlContent += `<img src="https://openweathermap.org/img/wn/${day.weather[0].icon}@2x.png" alt=${day.weather[0].main}/>`;
                    htmlContent += `</content>`
                    htmlContent += '</meteo>';
                    
                    $("section").append(htmlContent);
                });
            }
        });
    }
}

var gambia = new Pais("Gambia", "Banjul", "13.45274", "-16.57803");
