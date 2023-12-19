class ImageAnnotator {
    constructor() {
        this.canvas = document.querySelector('canvas');
        this.context = this.canvas.getContext("2d");;

        this.painting = false;
        this.imgName;

        this.init();
    }

    init() {
        this.canvas.addEventListener('mousedown', this.startDrawing.bind(this));
        this.canvas.addEventListener('mouseup', this.stopDrawing.bind(this));
        this.canvas.addEventListener('mousemove', this.draw.bind(this));
    }


    loadImage(files) {
        var file = files[0];
        this.imgName = file.name;
        const reader = new FileReader();
        reader.onload = (event) => {
            const img = new Image();
            img.onload = () => {
                this.drawImage(img);
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    }

    drawImage(image) {
        this.canvas.width = image.width;
        this.canvas.height = image.height;
        this.context.drawImage(image, 0, 0, image.width, image.height);
    }

    startDrawing(event) {
        this.painting = true;
        this.draw(event);
    }

    stopDrawing() {
        this.painting = false;
        this.context.beginPath();
    }

    draw(event) {
        if (!this.painting) return;

        this.context.lineWidth = 5;
        this.context.lineCap = 'round';
        this.context.strokeStyle = 'black';

        this.context.lineTo(event.clientX - this.canvas.offsetLeft, event.clientY - this.canvas.offsetTop);
        this.context.stroke();
        this.context.beginPath();
        this.context.moveTo(event.clientX - this.canvas.offsetLeft, event.clientY - this.canvas.offsetTop);
    }

    saveAnnotation() {

        const dataUrl = this.canvas.toDataURL('image/png');
        const link = document.createElement('a');
        link.href = dataUrl;
        link.download = this.imgName.replace(".png", "") + "_with_annotations.png";
        link.click();
    }

    exportToSVG() {
        const dataUrl = this.canvas.toDataURL('image/png');

        // Crear un elemento de imagen para almacenar la imagen en el documento
        const imgElement = document.createElement('img');
        imgElement.src = dataUrl;

        // Crear un elemento SVG
        const svgElement = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svgElement.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        svgElement.setAttribute('width', this.canvas.width);
        svgElement.setAttribute('height', this.canvas.height);

        // Agregar la imagen al SVG
        const imageSvg = document.createElementNS('http://www.w3.org/2000/svg', 'image');
        imageSvg.setAttribute('x', '0');
        imageSvg.setAttribute('y', '0');
        imageSvg.setAttribute('width', this.canvas.width);
        imageSvg.setAttribute('height', this.canvas.height);
        imageSvg.setAttributeNS('http://www.w3.org/1999/xlink', 'href', dataUrl);
        svgElement.appendChild(imageSvg);

        // Puedes agregar aquí más elementos SVG para representar anotaciones u otros elementos gráficos

        // Convertir el SVG a una cadena XML
        const svgXml = new XMLSerializer().serializeToString(svgElement);

        // Crear un enlace de descarga para el SVG
        const blob = new Blob([svgXml], { type: 'image/svg+xml' });
        const downloadLink = document.createElement('a');
        downloadLink.href = URL.createObjectURL(blob);
        downloadLink.download = this.imgName.replace(".png", "") + "_with_annotations.svg";
        downloadLink.click();
    }

}

api = new ImageAnnotator();
