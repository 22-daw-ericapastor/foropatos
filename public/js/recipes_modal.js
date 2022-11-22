document.addEventListener('DOMContentLoaded', async function () {

    const recipes_container = document.getElementById('recipes-grid'),
        url_base = window.location.href;

    let content = '';

    await fetch('public/assets/data/recipes.json')
        .then(response => response.json())
        .then(data => {
            for (let i in data) {
                content = content + format_content(data[i]);
            }
        });

    recipes_container.innerHTML = content;

    function format_content(content) {
        return '<div class="col-md-6 col-lg-4 mb-5">' +
                '<div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#modal1">' +
                    '<div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">' +
                        '<div class="portfolio-item-caption-content text-center text-white p-3">' + content['title'] + '<br/>' +
                        '<i class="fas fa-plus fa-3x"></i>' +
                        '</div>' +
                    '</div>' +
                '<img class="img-fluid" src="' + url_base + content['img_src'] + '" alt="' + content['img_alt'] + '"/>' +
            '</div>' +
        '</div>';
    }

    function format_open_modal(content) {

    }

});