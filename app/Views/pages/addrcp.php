<section class="page-section mt-6" id="addrcp">
    <div class="container">
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="add_rcp-form" method="post" action="?add_recipe">
                    <h6 class="text-danger"><?php if (isset($data['response'])) echo $data['response']; ?></h6>
                    <h6 class="text-danger"><?php if (isset($data['request'])) var_dump($data['request']); ?></h6>
                    <!-- Title input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="rcp_title" type="text" name="rcp_title"
                               placeholder=""/>
                        <label for="rcp_title">Título</label>
                    </div>
                    <!-- Short description input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="short_description" type="text" name="short_description"/>
                        <label for="short_description">Pequeña descripción</label>
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
