<?php
class Record
{
    public function __construct()
    {
        $this->server = "localhost";
        $this->user = "DBUSER2023";
        $this->pass = "DBPSWD2023";
        $this->dbname = "records";

        $this->mysqli =new mysqli($this->server, $this->user, $this->pass, $this->dbname);
    }

    function processRecord($surname, $name, $level, $time)
    {

        $sql = "insert into registro(nombre, apellidos, nivel, tiempo) values (?, ?, ?, ?);";

        $smnt = $this->mysqli->prepare($sql);
        $smnt->bind_param("sssd", $surname, $name, $level, $time);

        $smnt->execute();
    }

    function getTopRecords()
    {
        $sql = 'SELECT * FROM `registro` ORDER BY nivel, tiempo ASC LIMIT 10';

        $stmnt = $this->mysqli->prepare($sql);

        $stmnt->execute();

        $result = $stmnt->get_result();

        $this->strRecords = '';

        if ($result->num_rows > 0) {
            $this->strRecords .= "<h2>Los 10 mejores registros:</h2>";
            $this->strRecords .= "<ol>";
            while ($row = $result->fetch_assoc()) {
                $this->strRecords .= "<li>Usuario: " . $row["nombre"] . " " . $row["apellidos"] . " - Nivel: " . $row['nivel'] . " - Tiempo: " . $row["tiempo"] . "</li>";
            }
            $this->strRecords .= "</ol>";
        }

        return $this->strRecords;
    }
}

$record = new Record();

if (count($_POST) > 0) {
    $formulario = $_POST;

    $surname = $formulario["surname"];
    $name = $formulario["name"];
    $level = $formulario["level"];
    $time = $formulario["time"];

    $record->processRecord($surname, $name, $level, $time);
}
?>

<!DOCTYPE HTML>
<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta charset="UTF-8" />
    <title>Escritorio Virtual - Memoria</title>
    <meta name="author" content="Álex Fernández Salé" />
    <meta name="description" content="Página del juego 'Crucigrama' de mi Escritorio Virtual" />
    <meta name="keywords" content="juego, crugcigrama, matematico,  escritorio, virtual" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="estilo/layout.css" />
    <link rel="stylesheet" type="text/css" href="estilo/estilo.css" />
    <link rel="stylesheet" type="text/css" href="estilo/crucigrama.css" />
    <link rel="icon" href="multimedia/imagenes/favicon.ico" />

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="js/crucigrama.js"></script>
</head>

<body>
    <header>
        <nav>
            <a accesskey="I" tabindex="1" href="juegos.html">Juegos</a>

            <!-- JUEGOS -->
            <a accesskey="M" tabindex="2" href="memoria.html">Memoria</a>
            <a accesskey="S" tabindex="3" href="sudoku.html">Sudoku</a>
            <a accesskey="C" tabindex="4" href="crucigrama.php">Crucigrama</a>
            <a accesskey="D" tabindex="5" href="api.html">Anotador</a>
            <a accesskey="F" tabindex="6" href="php/flagFotball.php">Flag!</a>
        </nav>

        <h1>Escritorio Virtual</h1>
    </header>

    <h2>Crucigrama matematico</h2>

    <button onclick="crucigrama.loadHelp()">Instrucciones de juego</button>


    <script>
        addEventListener("keydown", (event) => {
            handleKeyDown(event);
        });

        function handleKeyDown(event) {
            if (!crucigrama.checkWinCondition()) {
                var cellClicked = document.querySelector('[data-state="clicked"]');

                if (cellClicked) {
                    if ((event.key >= '1' && event.key <= '9') || event.key == '+' || event.key == '-' || event.key == '/' || event.key == '*') {
                        crucigrama.introduceElement(event.key);
                    }
                    else {
                        alert("Debe introducir un valor válido. (número entre 1 y 9, +, -, *, /)");
                    }
                } else {
                    alert("Debe seleccionar primero una celda.")
                }
            }


        }
    </script>
    <section data-type="botonera">
        <h2>Botonera</h2>
        <button onclick="crucigrama.introduceElement(1)">1</button>
        <button onclick="crucigrama.introduceElement(2)">2</button>
        <button onclick="crucigrama.introduceElement(3)">3</button>
        <button onclick="crucigrama.introduceElement(4)">4</button>
        <button onclick="crucigrama.introduceElement(5)">5</button>
        <button onclick="crucigrama.introduceElement(6)">6</button>
        <button onclick="crucigrama.introduceElement(7)">7</button>
        <button onclick="crucigrama.introduceElement(8)">8</button>
        <button onclick="crucigrama.introduceElement(9)">9</button>
        <button onclick="crucigrama.introduceElement('*')">*</button>
        <button onclick="crucigrama.introduceElement('+')">+</button>
        <button onclick="crucigrama.introduceElement('-')">-</button>
        <button onclick="crucigrama.introduceElement('/')">/</button>
    </section>
</body>
<script>
    crucigrama.printMathword();
</script>

<?php
    echo $record ->getTopRecords();
?>

</html>