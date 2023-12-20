<?php
class FlagFootball
{
    public function __construct()
    {
        $this->server = "localhost";
        $this->user = "DBUSER2023";
        $this->pass = "DBPSWD2023";
        $this->dbname = "flagfootball";
    }

    function rebootDB()
    {

        $mysqli = new mysqli($this->server, $this->user, $this->pass);

        $sql_file = 'setup.sql';

        $sql = file_get_contents($sql_file);

        $mysqli->multi_query($sql) or die('IMPORTACION FALLIDA');
        $mysqli->select_db = "flagfootball";

        $mysqli->close();
    }

    function getDB()
    {
        $this->getLigas();
        $this->getEquipos();
        $this->getPartidos();
        $this->getJugadores();
        $this->getStats();
    }

    function getLigas()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT Nombre, Localidad from `liga`;';
        $stmnt = $mysqli->prepare($sql);
        $stmnt->execute();
        $result = $stmnt->get_result();

        $this->strligas = '';

        if ($result->num_rows > 0) {
            $this->strligas .= '<h3>Ligas</h3>';
            $this->strligas .= '<table>';
            $this->strligas .= '<tr><th scope="col" id= "name" headers="name"> Nombre de la liga</th>';
            $this->strligas .= '<th scope="col" id= "localidad" headers="localidad"> Localidad de la liga</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $name = $row['Nombre'];
                $localidad = $row['Localidad'];

                $this->strligas .= '<tr><th scope="row" id="' . $name . '">' . $name . '</th>';
                $this->strligas .= '<td headers="localidad ' . $name . '">' . $localidad . '</td></tr>';
            }
            $this->strligas .= '</table>';
        }

        $mysqli->close();

    }

    function getEquipos()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT L.nombre as liga, E.nombre, E.ciudad
                    FROM Equipo E
                    JOIN Liga L ON L.id_Liga = E.id_Liga';

        $stmnt = $mysqli->prepare($sql);
        $stmnt->execute();
        $result = $stmnt->get_result();

        $this->strEquipos = '';

        if ($result->num_rows > 0) {
            $this->strEquipos .= '<h3>Equipos</h3>';
            $this->strEquipos .= '<table>';
            $this->strEquipos .= '<tr><th scope="col" id= "name" headers="name"> Nombre</th>';
            $this->strEquipos .= '<th scope="col" id= "ciudad" headers="ciudad"> Ciudad</th>';
            $this->strEquipos .= '<th scope="col" id= "liga" headers="liga"> Liga</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $name = $row['nombre'];
                $ciudad = $row['ciudad'];
                $liga = $row['liga'];

                $this->strEquipos .= '<tr><th scope="row" id="' . $name . '">' . $name . '</th>';
                $this->strEquipos .= '<td headers="ciudad ' . $name . '">' . $ciudad . '</td>';
                $this->strEquipos .= '<td headers="liga ' . $name . '">' . $liga . '</td></tr>';
            }
            $this->strEquipos .= '</table>';
        }

        $mysqli->close();
    }

    function getPartidos()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT ELocal.nombre AS equipo_local, EVisitante.nombre AS equipo_visitante, P.resultado
                    FROM Partido P
                    JOIN Equipo ELocal ON P.id_equipo_local = ELocal.id_equipo
                    JOIN Equipo EVisitante ON P.id_equipo_visitante = EVisitante.id_equipo';

        $stmnt = $mysqli->prepare($sql);
        $stmnt->execute();
        $result = $stmnt->get_result();

        $this->strPartidos = '';

        if ($result->num_rows > 0) {
            $this->strPartidos .= '<h3>Partidos</h3>';
            $this->strPartidos .= '<table>';
            $this->strPartidos .= '<tr><th scope="col" id= "local" headers="local">Equipo local</th>';
            $this->strPartidos .= '<th scope="col" id= "visitante" headers="visitante">Equipo visitante</th>';
            $this->strPartidos .= '<th scope="col" id= "resultado" headers="resultado">Resultado</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $local = $row['equipo_local'];
                $visitante = $row['equipo_visitante'];
                $resultado = $row['resultado'];

                $this->strPartidos .= '<tr><th scope="row" id="' . $local . '">' . $local . '</th>';
                $this->strPartidos .= '<td headers="visitante ' . $local . '">' . $visitante . '</td>';
                $this->strPartidos .= '<td headers="resultado ' . $local . '">' . $resultado . '</td></tr>';
            }
            $this->strPartidos .= '</table>';
        }

        $mysqli->close();
    }

    function getJugadores()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT nombre, apellido, numero from `jugador`';
        $sql = 'SELECT E.nombre AS equipo, J.nombre, J.apellido, J.numero
                    FROM Jugador J
                    JOIN Equipo E ON E.id_equipo = J.id_equipo';


        $stmnt = $mysqli->prepare($sql);
        $stmnt->execute();
        $result = $stmnt->get_result();

        $this->strJugadores = '';

        if ($result->num_rows > 0) {
            $this->strJugadores .= '<h3>Jugadores</h3>';
            $this->strJugadores .= '<table>';
            $this->strJugadores .= '<tr><th scope="col" id= "nombre" headers="nombre">Nombre</th>';
            $this->strJugadores .= '<th scope="col" id= "apellido" headers="apellido">Apellido</th>';
            $this->strJugadores .= '<th scope="col" id= "numero" headers="numero">Numero</th>';
            $this->strJugadores .= '<th scope="col" id= "equipo" headers="equipo">Equipo</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $nombre = $row['nombre'];
                $apellido = $row['apellido'];
                $numero = $row['numero'];
                $equipo = $row['equipo'];

                $this->strJugadores .= '<tr><th scope="row" id="' . $nombre . '">' . $nombre . '</th>';
                $this->strJugadores .= '<td headers="visitante ' . $nombre . '">' . $apellido . '</td>';
                $this->strJugadores .= '<td headers="resultado ' . $nombre . '">' . $numero . '</td>';
                $this->strJugadores .= '<td headers="equipo ' . $nombre . '">' . $equipo . '</td></tr>';
            }
            $this->strJugadores .= '</table>';
        }

        $mysqli->close();
    }

    function getStats()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT J.nombre AS nombre, Eq.nombre AS equipo, E.Touchdowns, E.ExtraPoints, E.partidos_Jugados, E.Puntos_Marcados
                    FROM Estadisticas E
                    JOIN Jugador J ON E.id_jugador = J.id_jugador
                    JOIN Equipo Eq on Eq.id_equipo = J.id_equipo
                    ORDER BY E.Puntos_Marcados DESC';

        $stmnt = $mysqli->prepare($sql);
        $stmnt->execute();
        $result = $stmnt->get_result();

        $this->strStats = '';

        if ($result->num_rows > 0) {
            $this->strStats .= '<h3>Estadísticas</h3>';
            $this->strStats .= '<table>';
            $this->strStats .= '<tr><th scope="col" id= "nombre" headers="nombre">Nombre</th>';
            $this->strStats .= '<th scope="col" id= "equipo" headers="equipo">Equipo</th>';
            $this->strStats .= '<th scope="col" id= "tds" headers="tds">TouchDowns</th>';
            $this->strStats .= '<th scope="col" id= "ep" headers="ep">ExtraPoints</th>';
            $this->strStats .= '<th scope="col" id= "pj" headers="pj">Partidos jugados</th>';
            $this->strStats .= '<th scope="col" id= "pm" headers="pm">Puntos marcados</th></tr>';

            while ($row = $result->fetch_assoc()) {
                $nombre = $row['nombre'];
                $equipo = $row['equipo'];
                $tds = $row['Touchdowns'];
                $ep = $row['ExtraPoints'];
                $pj = $row['partidos_Jugados'];
                $pm = $row['Puntos_Marcados'];

                $this->strStats .= '<tr><th scope="row" id="' . $nombre . '">' . $nombre . '</th>';
                $this->strStats .= '<td headers="equipo ' . $nombre . '">' . $equipo . '</td>';
                $this->strStats .= '<td headers="tds ' . $nombre . '">' . $tds . '</td>';
                $this->strStats .= '<td headers="ep ' . $nombre . '">' . $ep . '</td>';
                $this->strStats .= '<td headers="pj ' . $nombre . '">' . $pj . '</td>';
                $this->strStats .= '<td headers="pm ' . $nombre . '">' . $pm . '</td></tr>';
            }
            $this->strStats .= '</table>';
        }

        $mysqli->close();
    }

    function printLigas()
    {
        echo $this->strligas;
    }

    function printEquipos()
    {
        echo $this->strEquipos;
    }

    function printPartidos()
    {
        echo $this->strPartidos;
    }

    function printJugadores()
    {
        echo $this->strJugadores;
    }

    function printStats()
    {
        echo $this->strStats;
    }

    function export($table_name)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $outfile = 'ff_' . $table_name . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $outfile . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $file = fopen('php://output', 'w');

        $sql = 'select * from ' . $table_name;

        $res = $mysqli->query($sql);

        while ($row = $res->fetch_assoc()) {
            fputcsv($file, $row);
        }

        $mysqli->close();

        fclose($file);

        exit();
    }

    function importLiga($nombre, $localidad)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'select count(*) from liga where nombre = ? and localidad = ?';
        $smnt = $mysqli->prepare($sql);
        $smnt->bind_param('ss', $nombre, $localidad);

        $smnt->execute();
        $result = $smnt->get_result();

        if ($result->num_rows == 0) {
            $this->addLigas($nombre, $localidad);
        }
    }

    function importEquipo($nombre, $ciudad, $nombreLiga)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sqlLiga = 'select id_liga from liga where nombre = ?';
        $smntLiga = $mysqli->prepare($sqlLiga);
        $smntLiga->bind_param('s', $nombreLiga);
        $smntLiga->execute();
        $resultLiga = $smntLiga->get_result();

        $sqlEquipo = 'select count(*) from equipo where nombre = ?';
        $smntEquipo = $mysqli->prepare($sqlEquipo);
        $smntEquipo->bind_param('s', $nombre);
        $smntEquipo->execute();
        $resultEquipo = $smntEquipo->get_result();

        if ($resultLiga->num_rows > 0 && $resultEquipo->num_rows == 0) {
            $row = $resultLiga->fetch_assoc();

            $this->addEquipos($nombre, $ciudad, $row['id_liga']);
        }
        $mysqli->close();
    }

    function importPartido($local, $visitante, $resultado)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sqlLocal = 'select id_equipo from equipo where nombre = ?';
        $smntLocal = $mysqli->prepare($sqlLocal);
        $smntLocal->bind_param('s', $local);
        $smntLocal->execute();
        $resultLocal = $smntLocal->get_result();

        $sqlVisitante = 'select id_equipo from equipo where nombre = ?';
        $sqlVisitante = $mysqli->prepare($sqlLocal);
        $sqlVisitante->bind_param('s', $visitante);
        $sqlVisitante->execute();
        $resultVisitante = $sqlVisitante->get_result();

        if ($resultLocal->num_rows > 0 && $resultVisitante->num_rows > 0) {
            $rowLocal = $resultLocal->fetch_assoc();
            $rowVisitante = $resultVisitante->fetch_assoc();

            $sql = 'select count(*) from partido where id_equipo_local = ? and id_equipo_visitante = ? and resultado = ?';
            $smnt = $mysqli->prepare($sql);
            $smnt->bind_param('dds', $rowLocal['id_equipo'], $rowVisitante['id_equipo'], $resultado);
            $smnt->execute();
            $res = $smnt->get_result();

            if ($res->num_rows == 0) {
                $this->addPartidos($rowLocal['id_equipo'], $rowVisitante['id_equipo'], $resultado);
            }
        }

        $mysqli->close();
    }

    function importJugador($nombre, $apellido, $numero, $nombre_equipo)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sqlEq = 'select id_equipo from equipo where nombre = ?';
        $smntEq = $mysqli->prepare($sqlEq);
        $smntEq->bind_param('s', $nombre_equipo);
        $smntEq->execute();
        $resultEq = $smntEq->get_result();

        if ($resultEq->num_rows > 0) {
            $rowEq = $resultEq->fetch_assoc();

            $sql = 'select count(*) from jugador where nombre = ? and apellido = ? and numero = ? and id_equipo = ?';
            $smnt = $mysqli->prepare($sql);
            $smnt->bind_param('ssdd', $nombre, $apellido, $numero, $row['id_equipo']);
            $smnt->execute();
            $result = $smnt->get_result();

            if ($result->num_rows == 0) {
                $this->addJugadores($nombre, $apellido, $numero, $row['id_equipo']);
            }
        }

        $mysqli->close();
    }

    function importStats($tds, $eps, $pjs, $nombreJ, $apellidoJ)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sqlJ = 'select id_jugador from jugador where nombre = ? and apellido = ?';
        $smntJ = $mysqli->prepare($sqlJ);
        $smntJ->bind_param('ss', $nombreJ, $apellidoJ);
        $smntJ->execute();
        $resultJ = $smntJ->get_result();

        if ($resultJ->num_rows > 0) {
            $row = $resultJ->fetch_assoc();

            $sql = 'select count(*) from estadisticas where id_jugador = ?';
            $smnt = $mysqli->prepare($sql);
            $smnt->bind_param('d', $row['id_jugador']);
            $smnt->execute();
            $result = $smnt->get_result();

            if ($result->num_rows == 0) {
                $this->addStats($tds, $eps, $pjs, $row['id_jugador']);
            }
        }
        $mysqli->close();
    }

    function addLigas($nombre, $localidad)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'insert into liga(nombre, localidad) values (?, ?);';

        $stmnt = $mysqli->prepare($sql);

        $stmnt->bind_param('ss', $nombre, $localidad);

        $stmnt->execute();

        $this->getLigas();

        $mysqli->close();
    }

    function addEquipos($nombre, $ciudad, $id_liga)
    {

        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'insert into equipo(nombre, ciudad, id_liga) values (?, ?, ?);';

        $stmnt = $mysqli->prepare($sql);

        $stmnt->bind_param('ssd', $nombre, $ciudad, $id_liga);

        $stmnt->execute();

        $this->getEquipos();

        $mysqli->close();
    }

    function addPartidos($id_local, $id_visitante, $resultado)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'insert into partido(id_equipo_local, id_equipo_visitante, resultado) values (?, ?, ?);';

        $stmnt = $mysqli->prepare($sql);

        $stmnt->bind_param('dds', $id_local, $id_visitante, $resultado);

        $stmnt->execute();

        $this->getPartidos();

        $mysqli->close();
    }

    function addJugadores($nombre, $apellido, $numero, $id_equipo)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'insert into jugador(nombre, apellido, numero, id_equipo) values (?, ?, ?, ?);';

        $stmnt = $mysqli->prepare($sql);

        $stmnt->bind_param('ssdd', $nombre, $apellido, $numero, $id_equipo);

        $stmnt->execute();

        $this->getJugadores();

        $mysqli->close();
    }

    function addStats($tds, $eps, $pj, $id_jugador)
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $pm = $tds * 6 + $eps;

        $sql = 'insert into estadisticas(`Touchdowns`, `ExtraPoints`, `partidos_Jugados`, `Puntos_Marcados`, `ID_Jugador`) values (?, ?, ?, ?, ?);';

        $stmnt = $mysqli->prepare($sql);

        $stmnt->bind_param('ddddd', $tds, $eps, $pj, $pm, $id_jugador);

        $stmnt->execute();

        $this->getStats();

        $mysqli->close();
    }

    function printLigasSelector()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT id_liga, nombre from liga';

        $smnt = $mysqli->prepare($sql);
        $smnt->execute();

        $result = $smnt->get_result();
        $selectorLigas = '<select name="Ligas">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selectorLigas .= '<option value="' . $row['id_liga'] . '">' . $row['nombre'] . '</option>';
            }
            $selectorLigas .= '</select>';
        }

        echo $selectorLigas;

        $mysqli->close();
    }

    function printEquiposSelector()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT id_equipo, nombre from equipo';

        $smnt = $mysqli->prepare($sql);
        $smnt->execute();

        $result = $smnt->get_result();
        $selectorEquipos = '<select name="Equipos">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selectorEquipos .= '<option value="' . $row['id_equipo'] . '">' . $row['nombre'] . '</option>';
            }
            $selectorEquipos .= '</select>';
        }

        echo $selectorEquipos;

        $mysqli->close();
    }

    function printEquiposLocalSelector()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT id_equipo, nombre from equipo';

        $smnt = $mysqli->prepare($sql);
        $smnt->execute();

        $result = $smnt->get_result();
        $selectorEquipos = '<select name="Local">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selectorEquipos .= '<option value="' . $row['id_equipo'] . '">' . $row['nombre'] . '</option>';
            }
            $selectorEquipos .= '</select>';
        }

        echo $selectorEquipos;

        $mysqli->close();
    }

    function printEquiposVisitanteSelector()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT id_equipo, nombre from equipo';

        $smnt = $mysqli->prepare($sql);
        $smnt->execute();

        $result = $smnt->get_result();
        $selectorEquipos = '<select name="Visitante">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selectorEquipos .= '<option value="' . $row['id_equipo'] . '">' . $row['nombre'] . '</option>';
            }
            $selectorEquipos .= '</select>';
        }

        echo $selectorEquipos;

        $mysqli->close();
    }

    function printJugadoresSelector()
    {
        $mysqli = new mysqli($this->server, $this->user, $this->pass, $this->dbname);

        $sql = 'SELECT id_jugador, nombre, apellido from jugador';

        $smnt = $mysqli->prepare($sql);
        $smnt->execute();

        $result = $smnt->get_result();
        $selectorEquipos = '<select name="Jugadores">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selectorEquipos .= '<option value="' . $row['id_jugador'] . '">' . $row['nombre'] . '-' . $row['apellido'] . '</option>';
            }
            $selectorEquipos .= '</select>';
        }

        echo $selectorEquipos;

        $mysqli->close();
    }
}

