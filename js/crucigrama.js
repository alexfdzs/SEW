class Crucigrama {

    strEasy = "4,*,.,=,12,#,#,#,5,#,#,*,#,/,#,#,#,*,4,-,.,=,.,#,15,#,.,*,#,=,#,=,#,/,#,=,.,#,3,#,4,*,.,=,20,=,#,#,#,#,#,=,#,#,8,#,9,-,.,=,3,#,.,#,#,-,#,+,#,#,#,*,6,/,.,=,.,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,6,#,8,*,.,=,16";
    strMedium = "12, *,.,=, 36,#,#,#, 15,#,#, *,#,/,#,#,#,*,.,-,.,=,.,#, 55,#,.,*,#,=,#,=,#, /,#,=,.,#,15,#,9,*,.,=,45,=,#,#,#,#,#,=,#,#,72,#,20,-,.,=,11,#,.,#,#,-,#, +,#,#,#,*, 56, /,.,=,.,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,12,#,16,*,.,=,32";
    strHard = "4,.,.,=,36,#,#,#,25,#,#,*,#,.,#,#,#,.,.,-,.,=,.,#,15,#,.,*,#,=,#,=,#,.,#,=,.,#,18,#,6,*,.,=,30,=,#,#,#,#,#,=,#,#,56,#,9,-,.,=,3,#,.,#,#,*,#,+,#,#,#,*,20,.,.,=,18,#,#,#,.,#,#,=,#,=,#,#,#,=,#,#,18,#,24,.,.,=,72";

    constructor() {
        this.difficulty = "Facil";
        this.strBoard = this.strEasy;
        this.columns = 9;
        this.rows = 11;
        this.init_time = null;
        this.end_time = null;
        this.board = new Array(this.rows);

        this.initialize();
        this.start();
    }

    initialize() {
        for (var r = 0; r < this.rows; r++) {
            this.board[r] = new Array(this.columns);
        }
    }

    start() {
        var cnt = 0;
        var cells = this.strBoard.split(',');

        for (var r = 0; r < this.rows; r++) {
            for (var c = 0; c < this.columns; c++) {
                switch (cells[cnt]) {
                    case '#':
                        this.board[r][c] = -1;
                        break;
                    case '.':
                        this.board[r][c] = 0;
                        break;
                    default:
                        if (!isNaN(cells[cnt]))
                            this.board[r][c] = parseInt(cells[cnt]);
                        else
                            this.board[r][c] = cells[cnt]
                }
                cnt++;
            }
        }
    }

    createStructure() {
        $('body').append('<main></main>');

        for (var r = 0; r < this.rows; r++) {
            for (var c = 0; c < this.columns; c++) {
                $('main').append(`<p data-row = "${r}" data-column = "${c}"></p>`);
            }
        }
    }

    printMathword() {
        this.createStructure();

        var cells = document.querySelectorAll('p');

        var cellCounter = 0;
        for (var r = 0; r < this.rows; r++) {
            for (var c = 0; c < this.columns; c++) {
                if (this.board[r][c] == 0)
                    cells[cellCounter].addEventListener('click', this.blankSpace.bind(cells[cellCounter]));
                else if (this.board[r][c] == -1)
                    cells[cellCounter].dataset.state = 'empty';
                else {
                    cells[cellCounter].dataset.state = 'blocked';
                    cells[cellCounter].textContent = this.board[r][c];
                }
                cellCounter++;
            }
        }

        this.init_time = new Date();
    }

    blankSpace(game) {
        var clickedCells = document.querySelectorAll('[data-state="clicked"]');
        clickedCells.forEach(cell => cell.dataset.state = "");

        this.dataset.state = "clicked";
    }

    checkWinCondition() {
        var cells = document.querySelectorAll('p');
        for (var c = 0; c < cells.length; c++) {
            if (cells[c].textContent == 0 && cells[c].dataset.state != 'empty')
                return false;
        }
        return true;
    }

    calculate_date_difference() {
        var diff = this.end_time - this.init_time;

        var segundos = Math.floor(diff / 1000);
        var minutos = Math.floor(segundos / 60);
        var horas = Math.floor(minutos / 60);

        minutos %= 60;
        segundos %= 60;

        return horas + ' h ' + minutos + ' mins ' + segundos + ' segundos';
    }

    introduceElement(element) {
        var cell = document.querySelector('[data-state="clicked"');

        var row = parseInt(cell.getAttribute('data-row'));
        var col = parseInt(cell.getAttribute('data-column'));

        this.board[row][col] = !isNaN(element) ? parseInt(element) : element;

        if (this.checkCell(row, col)) {
            cell.dataset.state = 'correct';
            cell.textContent = element;
        } else {
            cell.dataset.state = '';
            alert('Elemento incorrecto para la casilla.')
        }

        if (this.checkWinCondition()) {
            this.end_time = new Date();

            alert(`ENHORABUENA! Has terminado el crucigrama en: \n${this.calculate_date_difference()}`)
            this.createRecordForm();
        }
    }

    checkCell(row, col) {
        var expression_row = this.checkRow(row, col);
        var expression_col = this.checkColumn(row, col);

        return expression_col && expression_row;
    }

    checkRow(row, col) {
        var nextCol = col + 1;

        if (nextCol >= this.columns - 1) {
            return true;
        }
        if (this.board[row][nextCol] == -1) {
            return true;
        }

        var equalsCol = -1;
        for (var c = nextCol; c < this.columns; c++) {
            if (this.board[row][c] == '=') {
                equalsCol = c;
                break;
            }

        }

        var first_number = this.board[row][equalsCol - 3];
        var second_number = this.board[row][equalsCol - 1];
        var expression = this.board[row][equalsCol - 2];
        var result = this.board[row][equalsCol + 1];

        if (first_number != 0 && second_number != 0 && expression != 0 && result != 0) {
            var math_array = [first_number, expression, second_number];
            var math_expression = math_array.join(" ");

            if (eval(math_expression) == result) {
                return true;
            }
            else {
                return false;
            }
        }

        return true;
    }

    checkColumn(row, col) {
        var nextRow = row + 1;
        if (nextRow >= this.rows - 1) {
            return true;
        }
        if (this.board[nextRow][col] == -1) {
            return true;
        }

        var equalsRow = -1;
        for (var r = nextRow; r < this.rows; r++) {
            if (this.board[r][col] == '=') {
                equalsRow = r;
                break;
            }

        }

        var first_number = this.board[equalsRow - 3][col];
        var second_number = this.board[equalsRow - 1][col];
        var expression = this.board[equalsRow - 2][col];
        var result = this.board[equalsRow + 1][col];

        if (first_number != 0 && second_number != 0 && expression != 0 && result != 0) {
            var math_array = [first_number, expression, second_number];
            var math_expression = math_array.join(" ");

            if (eval(math_expression) == result) {
                return true;
            }
            else {
                return false;
            }
        }

        return true;
    }

    loadHelp(){
        var alertContent = "Instrucciones de juego:\n";
        alertContent += "El juego consiste en resolver el crucigrama, introduciendo números u operadores en las casillas vacías.\n";
        alertContent += "Las casillas negras no tienen contenido.\n"
        alertContent += "Para introducir un elemento en una celda, pulse la celda y, después, introduzca el elemento por teclado.\n";

        alert(alertContent);
    }

    createRecordForm(){
        var htmlContent = '<section data-name="saveRecord">';
        htmlContent += '<h3>Guarda tu resultado</h3>';
        htmlContent += '<form action="#" method="post" name="saveRecord">';
        htmlContent += '<label for="surname">Nombre:</label/>';
        htmlContent += '<input type="text" id="surname" name="surname" required/>';
        htmlContent += '<label for="name">Apellidos:</label/>';
        htmlContent += '<input type="text" id="name" name="name" required/>';
        htmlContent += '<label for="level">Dificultad:</label/>';
        htmlContent += `<input type="text" id="level" name="level" value=${this.difficulty} readonly/>`;
        htmlContent += '<label for="name">Tiempo:</label/>';
        htmlContent += `<input type="text" id="time" name="time" value=${(this.end_time - this.init_time)/1000} readonly/>`;
        htmlContent += '<input type="submit" value="Guardar resultado"/>';
        htmlContent += '</form></section>';

        $('main').after(htmlContent);
    }
}

crucigrama = new Crucigrama();