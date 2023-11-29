class Memoria {
    elements = [
        {
            'element': 'HTML5',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/3/38/HTML5_Badge.svg'
        },
        {
            'element': 'HTML5',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/3/38/HTML5_Badge.svg'
        },
        {
            'element': 'CSS3',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/6/62/CSS3_logo.svg'
        },
        {
            'element': 'CSS3',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/6/62/CSS3_logo.svg'
        },
        {
            'element': 'JS',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/b/ba/Javascript_badge.svg'
        },
        {
            'element': 'JS',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/b/ba/Javascript_badge.svg'
        },
        {
            'element': 'PHP',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg'
        },
        {
            'element': 'PHP',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg'
        },
        {
            'element': 'SVG',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/4/4f/SVG_Logo.svg'
        },
        {
            'element': 'SVG',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/4/4f/SVG_Logo.svg'
        },
        {
            'element': 'W3C',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/5/5e/W3C_icon.svg'
        },
        {
            'element': 'W3C',
            'source': 'https://upload.wikimedia.org/wikipedia/commons/5/5e/W3C_icon.svg'
        }
    ];

    constructor() {
        this.shuffleElements();
        this.createElements();
        this.addEventListeners();

        this.hasFlippedCard = false;
        this.lockBoard = false;
        this.firstCard = null;
        this.secondCard = null;
    }

    shuffleElements() {
        this.elements.sort(() => Math.random() - 0.5);
    }

    unflipCards() {
        this.lockBoard = true;
        setTimeout(() => {
            this.firstCard.dataset.state = 'unflip';
            this.secondCard.dataset.state = 'unflip';

            this.resetBoard();
        }, 2000);

        
    }

    resetBoard() {
        this.firstCard = null;
        this.secondCard = null;
        this.lockBoard = false;
        this.hasFlippedCard = false;
    }

    checkForMatch() {
        return this.firstCard.isEqualNode(this.secondCard) ? this.disableCards() : this.unflipCards();
    }

    disableCards() {
        this.lockBoard = true;
        setTimeout(() => {
            this.firstCard.dataset.state = 'revealed';
            this.secondCard.dataset.state = 'revealed';

            this.resetBoard();
        }, 2000);
    }

    createElements() {

        for (var e of this.elements) {
            var htmlContent = '<article data-element=' + e + '>';
            htmlContent += '<h3>Tarjeta de memoria</h3>';
            htmlContent += '<img src="' + e['source'] + '" alt="' + e.element + '"/>';
            htmlContent += '</article>';

            document.write(htmlContent);
        }
    }

    addEventListeners() {
        var cards = document.querySelectorAll('article')
        cards.forEach(card => card.addEventListener('click', this.flipCard.bind(card, this)));
    }

    flipCard(game) {
        if (this.dataset.state == 'revealed')
            return;
        if (game.lockBoard)
            return;
        if (this == game.firstCard)
            return;

        this.dataset.state = 'flip';

        if (game.hasFlippedCard) {
            game.secondCard = this;
            game.checkForMatch();
        } else {
            game.hasFlippedCard = true;
            game.firstCard = this;
        }
    }

}

var memoria = new Memoria();
