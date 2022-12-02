<section class="page-section mt-6" id="addrcp">
    <div class="container">
        <!-- Add recipe Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Añadir receta</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <h6 class="text-center"><?php if (isset($data['response'])) var_dump($data['response']); ?></h6>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="add_rcp-form" method="post" action="?add_recipe" enctype="multipart/form-data">
                    <!-- Title input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="rcp_title" type="text" name="rcp_title"
                               placeholder="" maxlength="20"/>
                        <label for="rcp_title">Título</label>
                    </div>
                    <!-- Short description input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="description" type="text" name="description"/>
                        <label for="description">Pequeña descripción</label>
                    </div>
                    <!-- Difficulty input-->
                    <div class="form difficulty-form mb-3">
                        <label class="form-label" for="difficulty">Dificultad</label>
                        <div class="rcp-difficulty">
                            <input class="" id="difficulty" type="radio" name="difficulty" value="1"/>Fácil
                            <input class="" id="difficulty" type="radio" name="difficulty" value="2"/>Normal
                            <input class="" id="difficulty" type="radio" name="difficulty" value="3"/>Difícil
                        </div>
                    </div>
                    <!-- Image input-->
                    <div class="form-floating mb-3">
                        <input type="file" accept="image/*" class="form-control" id="img_src" name="img_src">
                        <label for="img_src">Imagen</label>
                    </div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl my-3" id="signin_btn" type="submit">Send</button>
                    <p class="card-subtitle">
                        ¿No tienes cuenta todavía? Rellena nuestro
                        <a href="?signup">formulario</a>, solo cuesta dos minutos.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="<?= baseurl ?>js/pages.addrcp.js"></script>
<?php