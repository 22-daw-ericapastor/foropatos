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
            <div class="column justify-content-start mt-5 text-dark fw-boldn align-items-center">
                <!-- Username-->
                <div class="account-option-wrapper">
                    <div class="account-option fs-6 m-auto">
                        <b>Username</b>
                        <span>
                        <em class="px-3 text-info"><?= $_SESSION['__user']['username'] ?></em>
                        <button class="btn btn-primary d-inline-flex justify-content-center account-edit-btn">
                            <img alt="..." src="<?= baseurl ?>assets/imgs/icons/edit.png" height="16px"
                                 class="cursor-pointer invert-color"/>
                        </button>
                    </span>
                    </div>
                    <form action="?new_username" method="post" class="account-edit-form form-floating">
                        <input type="text" id="username" name="username" data-sb-validations="required"
                               placeholder="New username"/>
                        <button type="submit" class="btn btn-secondary">Cambiar</button>
                        <span class="close close-form">&#215;</span>
                    </form>
                </div>
                <hr/>
                <!-- Password-->
                <div class="account-option-wrapper">
                    <div class="account-option fs-6 m-auto">
                        <b>Contraseña</b>
                        <span>
                            <em class="px-3 text-info">******</em>
                            <button class="btn btn-primary d-inline-flex justify-content-center account-edit-btn">
                                <img alt="..." src="<?= baseurl ?>assets/imgs/icons/edit.png" height="16px"
                                     class="cursor-pointer invert-color"/>
                            </button>
                        </span>
                    </div>
                    <form action="?new_password" method="post" class="account-edit-form form-floating">
                        <input type="text" id="passwd-old" name="passwd-old" data-sb-validations="required"
                               placeholder="Old password"/>
                        <input type="text" id="passwd" name="passwd" data-sb-validations="required"
                               placeholder="New password"/>
                        <input type="text" id="passwd-repeat" name="passwd-repeat" data-sb-validations="required"
                               placeholder="Repeat password"/>
                        <button type="submit" class="btn btn-secondary">Cambiar</button>
                        <span class="close close-form">&#215;</span>
                    </form>
                </div>
                <hr/>
                <?php if ($_SESSION['__user']['permissions'] === 1): ?>
                    <div class="account-option-wrapper">
                        <div class="account-option fs-6 m-auto">
                            <b>Ver mensajes</b>
                            <span><i class="plus-sign text-light">&#43;</i></span>
                        </div>
                    </div>
                    <hr/>

                <!-- old starts here-->
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
            <!-- Deactivate account-->
        </div>
    </section>
    <section id="open-msgs-modal">
        <div class="portfolio-modal modal fade" id="msg-modal" tabindex="-1" aria-labelledby="modal"
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
                                    <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Tus
                                        Mensajes</h2>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <!-- Modal Text-->
                                    <h6 class="mb-4 text-primary" id="msgs-info"></h6>
                                    <ul class="comment-list text-left">
                                        <li class="comment-item">
                                            <p class="comment-user_time cursor-pointer fs-6">
                                                <b>username</b>
                                                <em>last date time</em>
                                            </p>
                                            <ul class="ps-3 msg-list collapse">
                                                <li class="column">
                                                    <span class="comment-user_time">usuario<em>datetime</em></span><span>Mensaje</span>
                                                </li>
                                                <li class="column">
                                                    <span class="comment-user_time">usuario<em>datetime</em></span><span>Mensaje</span>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="comment-item">
                                            <p class="comment-user_time cursor-pointer fs-6">
                                                <b>username</b>
                                                <em>last date time</em>
                                            </p>
                                            <ul class="ps-3 msg-list collapse">
                                                <li class="column">
                                                    <span class="comment-user_time">usuario<em>datetime</em></span><span>Mensaje</span>
                                                </li>
                                                <li class="column">
                                                    <span class="comment-user_time">usuario<em>datetime</em></span><span>Mensaje</span>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                    <form class="collapse mt-4 comment-form">
                                        <div class="form-floating mb-3 d-inline-block">
                                            <textarea class="form-control comment-text" id="msg" type="text"
                                                      placeholder="Enter your message here..."></textarea>
                                            <label for="msg">Message</label>
                                            <p class="msg-response"></p>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-primary comment-btn">Enviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="open-comments-modal"></section>
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

<script src="<?= baseurl ?>js/account.js"></script>
