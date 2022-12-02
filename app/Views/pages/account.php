<?php if (isset($_SESSION['__user'])): ?>
    <!-- Recipes Section-->
    <section class="page-section portfolio mt-6" id="account">
        <div class="container account-container">
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
            <?php if (isset($data['response'])) echo $data['response']; ?>
            <!-- Account Flex Items-->
            <div class="column justify-content-start mt-5 text-dark fw-boldn align-items-center">
                <!-- Username-->
                <div class="account-option-wrapper">
                    <div class="account-option fs-6 m-auto">
                        <b>Username</b>
                        <span>
                        <em class="px-3 text-info fs-5"><?= $_SESSION['__user']['username'] ?></em>
                        <button class="btn btn-primary account-edit-btn">
                            <img alt="..." src="<?= baseurl ?>assets/imgs/icons/edit.png" height="16px"
                                 class="cursor-pointer invert-color"/>
                        </button>
                    </span>
                    </div>
                    <form action="?change_username" method="post" class="account-edit-form form-floating">
                        <input type="text" id="username" name="username" data-sb-validations="required"
                               placeholder="New username"/>
                        <button type="submit" class="btn btn-secondary">Cambiar</button>
                        <button type="button" class="btn btn-secondary close close-form">&#215;</button>
                    </form>
                </div>
                <hr/>
                <!-- Password-->
                <div class=" account-option-wrapper
                        ">
                    <div class="account-option fs-6 m-auto">
                        <b>Contraseña</b>
                        <span>
                            <em class="px-3 text-info fs-5">******</em>
                            <button class="btn btn-primary account-edit-btn">
                                <img alt="..." src="<?= baseurl ?>assets/imgs/icons/edit.png" height="16px"
                                     class="cursor-pointer invert-color"/>
                            </button>
                        </span>
                    </div>
                    <form action="?change_passwd" method="post" class="account-edit-form form-floating">
                        <input type="password" id="passwd-old" name="passwd-old" data-sb-validations="required"
                               placeholder="Old password"/>
                        <input type="password" id="passwd" name="passwd" data-sb-validations="required"
                               placeholder="New password"/>
                        <input type="password" id="passwd-repeat" name="passwd-repeat"
                               data-sb-validations="required"
                               placeholder="Repeat password"/>
                        <button type="submit" class="btn btn-secondary">Cambiar</button>
                        <button type="button" class="btn btn-secondary close close-form">&#215;</button>
                    </form>
                </div>
                <hr/>
                <?php if ($_SESSION['__user']['permissions'] === 1): ?>
                    <div class="account-option-wrapper">
                        <div class="account-option fs-6 m-auto">
                            <b>Ver mensajes</b>
                            <button type="button" class="btn btn-primary go"
                                    data-bs-target="#msg-modal" data-bs-toggle="modal">&#43;
                            </button>
                        </div>
                    </div>
                    <hr/>
                    <div class="account-option-wrapper">
                        <div class="account-option fs-6 m-auto">
                            <b>Gestionar Recetas</b>
                            <a href="?recipe_manage" class="go btn btn-primary">&#x2192;</a>
                        </div>
                    </div>
                    <hr/>
                    <div class="account-option-wrapper">
                        <div class="account-option fs-6 m-auto">
                            <b>Gestionar Usuarios</b>
                            <a href="?user_manage" class="go btn btn-primary">&#x2192;</a>
                        </div>
                    </div>
                    <hr/>
                <?php endif; ?>
                <div class="account-option-wrapper mt-4">
                    <div class="fs-6 m-auto column align-items-center justify-content-center">
                        <h6 class="text-center text-primary fw-bold py-3" id="account_deactivate-response"></h6>
                        <button class="btn btn-danger account_deactivate-btn">Desactivar cuenta</button>
                    </div>
                </div>
            </div>
            <!-- Deactivate account-->
        </div>
    </section>
    <section class="container">
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
                                <div class="col-lg-11">
                                    <!-- Modal - Title-->
                                    <h2 class="portfolio-modal-title text-secondary text-uppercase mb-0">Mensajes</h2>
                                    <!-- Database response goes here-->
                                    <h6 class="my-5 text-center" id="ajax-table_response"></h6>
                                    <!-- Icon Divider-->
                                    <div class="divider-custom">
                                        <div class="divider-custom-line"></div>
                                        <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                                        <div class="divider-custom-line"></div>
                                    </div>
                                    <!-- Modal Text-->
                                    <h6 class="mb-4 text-primary" id="msg-info"></h6>
                                    <table id="msg-table" style="width: 100%;"
                                           class="msg-table table hover order-column compact table-responsive"></table>
                                    <div class="panel-container mt-4">
                                        <div class="panel p-6 collapse" id="panel-msg_text">
                                            <div class="text-center" id="msg-body"></div>
                                            <button class="btn-close" id="close-msg" type="button"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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

<!-- JQuery script-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- Datatables script-->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<!-- My script-->
<script src="<?= baseurl ?>js/pages.account.js"></script>
