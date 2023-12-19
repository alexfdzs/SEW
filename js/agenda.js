class Agenda {

    API_INTERVAL = 120000; //120000 ms = 120s = 2 min;

    constructor() {
        this.f1URL = "https://ergast.com/api/f1/current";
        this.last_api_call = null;
        this.last_api_result = null;
    }

    getF1Schedule() {

        if (this.last_api_call == null || new Date() - this.last_api_call >= this.API_INTERVAL) {
            this.last_api_call = new Date();
            var m = this;

            $.ajax({
                datatype: 'xml',
                url: m.f1URL,
                method: 'GET',
                success: function(data) {
                    m.last_api_result = data;
                    m.printAPIResult(data);
                },
                error: function () {
                    alert('Ha habido un problema de conexión con la API.')
                }
            });
        }else{
            this.printAPIResult(this.last_api_result);
        }

    }

    printAPIResult(data) {
        this.deleteSection();
        this.addHeadline();

        var races = $('Race', data);
    
        var htmlContent = '<table>';
        htmlContent += "<tr>"
        htmlContent += `<th scope="col" id= "raceName" headers="raceName"> Nombre de la carrera</th>`;
        htmlContent += `<th scope="col" id= "circuitName" headers= "circuitName"> Nombre del circuito </th>`;
        htmlContent += `<th scope="col" id= "circuitCoords" headers="circuitCoords"> Coordenadas del circuito </th>`;
        htmlContent += `<th scope="col" id= "raceDate" headers="raceDate"> Fecha de la carrera </th>`;
        htmlContent += "</tr>"
        for (var race = 0; race < races.length; race++) {
            var raceName = $('RaceName', races[race])[0].textContent;
            var circuitName = $('CircuitName', races[race])[0].textContent;
            var circuitLat = $('Location', races[race]).attr("lat");
            var circuitLong = $('Location', races[race]).attr("long");
            var raceDate = $('Date', races[race])[0].textContent; //Tambien coge los entrenamientos, sprints y qualis
            var raceTime = $('Time', races[race])[0].textContent.replace('Z', '');

            var raceNameId = $('RaceName', races[race])[0].textContent.replaceAll(' ', '-');

            htmlContent += "<tr>"
            htmlContent += `<th scope="row" id= "${raceNameId}">${raceName}</th>`;
            htmlContent += `<td headers= "circuitName ${raceNameId}">${circuitName}</td>`;
            htmlContent += `<td headers= "circuitCoords ${raceNameId}">${circuitLat}, ${circuitLong}</td>`;
            htmlContent += `<td headers= "raceDate ${raceNameId}">${raceDate} ${raceTime}</td>`;
            htmlContent += "</tr>"
        }
        htmlContent += '</table>'

        $('section').append(htmlContent);
    }

    deleteSection(){
        $('section').html("");
    }

    addHeadline(){
        $('section').append("<h3>Calendario F1</h3>");
        $('section').append('<button onclick="agenda.getF1Schedule()">Mostrar calendario</button>');
    }
}

agenda = new Agenda();