$flag = new FlagFootball();
$flag->getDB();


if (count($_POST) > 0) {
    if (isset($_POST["reboot"])) {
        $flag->rebootDB();
        $flag->getDB();
    } else if (isset($_POST["export"])) {
        $flag->exportDB();
    } else if (isset($_POST["addLiga"])) {
        $flag->addLigas($_POST['nombre'], $_POST['localidad']);
    } else if (isset($_POST["addEquipo"])) {
        $flag->addEquipos($_POST['nombre'], $_POST['ciudad'], $_POST['Ligas']);
    } else if (isset($_POST["addPartido"])) {
        $flag->addPartidos($_POST['Local'], $_POST['Visitante'], $_POST['resultado']);
    } else if (isset($_POST["addJugador"])) {
        $flag->addJugadores($_POST['nombre'], $_POST['apellido'], $_POST['numero'], $_POST['Equipos']);
    } else if (isset($_POST["addStat"])) {
        $flag->addStats($_POST['tds'], $_POST['eps'], $_POST['pjs'], $_POST['Jugadores']);
    } else if (isset($_POST["import_ligas"])) {
        $ruta = $_FILES["archivo_csv"]["tmp_name"];
        $lines = file($ruta_csv);

        foreach ($lines as $line) {
            $data = $data = str_getcsv($line, ', ');

            $flag->importLiga($data[0], $data[1]);
        }
    } else if (isset($_POST['import_equipos'])) {
        $ruta = $_FILES["archivo_csv"]["tmp_name"];
        $lines = file($ruta_csv);

        foreach ($lines as $line) {
            $data = $data = str_getcsv($line, ', ');

            $flag->importEquipo($data[0], $data[1], $data[3]);
        }
    } else if (isset($_POST['import_partidos'])) {
        $ruta = $_FILES["archivo_csv"]["tmp_name"];
        $lines = file($ruta_csv);

        foreach ($lines as $line) {
            $data = $data = str_getcsv($line, ', ');

            $flag->importPartido($data[0], $data[1], $data[3]);
        }
    } else if (isset($_POST['import_jugadores'])) {
        $ruta = $_FILES["archivo_csv"]["tmp_name"];
        $lines = file($ruta_csv);

        foreach ($lines as $line) {
            $data = $data = str_getcsv($line, ', ');

            $flag->importJugador($data[0], $data[1], $data[3], $data[4]);
        }
    } else if (isset($_POST['import_stats'])) {
        $ruta = $_FILES["archivo_csv"]["tmp_name"];
        $lines = file($ruta_csv);

        foreach ($lines as $line) {
            $data = $data = str_getcsv($line, ', ');

            $flag->importStats($data[0], $data[1], $data[3], $data[4], $data[5]);
        }
    } else if (isset($_POST['export_ligas'])) {
        $flag->export('liga');
    } else if (isset($_POST['export_equipos'])) {
        $flag->export('equipo');
    } else if (isset($_POST['export_partidos'])) {
        $flag->export('partido');
    } else if (isset($_POST['export_jugadores'])) {
        $flag->export('jugador');
    } else if (isset($_POST['export_stats'])) {
        $flag->export('estadisticas');
    }

}
?>

