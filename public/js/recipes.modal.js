document.addEventListener('DOMContentLoaded', async function () {

    /**
     * Recipes list container
     * -----------------------------------------------------------------------------------------------------------------
     * Flex box on sight, images that you can see and click.
     *
     * @type {HTMLElement}
     */
    const recipes_container = document.getElementById('recipes-grid');

    /**
     * Modal dialog
     * -----------------------------------------------------------------------------------------------------------------
     * HTML objetc(s) that contain the modal content and are not on sight until an image is clicked.
     *
     * @type {HTMLElement}
     */
    const modal_dialog = document.getElementById('open-modal');

    /**
     * URL base
     * -----------------------------------------------------------------------------------------------------------------
     * This variable parameter will be used when calling resources like images or documents.
     *
     * URL will change upon parameters that it can receive, so it will be treated in consecuence.
     * If it has any GET parameters, for instance, they will be taken out.
     *
     * @type {string}
     */
    let url_base = window.location.href;
    // Check if there are any GET parameters and take them out -->
    if (url_base.match(/[?#]/)) {
        let esc = url_base.match(/[?#]/);
        url_base = url_base.substring(0, url_base.indexOf(esc));
    }

    /**
     * Recipes list variable content
     * -----------------------------------------------------------------------------------------------------------------
     * Used to hold variable content in the recipes list according to an asynchronous call to the Database.
     *
     * @type {string}
     */
    let recipes_container_content = '';

    /**
     * Modal dialog variable content
     * -----------------------------------------------------------------------------------------------------------------
     * Used to hold variable content in the modal dialogs according to an asynchronous call to the Database.
     *
     * @type {string}
     */
    let open_modal_content = '';

    /**
     * Format recipes list container
     * -----------------------------------------------------------------------------------------------------------------
     * HTML code for a recipe in the recipes list. This is a template.
     *
     * @param content
     * @param index
     * @returns {string}
     */
    function format_content(content, index) {
        return '   <div class="col-md-6 col-lg-4 mb-5">' +
            '        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#modal' + index + '">' +
            '            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">' +
            '                <div class="portfolio-item-caption-content text-center text-white p-3">' + content['description'] +
            '                    <br/><i class="fas fa-plus fa-3x"></i>' +
            '                </div>' +
            '            </div>' +
            '            <img class="img-fluid" src="' + url_base + content['src'] + '" alt="' + content['slug'] + '"/>' +
            '        </div>' +
            '    </div>';
    }

    /**
     * Rating of a recipe
     * -----------------------------------------------------------------------------------------------------------------
     * @param points
     * @returns {string}
     */
    function rating_stars(points) {
        let stars = '';
        if (!points) stars = '<em class="fs-6"><small>Este producto todavía no tiene valoraciones.</small></em>';
        else {
            if (points % 1 !== 0) {
                for (let i = 0; i < points - 1; i++) {
                    stars = stars + '<img alt="..." height="20px" src="' + url_base + 'public/assets/imgs/icons/star.png">';
                }
                stars = stars + '<img alt="..." height="20px" src="' + url_base + 'public/assets/imgs/icons/half-star.png">';
            } else {
                for (let i = 0; i < points; i++) {
                    stars = stars + '<img alt="..." height="20px" src="' + url_base + 'public/assets/imgs/icons/star.png">';
                }
            }
        }
        return stars;
    }

    /**
     * Format recipes list container
     * -----------------------------------------------------------------------------------------------------------------
     * HTML code for a modal dialog. This is a template.
     *
     * @param content
     * @param index
     * @returns {string}
     */
    function format_modal_dialogs(content, index) {
        const admixtures = content['admixtures'].split(',');
        let mixtures = '';
        for (let i = 0; i < admixtures.length; i++) {
            mixtures = mixtures + (i + 1) + '. ' + admixtures[i] + '<br/>';
        }
        let level = content['difficulty'];
        if (level === 1) level = 'Fácil.';
        else if (level === 2) level = 'Normal.';
        else if (level === 3) level = 'Difícil.';
        return '<div class="portfolio-modal modal fade" id="modal' + index + '" tabindex="-1" aria-labelledby="modal"' +
            '     aria-hidden="true">' +
            '     <div class="modal-dialog">' +
            '         <div class="modal-content">' +
            '           <div class="modal-header border-0">' +
            '             <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>' +
            '           </div>' +
            '           <div class="modal-body text-start pb-5">' +
            '             <div class="container">' +
            '               <div class="row justify-content-center">' +
            '                 <div class="col-lg-8">' +
            '                   <!-- Modal - Title-->' +
            '                   <h2 class="portfolio-modal-title text-center text-secondary text-uppercase mb-0">' + content['title'] + '</h2>' +
            '                   <!-- Icon Divider-->' +
            '                   <div class="divider-custom">' +
            '                     <div class="divider-custom-line"></div>' +
            '                     <div class="divider-custom-icon"><i class="fas fa-star"></i></div>' +
            '                     <div class="divider-custom-line"></div>' +
            '                   </div>' +
            '                   <!-- Recipes - Admixtures-->' +
            '                   <h5 class="text-primary">Ingredientes</h5>' +
            '                   <p class="mb-4 text-start">' +
            '                     ' + mixtures +
            '                   </p>' +
            '                   <!-- Recipes - Difficulty-->' +
            '                   <h5 class="text-primary">Dificultad</h5>' +
            '                   <p class="mb-4 text-start">' + level + '</p>' +
            '                   <!-- Recipes - Making-->' +
            '                   <h5 class="text-primary">Elaboración</h5>' +
            '                   <p class="mb-4 text-start">' +
            '                     ' + content['making'] +
            '                   </p>' +
            '                   <div class="rating">' +
            '                     <h5 class="text-primary m-0">Valoraciones</h5>' +
            '                     <div class="rating-stars text-info px-4">' + rating_stars(content['points']) + '</div>' +
            '                   </div>' +
            '                   <div class="comment-wrapper mt-3">' +
            '                     <ul class="comment-list text-left"></ul>' +
            '                   </div>' +
            '                   <form class="mt-4 comment-form">' +
            '                     <div class="rating-form">' +
            '                       <input type="checkbox" class="rating-checkbox"/>' +
            '                       <input type="checkbox" class="rating-checkbox"/>' +
            '                       <input type="checkbox" class="rating-checkbox"/>' +
            '                       <input type="checkbox" class="rating-checkbox"/>' +
            '                       <input type="checkbox" class="rating-checkbox"/>' +
            '                     </div>' +
            '                     <div class="form-floating mb-3 d-inline-block">' +
            '                       <textarea class="form-control comment-text" id="comment" type="text" ' +
            '                         placeholder="Enter your comment here..." maxlength="200"></textarea>' +
            '                         <label for="comment">Commentary</label>' +
            '                     </div>' +
            '                     <div><button value="' + content['slug'] + '" type="button" class="btn btn-primary comment-btn">Comment</button></div>' +
            '                   </form>' +
            '                   <p class="comment_response"></p>' +
            '                 </div>' +
            '               </div>' +
            '             </div>' +
            '           </div>' +
            '         </div>' +
            '       </div>' +
            '     </div>';
    }

    /**
     * Fill all recipes containers
     * -----------------------------------------------------------------------------------------------------------------
     * @returns {Promise<void>}
     */
    await fetch('?get_recipes')
        .then(response => response.json())
        .then(data => {
            for (let i in data) {
                recipes_container_content = recipes_container_content + format_content(data[i], i);
                open_modal_content = open_modal_content + format_modal_dialogs(data[i], i);
            }
        });

    /*
     * Fill the recipes content and the modal dialog according to the variable content.
     */
    recipes_container.innerHTML = recipes_container_content;
    modal_dialog.innerHTML = open_modal_content;

    /*
     * Next variables won't be properly initialized if the code above failed.
     */

    /**
     * Button in commentary section
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @type {HTMLCollectionOf<Element>}
     */
    const comment_btn = document.getElementsByClassName('comment-btn');

    /**
     * Text in commentary section
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @type {HTMLCollectionOf<Element>}
     */
    const comment_text = document.getElementsByClassName('comment-text');

    /**
     * Response text box
     * -----------------------------------------------------------------------------------------------------------------
     * This is to be filled according to a response from Main Controller.
     *
     * @type {HTMLCollectionOf<Element>}
     */
    const comment_response = document.getElementsByClassName('comment_response');

    /**
     * Comments list
     * -----------------------------------------------------------------------------------------------------------------
     * To be filled from Database data.
     *
     * @type {HTMLCollectionOf<Element>}
     */
    const comment_list = document.getElementsByClassName('comment-list');

    /**
     * Comments lists variable content
     * -----------------------------------------------------------------------------------------------------------------
     * Used to hold variable content in the comments lists according to an asynchronous call to the Database.
     *
     * @type {string}
     */
    let comment_list_content = '';

    /**
     * Rating stars container
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @type {HTMLCollectionOf<Element>}
     */
    const rating_form = document.getElementsByClassName('rating-form');

    /**
     * Format comment list content
     * -----------------------------------------------------------------------------------------------------------------
     * HTML code for a comment in the comments list. This is a template.
     *
     * @param content
     * @returns {string}
     */
    function format_comment_list(content) {
        let stars = '';
        for (let i = 0; i < content['rating']; i++) {
            stars = stars + '<img alt="..." height="12px" src="' + url_base + 'public/assets/imgs/icons/star.png">';
        }
        return '<li class="comment-item">' +
            '     <p class="comment-user_time">' +
            '       <span class="comment-user-logo" style="background: url(' + url_base + 'public/assets/imgs/guest-user.png' + ')">' +
            '       </span>' +
            '       <b>' + content['username'] + '</b>' +
            '       <em>' + content['datetime'] + '</em> ' +
            '       <span class="d-flex align-items-start ms-auto px-1"><em class="px-2">Rating</em>' + stars + '</span>' +
            '     </p>' +
            '     <hr/>' +
            '     <p class="comments-db">' + content['comment'] + '</p>' +
            '   </li>';
    }

    /**
     * Fill comments
     * -----------------------------------------------------------------------------------------------------------------
     * Fill the comment list getting data from Database.
     */
    async function fill_comments() {
        for (let i = 0; i < comment_list.length; i++) {
            await fetch('?comments_list&slug=' + comment_btn[i].value)
                .then(response => response.json())
                .then(data => {
                    if (data['null']) {
                        comment_list[i].innerHTML = data['null'];
                    } else {
                        for (let i in data) {
                            comment_list_content = comment_list_content + format_comment_list(data[i]);
                        }
                        comment_list[i].innerHTML = comment_list_content;
                        comment_list_content = '';
                    }
                });
        }
    }

    /**
     * Select stars in comments rating
     * -----------------------------------------------------------------------------------------------------------------
     * Check the stars checkbox depeding on which one is clicked.
     */
    function select_star() {
        for (let i = 0; i < rating_form.length; i++) {
            rating_form[i].addEventListener('click', function (evt) {
                let stars = rating_form[i].children;
                for (let j = 0; j < stars.length; j++) {
                    if (evt.target === stars[j]) {
                        for (let k = 0; k < stars.length; k++) {
                            if (k > j) {
                                stars[k].checked = false;
                            } else if (k < j) {
                                stars[k].checked = true;
                            } else {
                                if (stars[k + 1] && stars[k + 1].checked) {
                                    stars[k].checked = true;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    function unselect_stars() {
        for (let i = 0; i < rating_form.length; i++) {
            let stars = rating_form[i].children;
            for (let j = 0; j < stars.length; j++) {
                stars[j].checked = false;
            }
        }
    }

    /**
     * Insert comment into Database
     * -----------------------------------------------------------------------------------------------------------------
     * Insert the necessary data through GET parameters.
     */

    function get_stars(form) {
        let rating = 0;
        let stars = form.children;
        for (let i = 0; i < stars.length; i++) {
            if (stars[i].checked) {
                rating++;
            }
        }
        return rating;
    }

    function submit_comments() {
        for (let i = 0; i < comment_btn.length; i++) {
            comment_btn[i].addEventListener('click', async function () {
                let rate_num = get_stars(rating_form[i]);
                await fetch('?comment=' + comment_text[i].value + '&slug=' + this.value + "&rating=" + rate_num)
                    .then(response => response.text())
                    .then(data => {
                        console.log(data)
                        comment_response[i].innerHTML = data;
                        if (data.match(/enviado/)) {
                            comment_text[i].value = '';
                            unselect_stars();
                            fill_comments();
                        }
                        setTimeout(function () {
                            comment_response[i].innerHTML = '';
                        }, 2000);
                    });

            });
        }
    }

    // Check if user is logged.
    // False -> Make comments section unavailable and show an error message.
    // True -> Activate the previous functions

    await fetch('?is_logged')
        .then(response => response.json())
        .then(data => {
            if (!data['response']) {
                const comment_form = document.getElementsByClassName('comment-form');
                for (let i = 0; i < comment_form.length; i++) {
                    comment_form[i].style.display = 'none';
                    comment_response[i].innerHTML = '<p class="text-danger">Tienes que loggearte para poder comentar o ver comentarios.</p>';
                }
            } else {
                fill_comments();
                select_star();
                submit_comments();
            }
        });

});