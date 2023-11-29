class Fondo{
    constructor(nombrePais, latCapital, lonCapital, capital){
        this.nombrePais = nombrePais;
        this.latCapital = latCapital;
        this.lonCapital = lonCapital;
        this.capital = capital;

    }

    getPhoto(){
        var flickrAPI = "https://www.flickr.com/services/rest/?method=flickr.photos.search&api_key=d8417074d61b31be0768e824329fa769";

        $.getJSON(flickrAPI,
            {
                tags: this.nombrePais,
                lat : this.latCapital,
                lon : this.lonCapital,
                format: "json",
                nojsoncallback: 1
            })
            .done(function(data){
                let allPhotos = data.photos;
                let idx = Math.floor(Math.random() * data.photos.perpage);

                let img = allPhotos.photo[idx];

                let imgUrl = `https://live.staticflickr.com/${img.server}/${img.id}_${img.secret}_b.jpg`;
                
                $('body').css('background-image', `url(${imgUrl})`);
            });


    }

}

var fondo = new Fondo("Gambia", "13.457802203795607",  "-16.625392440157885", "Banjul");
13.457802203795607, -16.625392440157885