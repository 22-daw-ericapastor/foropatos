document.addEventListener('DOMContentLoaded', async function () {

        const recipes_container = document.getElementById('recipes-grid'),
            modal_open_container = document.getElementById('open-modal'),
            url_base = window.location.href;

        let recipes_container_content = '',
            open_modal_content = '';

        await fetch('public/assets/data/recipes.json')
            .then(response => response.json())
            .then(data => {
                for (let i in data) {
                    recipes_container_content = recipes_container_content + format_content(data[i], i);
                    open_modal_content = open_modal_content + format_open_modal(data[i], i);
                }
            });

        recipes_container.innerHTML = recipes_container_content;
        modal_open_container.innerHTML = open_modal_content;

        function format_content(content, index) {
            return '    <div class="col-md-6 col-lg-4 mb-5">' +
                '        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#modal' + index + '">' +
                '            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">' +
                '                <div class="portfolio-item-caption-content text-center text-white p-3">' + content['description'] +
                '                    <br/><i class="fas fa-plus fa-3x"></i>' +
                '                </div>' +
                '            </div>' +
                '            <img class="img-fluid" src="' + url_base + content['img_src'] + '" alt="' + content['img_alt'] + '"/>' +
                '        </div>' +
                '    </div>';
        }

        function format_open_modal(content, index) {
            return '<div class="portfolio-modal modal fade" id="modal' + index + '" tabindex="-1" aria-labelledby="modal"' +
                '     aria-hidden="true">' +
                '     <div class="modal-dialog modal-xl">' +
                '         <div class="modal-content">' +
                '           <div class="modal-header border-0">' +
                '             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>' +
                '           </div>' +
                '           <div class="modal-body text-center pb-5">' +
                '             <div class="container">' +
                '               <div class="row justify-content-center">' +
                '                 <div class="col-lg-8">' +
                '                   <!-- Modal - Title-->' +
                '                   <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">' + content['title'] + '</h2>' +
                '                   <!-- Icon Divider-->' +
                '                   <div class="divider-custom">' +
                '                     <div class="divider-custom-line"></div>' +
                '                     <div class="divider-custom-icon"><i class="fas fa-star"></i></div>' +
                '                     <div class="divider-custom-line"></div>' +
                '                   </div>' +
                '                   <!-- Modal - Text-->' +
                '                   <p class="mb-4">' +
                '                     Cat ipsum dolor sit amet, twitch tail in permanent irritation, get poop stuck in ' +
                '                     paws jumping out of litter box and run around the house scream meowing and smearing ' +
                '                     hot cat mud all over pushed the mug off the table, vommit food and eat it again.' +
                '                   </p>' +
                '                   <form class="my-4">' +
                '                     <div class="form-floating mb-3">' +
                '                       <textarea class="form-control comment-text" id="comment" type="text" ' +
                '                         placeholder="Enter your comment here..."></textarea>' +
                '                         <label for="comment">Commentary</label>' +
                '                         <p class="comment_response"></p>' +
                '                     </div>' +
                '                     <button type="button" class="btn btn-primary comment-btn">Comment</button>' +
                '                   </form>' +
                '                   <ul class="comment-list"></ul>' +
                '                 </div>' +
                '               </div>' +
                '             </div>' +
                '           </div>' +
                '         </div>' +
                '       </div>' +
                '     </div>';
        }

        const comment_btn = document.getElementsByClassName('comment-btn'),
            comment_text = document.getElementsByClassName('comment-text'),
            comment_response = document.getElementsByClassName('comment_response'),
            comment_list = document.getElementsByClassName('comment-list');

        for (let i = 0; i < comment_btn.length; i++) {
            comment_btn[i].addEventListener('click', async function () {
                await fetch('?comment&comment_text=' + comment_text)
                    .then(response => response.text())
                    .then(data => {
                        console.log(data)
                        if (data['response'] === true) {
                            comment_response[i].classList.remove('text-danger');
                            comment_response[i].classList.toggle('text-success');
                            comment_response[i].innerHTML = '¡Comentario enviado con éxito!';
                        } else {
                            comment_response[i].classList.remove('text-success');
                            comment_response[i].classList.toggle('text-danger');
                            comment_response[i].innerHTML = 'Ha habido un problema enviando tu comentario...<br/>No lo intentes de nuevo.';
                        }
                        setTimeout(function () {
                            comment_response[i].innerHTML = '';
                        }, 3000);
                    });
            });
        }

    }
)
;