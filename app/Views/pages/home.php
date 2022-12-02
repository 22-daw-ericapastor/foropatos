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
<section class="page-section portfolio" id="recipes">
    <div class="container text-center">
        <!-- Recipes Section Heading-->
        <h2 class="page-section-heading text-uppercase text-secondary mb-0">Nuestras recetas</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <h5 class="fw-bold text-primary">¡Click para leer, leer para saber!</h5>
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
        <h5 class="fw-bold text-center text-primary mb-5" id="contact-logged-info"></h5>
        <div class="mb-5" id="contact-response-msg"></div>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form>
                    <!-- Issue title -->
                    <div class="form-floating mb-3">
                        <input class="form-control contact" id="issue-title" type="text" minlength="3" maxlength="20"
                               placeholder="Enter the issue title..." data-sb-validations="required"/>
                        <label for="issue-title">Titulo del mensaje</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required"></div>
                    </div>
                    <!-- Message input-->
                    <div class="form-floating mb-3">
                        <textarea class="form-control contact" id="issue-msg" type="text" minlength="9" maxlength="500"
                                  placeholder="Enter your message here..." data-sb-validations="required"></textarea>
                        <label for="issue-msg">Message</label>
                        <div class="invalid-feedback" data-sb-feedback="message:required"></div>
                    </div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl" id="contact-btn" type="button">Enviar</button>
                </form>
            </div>
        </div>
    </div>
</section>
<section id="open-modal"></section>
<script src="<?= baseurl ?>js/pages.home.recipes.modal.js"></script>
<script src="<?= baseurl ?>js/pages.home.message.send.js"></script>