class Sudoku {

    strEasy = '"3.4.69.5....27...49.2..4....2..85.198.9...2.551.39..6....8..5.32...46....4.75.9.6"';
    strMedium = '"23.94.67.8..3259149..76.32.1.....7925.321.4864..68.5317..1....96598721433...9...7"';
    strHard = '"8.4.71.9.976.3....5.196....3.7495...692183...4.5726..92483591..169847...753612984"'

    constructor() {
        this.strBoard = this.strEasy;
        this.rows = 9;
        this.columns = 9;
        this.board = new Array();
    }

    start() {
        var strCounter = 1;
        for (var r = 0; r < this.rows; r++) {
            this.board[r] = new Array();
            for (var c = 0; c < this.columns; c++) {
                if (this.strBoard.charAt(strCounter) == '.') {
                    this.board[r][c] = '0';
                } else {
                    this.board[r][c] = this.strBoard.charAt(strCounter)
                }
                strCounter++;
            }
        }
    }

    createStructure() {
        document.write('<main>');

        for (var r = 0; r < this.rows; r++) {
            for (var c = 0; c < this.columns; c++) {
                document.write('<p></p>');
            }
        }

        document.write('</main>');
    }

    paintSudoku() {
        this.createStructure();

        var cells = document.querySelectorAll('p');

        var cellCounter = 0;
        for (var r = 0; r < this.rows; r++) {
            for (var c = 0; c < this.columns; c++) {
                if(this.board[r][c] == '0'){
                    cells[cellCounter].addEventListener('click', this.blankSpace.bind(cells[cellCounter]));
                }else{
                    cells[cellCounter].dataset.state = 'blocked';
                    cells[cellCounter].textContent = this.board[r][c];
                }
                cellCounter++;
            }
        }
    }

    blankSpace(game) {
        var clickedCells = document.querySelectorAll('[data-state="clicked"]');
        clickedCells.forEach( cell => cell.dataset.state = "");

        this.dataset.state = "clicked";
    }

    introduceNumber(number){
        var cell = document.querySelector('[data-state="clicked"');

        var index = Array.from(document.querySelectorAll('p')).indexOf(cell);

        var row = Math.floor(index / this.columns);
        var column = index % this.columns;

        if(this.checkRow(row, number) && this.checkColumn(column, number) && this.checkSubBoard(row, column, number)){
            this.board[row][column] = number;
            //cell.removeEventListener('click', this.blankSpace.bind(cell));
            cell.dataset.state = 'correct';
            cell.textContent = number;

            if(this.checkBoard()){
                alert("ENHORABUENA! Has completado el sudoku!");
            }
        }else{
            alert("Numero incorrecto para la casilla");
        }
    }

    checkRow(row, number){
        for(var c = 0; c < this.columns; c++){
            if(this.board[row][c] == number){
                return false;
            }
        }
        return true;
    }

    checkColumn(column, number){
        for(var r = 0; r < this.rows; r++){
            if(this.board[r][column] == number){
                return false;
            }
        }
        return true;
    }

    checkSubBoard(row, column, number){
        var subRow = row - (row % 3);
        var subColumn = column - (column % 3);

        for(var sr = subRow; sr < subRow + 3; sr++){
            for(var sc = subColumn; sc < subColumn + 3; sc++){
                if(this.board[sr][sc] == number){
                    return false;
                }
            }
        }

        return true;
    }

    checkBoard(){
        for (var r = 0; r < this.rows; r++) {
            for (var c = 0; c < this.columns; c++) {
                if(this.board[r][c] == '0'){
                    return false;
                }
            }
        }
        return true;
    }
}

var sudoku = new Sudoku();
sudoku.start();