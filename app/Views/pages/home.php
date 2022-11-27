<!-- Masthead-->
<header class="masthead bg-primary text-light text-center">
    <div class="container d-flex align-items-center flex-column">
        <?php if (isset($data) && $data['page'] != 'signup' && $data['page'] != 'signin'): ?>
            <!-- Masthead Avatar Image-->
            <img class="masthead-avatar" src="<?= baseurl ?>assets/imgs/cake.png" alt="..."/>
        <?php endif; ?>
        <!-- Masthead Heading-->
        <h1 class="masthead-heading text-uppercase mb-0 mt-5 text-light">Foropatos</h1>
        <!-- Icon Divider-->
        <div class="divider-custom divider-light">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <?php if (isset($data) && $data['page'] === 'signup'): ?>
            <h2 class="page-section-heading text-center text-uppercase text-light mb-0">Registrarse</h2>
        <?php elseif (isset($data) && $data['page'] === 'signin'): ?>
            <h2 class="page-section-heading text-center text-uppercase text-light mb-0">Entrar</h2>
        <?php endif; ?>
    </div>
</header>
<!-- Recipes Section-->
<section class="page-section portfolio" id="recetas">
    <div class="container">
        <!-- Recipes Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Recetas destacadas</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Recipes Grid Items-->
        <div class="row justify-content-center" id="recipes-grid"></div>
    </div>
</section>
<!-- Contact Section-->
<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary">Contáctanos</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <h6 class="text-center text-primary mb-5">¿Tienes dudas? ¿Sugerenecias? No dudes en escribirnos.</h6>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="contactForm">
                    <!-- Issue title -->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="issue_title" type="text" placeholder="Enter the issue title..."
                               data-sb-validations="required" name="issue_title"/>
                        <label for="issue_title">Titulo del mensaje</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required"></div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="issue_msg" type="text"
                                  placeholder="Enter your message here..."
                                  style="height: 10rem" data-sb-validations="required" name="issue_msg"></textarea>
                        <label for="issue_msg">Message</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required"></div>
                    </div>
                    <!-- Submit success message-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">¡Increíble! Un administrador te responderá lo antes posible.</div>
                        </div>
                    </div>
                    <div class="d-none" id="submitErrorMessage">
                        <div class="text-center text-danger mb-3">Ha habido un error interno en el sistema. Vuelve a
                            intentarlo en cinco o seis años.
                        </div>
                    </div>
                    <!-- Submit Button-->
                    <button value="<?php if (isset($_SESSION['__user'])) echo $_SESSION['__user']['username'] ?>"
                            class="btn btn-primary btn-xl disabled" id="submit_issue" type="submit">Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
<section id="open-modal"></section>
<script src="<?= baseurl ?>js/recipes_modal.js"></script>
