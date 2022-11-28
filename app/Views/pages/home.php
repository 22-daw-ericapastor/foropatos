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
    <div class="container text-center">
        <!-- Recipes Section Heading-->
        <h2 class="page-section-heading text-uppercase text-secondary mb-0">Recetas destacadas</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <h6 class="fw-bold text-primary">¡Fíjate en las estrellas de dificultad de cada receta!</h6>
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
                <form id="contact-form">
                    <!-- Issue title -->
                    <div class="form-floating mb-3">
                        <input class="form-control contact" id="issue-title" type="text"
                               placeholder="Enter the issue title..."
                               data-sb-validations="required" name="issue_title"/>
                        <label for="issue-title">Titulo del mensaje</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required"></div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control contact" id="issue-msg" type="text" name="issue_msg"
                                  placeholder="Enter your message here..." data-sb-validations="required"></textarea>
                        <label for="issue-msg">Message</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required"></div>
                    </div>
                    <!-- Submit success message-->
                    <div class="d-none" id="submitSuccessMessage">
                        <div class="text-center mb-3">
                            <div class="fw-bolder">¡Increíble! Un administrador te responderá lo antes posible.</div>
                        </div>
                    </div>
                    <div class="text-center text-danger mb-3 d-none" id="submitErrorMessage">
                        Ha habido un error interno en el sistema. Vuelve a intentarlo en cinco o seis años.
                    </div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl disabled" id="issue-btn" type="button">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</section>
<section id="open-modal"></section>
<script src="<?= baseurl ?>js/recipes.modal.js"></script>
<script src="<?= baseurl ?>js/home.messages.js"></script>