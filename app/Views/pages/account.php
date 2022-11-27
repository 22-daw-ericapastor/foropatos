<?php if (isset($_SESSION['__user'])): ?>
    <!-- Recipes Section-->
    <section class="page-section portfolio mt-6" id="account">
        <div class="container">
            <!-- Account Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Tu cuenta</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <?php if ($_SESSION['__user']['permissions'] === 1): ?>
                <h5 class="masthead-subheading text-center text-uppercase text-primary">Administrador</h5>
            <?php endif; ?>
            <!-- Account Flex Items-->
            <div class="column justify-content-start mt-5 text-dark fw-bold">
                <div class="fs-5">Ver mensajes</div>
                <hr style="width: 50%;"/>
                <div class="fs-5">Ver comentarios</div>
                <hr style="width: 50%;"/>
                <?php if ($_SESSION['__user']['permissions'] === 1): ?>
                    <div class="fs-5">Gestionar Recetas</div>
                    <hr style="width: 50%;"/>
                    <ul class="account-list fs-6">
                        <li>
                            <a href="?add_recipe">Añadir receta</a>
                        </li>
                        <li>
                            <a href="?modify_recipe">Modificar receta</a>
                        </li>
                        <li>
                            <a href="?delete_recipe">Borrar receta</a>
                        </li>
                    </ul>
                    <div class="fs-5">Gestionar usuarios</div>
                    <hr style="width: 50%;"/>
                    <ul class="account-list fs-6">
                        <li>
                            <a href="?add_admin">Añadir usuario administrador</a>
                        </li>
                        <li>
                            <a href="?activate_user">Reactivar usuario</a>
                        </li>
                        <li>
                            <a href="?delete_user">Borrar usuario</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <section id="recipes-modal">
        <div class="portfolio-modal modal fade" id="modal  index  " tabindex="-1" aria-labelledby="modal"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center pb-5">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-8">
                                    <!-- Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">
                                        content[title] </h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <!-- Modal - Text-->
                                    <p class="mb-4 text-start">
                                        content[description]
                                    </p>
                                    <form class="mt-4 comment-form">
                                        <div class="form-floating mb-3 d-inline-block">
                                                           <textarea class="form-control comment-text" id="comment"
                                                                     type="text"
                                                                     placeholder="Enter your comment here..."></textarea>
                                            <label for="comment">Commentary</label>
                                            <p class="comment_response"></p>
                                        </div>
                                        <div>
                                            <button value="  content[slug]  " type="button"
                                                    class="btn btn-primary comment-btn">Comment
                                            </button>
                                        </div>
                                    </form>
                                    <ul class="comment-list text-left"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="open-recipes-modal"></section>
    <section id="open-users-modal"></section>

<?php else: ?>

    <section class="page-section portfolio mt-6" id="account">
        <div class="container">
            <!-- Account Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Oops</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <h5 class="masthead-subheading text-center text-uppercase text-primary">Parece que no estas loggeado.</h5>
        </div>
    </section>

<?php endif; ?>

<script src="<?=baseurl?>js/account.js"></script>
