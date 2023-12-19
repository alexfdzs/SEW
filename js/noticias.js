class Noticias {
    constructor() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            this.validAPI = true;
        }
        else this.validAPI = false;
    }

    readInputFile(files) {
        if (this.validAPI) {
            var archivo = files[0];
            if (archivo.type.match(/text.*/)) {
                var lector = new FileReader();
                lector.onload = function (evento) {

                    var contenido = lector.result;

                    var noticias = contenido.split('\n');

                    noticias.forEach(noticia => {
                        let titular = noticia.split('_')[0];
                        let subtitulo = noticia.split('_')[1];
                        let contenido = noticia.split('_')[2];
                        let autor = noticia.split('_')[3];

                        let htmlContent = '<article>';  //<article> tiene que tener un h (el titular) 
                        htmlContent += `<h4>${titular}</h4>`;
                        htmlContent += `<h5>${subtitulo}</h5>`;
                        htmlContent += `<p data-name= "content">${contenido}</p>`;
                        htmlContent += `<p data-name= "author">${autor}</p>`;
                        htmlContent += '</article>';

                        $('[data-name="seeNews"]').append(htmlContent);
                    });

                }
                lector.readAsText(archivo);
            }
        }
    }

    addNew() {
        var titular = document.querySelector('input[name="titular"]').value;
        var subtitulo = document.querySelector('input[name="subtitulo"]').value;
        var contenido = document.querySelector('textarea[name="contenido"]').value;
        var autor = document.querySelector('input[name="autor"]').value;

        if (titular && subtitulo && contenido && autor) {
            let htmlContent = '<article>';  //<article> tiene que tener un h (el titular) 
            htmlContent += `<h4>${titular}</h4>`;
            htmlContent += `<h5>${subtitulo}</h5>`;
            htmlContent += `<p data-name= "content">${contenido}</p>`;
            htmlContent += `<p data-name= "author">${autor}</p>`;
            htmlContent += '</article>';

            $('[data-name="seeNews"]').append(htmlContent);

            document.querySelector('form').reset();
        } else {
            alert('Debe completar todos los camopos del formulario');
        }

    }
}

noticias = new Noticias();