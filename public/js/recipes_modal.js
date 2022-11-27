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
     * HTML code for a recipe in the recipes list. This is a templates.
     *
     * @param content
     * @param index
     * @returns {string}
     */
    function format_content(content, index) {
        return '   <div class="col-md-6 col-lg-4 mb-5">' +
            '        <div class="portfolio-item mx-auto" data-bs-toggle="modal" data-bs-target="#modal' + index + '">' +
            '            <div class="portfolio-item-caption d-flex align-items-center justify-content-center h-100 w-100">' +
            '                <div class="portfolio-item-caption-content text-center text-white p-3">' + content['short_description'] +
            '                    <br/><i class="fas fa-plus fa-3x"></i>' +
            '                </div>' +
            '            </div>' +
            '            <img class="img-fluid" src="' + url_base + content['src'] + '" alt="' + content['slug'] + '"/>' +
            '        </div>' +
            '    </div>';
    }

    /**
     * Format recipes list container
     * -----------------------------------------------------------------------------------------------------------------
     * HTML code for a modal dialog. This is a templates.
     *
     * @param content
     * @param index
     * @returns {string}
     */
    function format_modal_dialogs(content, index) {
        return '<div class="portfolio-modal modal fade" id="modal' + index + '" tabindex="-1" aria-labelledby="modal"' +
            '     aria-hidden="true">' +
            '     <div class="modal-dialog">' +
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
            '                   <p class="mb-4 text-start">' +
            '                     ' + content['description'] +
            '                   </p>' +
            '                   <form class="mt-4 comment-form">' +
            '                     <div class="form-floating mb-3 d-inline-block">' +
            '                       <textarea class="form-control comment-text" id="comment" type="text" ' +
            '                         placeholder="Enter your comment here..."></textarea>' +
            '                         <label for="comment">Commentary</label>' +
            '                         <p class="comment_response"></p>' +
            '                     </div>' +
            '                     <div><button value="' + content['slug'] + '" type="button" class="btn btn-primary comment-btn">Comment</button></div>' +
            '                   </form>' +
            '                   <ul class="comment-list text-left"></ul>' +
            '                 </div>' +
            '               </div>' +
            '             </div>' +
            '           </div>' +
            '         </div>' +
            '       </div>' +
            '     </div>';
    }

    /*
     * Fetch recipes from Database and fill the content variables for the recipes list and modal dialog content.
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
     * Format comment list content
     * -----------------------------------------------------------------------------------------------------------------
     * HTML code for a comment in the comments list. This is a templates.
     *
     * @param content
     * @returns {string}
     */
    function format_comment_list(content) {
        return '<li class="comment-item">' +
            '     <p class="comment-user_time">' +
            '       <b>' + content['username'] + '</b>' +
            '       <em>' + content['datetime'] + '</em>: ' +
            '     </p>' +
            '     <p class="comments-db">' + content['comment'] + '</p>' +
            '   </li>';
    }

    async function fill_comments() {
        for (let i = 0; i < comment_list.length; i++) {
            await fetch('?comments_list&slug=' + comment_btn[i].value)
                .then(response => response.json())
                .then(data => {
                    console.log(data.length)
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

    await fill_comments();

    await fetch('?is_logged')
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < comment_btn.length; i++) {
                comment_btn[i].addEventListener('click', async function () {
                    if (!data['response']) {
                        window.location.assign(url_base + '?signin');
                    } else {
                        await fetch('?comment=' + comment_text[i].value + '&slug=' + this.value)
                            .then(response => response.text())
                            .then(data => {
                                comment_response[i].innerHTML = data;
                                setTimeout(function () {
                                    comment_response[i].innerHTML = '';
                                    comment_text[i].value = '';
                                    fill_comments();
                                }, 3000);
                            });
                    }
                });
            }
        });

});