<!DOCTYPE HTML>

<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Escritorio Virtual - Memoria</title>
    <meta name="author" content="Álex Fernández Salé" />
    <meta name="description" content="Página del juego 'Flag!' de mi Escritorio Virtual" />
    <meta name="keywords" content="juego, memoria, escritorio, virtual" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="../estilo/flagfootball.css" />
    <link rel="stylesheet" type="text/css" href="../estilo/layout.css" />
    <link rel="stylesheet" type="text/css" href="../estilo/estilo.css" />
    <link rel="icon" href="multimedia/imagenes/favicon.ico" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav>
            <a accesskey="I" tabindex="1" href="../juegos.html">Juegos</a>

            <!-- JUEGOS -->
            <a accesskey="M" tabindex="2" href="../memoria.html">Memoria</a>
            <a accesskey="S" tabindex="3" href="../sudoku.html">Sudoku</a>
            <a accesskey="C" tabindex="4" href="../crucigrama.php">Crucigrama</a>
            <a accesskey="D" tabindex="5" href="../api.html">Anotador</a>
            <a accesskey="F" tabindex="6" href="flagFootball.php">Flag!</a>
        </nav>

        <h1>Escritorio Virtual</h1>
    </header>
    <h2>FLAG!</h2>
    <h3>Aquí tendrás acceso a estadísticas, partidos y ligas de flagfootball del norte de España</h3>

    <menu>
        <h3>Menu</h3>

        <form action='#' method='post' name="reboot">
            <label for="reboot">Reiniciar base de datos</label>
            <input type="submit" id="reboot" name="reboot" value="Reiniciar BD" />
        </form>

        <h4>Importar</h4>
        <form action="#" method="post" name="import_ligas">
            <label for="archivo_csv">Selecciona un archivo CSV para importar ligas:</label>
            <input type="file" id="archivo_csv" name="archivo_csv" accept=".csv" required>

            <button type="submit" name="import_ligas">Importar CSV</button>
        </form>

        <form action="#" method="post" name="import_equipos">
            <label for="archivo_csv">Selecciona un archivo CSV para importar equipos:</label>
            <input type="file" id="archivo_csv" name="archivo_csv" accept=".csv" required>

            <button type="submit" name="import_equipos">Importar CSV</button>
        </form>

        <form action="#" method="post" name="import_partidos">
            <label for="archivo_csv">Selecciona un archivo CSV para importar partidos:</label>
            <input type="file" id="archivo_csv" name="archivo_csv" accept=".csv" required>

            <button type="submit" name="import_partidos">Importar CSV</button>
        </form>

        <form action="#" method="post" name="import_jugadores">
            <label for="archivo_csv">Selecciona un archivo CSV para importar jugadores:</label>
            <input type="file" id="archivo_csv" name="archivo_csv" accept=".csv" required>

            <button type="submit" name="import_jugadores">Importar CSV</button>
        </form>

        <form action="#" method="post" name="import_stats">
            <label for="archivo_csv">Selecciona un archivo CSV para importar estadísticas:</label>
            <input type="file" id="archivo_csv" name="archivo_csv" accept=".csv" required>

            <button type="submit" name="import_stats">Importar CSV</button>
        </form>

        <h4>Exportar<h4>
                <form action='#' method='post' name="export">
                    <label for="export">Exportar ligas</label>
                    <input type="submit" id="export" name="export_ligas" value="Exportar" />
                </form>
                <form action='#' method='post' name="export">
                    <label for="export">Exportar equipos</label>
                    <input type="submit" id="export" name="export_equipos" value="Exportar" />
                </form>
                <form action='#' method='post' name="export">
                    <label for="export">Exportar partidos</label>
                    <input type="submit" id="export" name="export_partidos" value="Exportar" />
                </form>
                <form action='#' method='post' name="export">
                    <label for="export">Exportar jugadores</label>
                    <input type="submit" id="export" name="export_jugadores" value="Exportar" />
                </form>
                <form action='#' method='post' name="export">
                    <label for="export">Exportar estadisticas</label>
                    <input type="submit" id="export" name="export_stats" value="Exportar" />
                </form>

    </menu>
    <main>
        <section data-name="Ligas">
            <?php
            $flag->printLigas();
            ?>
            <form action="#" method="post" name="addLiga">
                <label for="nombre">Nombre de la liga</label>
                <input type="text" id="nombre" name="nombre" required />

                <label for="localidad">Localidad de la liga</label>
                <input type="text" id="localidad" name="localidad" required />

                <button type="submit" name="addLiga">Añadir liga</button>
            </form>
        </section>

        <section data-name="Equipos">
            <?php
            $flag->printEquipos();
            ?>
            <form action="#" method="post" name="addEquipo">
                <label for="nombre">Nombre del equipo</label>
                <input type="text" id="nombre" name="nombre" required />

                <label for="ciudad">Ciudad del equipo</label>
                <input type="text" id="ciudad" name="ciudad" required />

                <?php
                $flag->printLigasSelector();
                ?>
                <button type="submit" name="addEquipo">Añadir equipo</button>
            </form>
        </section>

        <section data-name="Partidos">
            <?php
            $flag->printPartidos();
            ?>
            <form action="#" method="post" name="addPartido">
                <?php
                $flag->printEquiposLocalSelector();
                $flag->printEquiposVisitanteSelector();
                ?>
                <label for="resultado">Resultado del partido (xx-xx)</label>
                <input type="text" id="resultado" name="resultado" required />

                <button type="submit" name="addPartido">Añadir partido</button>
            </form>
        </section>

        <section data-name="Jugadores">
            <?php
            $flag->printJugadores();
            ?>
            <form action="#" method="post" name="addJugador">
                <label for="nombre">Nombre del jugador</label>
                <input type="text" id="nombre" name="nombre" required />

                <label for="apellido">Apellido del jugador</label>
                <input type="text" id="apellido" name="apellido" required />

                <label for="numero">Numero del jugador</label>
                <input type="number" id="numero" name="numero" required />

                <?php
                $flag->printEquiposSelector();
                ?>

                <button type="submit" name="addJugador">Añadir jugador</button>
            </form>
        </section>

        <section data-name="Estadisticas">
            <?php
            $flag->printStats();
            ?>
            <form action="#" method="post" name="addStats">
                <?php
                $flag->printJugadoresSelector();
                ?>
                <label for="tds">Touchdowns del jugador</label>
                <input type="number" id="tds" name="tds" required />

                <label for="eps">ExtraPoints del jugador</label>
                <input type="number" id="eps" name="eps" required />

                <label for="pjs">Partidos jugados del jugador</label>
                <input type="number" id="pjs" name="pjs" required />

                <button type="submit" name="addStat">Añadir estadística</button>
            </form>
        </section>
    </main>

</body>

</html>