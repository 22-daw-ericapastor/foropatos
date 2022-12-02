<?php if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1): ?>
    <!-- Recipes Section-->
    <section class="page-section portfolio mt-6" id="recipe-manage">
        <div class="container recipes_datatable-container">
            <!-- Account Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Gestionar recetas</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <h6 class="my-5 text-center" id="ajax-table_response"></h6>
            <div class="container">
                <div class="table-wrapper">
                    <div class="add_rcp-btn">
                        <a href="?add_recipe" class="btn btn-primary">Añadir receta</a>
                    </div>
                    <table id="recipes-table" class="table hover order-column compact table-responsive"></table>
                </div>
            </div>
        </div>
        <!-- BEGIN Update recipe form-->
        <div class="container" id="uptd_rcp-container">
            <!-- Add recipe Section Heading-->
            <h2 class="text-center text-uppercase text-secondary mb-0">Editar receta</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <h6 class="text-center text-primary my-2">Los campos marcados con asterisco son obligatorios.</h6>
            <h6 class="text-center my-2"><?php if (isset($data['response'])) echo $data['response']; ?></h6>
            <!-- Contact Section Form-->
            <div class="row justify-content-center">
                <div class="col-11">
                    <form id="add_rcp-form" method="post" action="?add_recipe" enctype="multipart/form-data">
                        <!-- Title input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="rcp_title" type="text" name="rcp_title" required
                                   placeholder="Da un titulo de menos de 20 letras" maxlength="30"/>
                            <label for="rcp_title">Título<small>*</small></label>
                        </div>
                        <!-- Short description input-->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="description" type="text" name="description" required
                                   placeholder="Escribe una frase pegadiza"/>
                            <label for="description">Pequeña descripción<small>*</small></label>
                        </div>
                        <!-- Difficulty input-->
                        <div class="form form-floating mb-3">
                            <label class="form-label" for="difficulty">Dificultad<small>*</small></label>
                            <div class="rcp-difficulty">
                                <input class="" id="difficulty" type="radio" name="difficulty" value="1" required/>Fácil
                                <input class="" id="difficulty" type="radio" name="difficulty" value="2" required/>Normal
                                <input class="" id="difficulty" type="radio" name="difficulty" value="3" required/>Difícil
                            </div>
                        </div>
                        <!-- Image input-->
                        <div class="form-floating mb-3 img-src-wrapper">
                            <label class="form-label" for="img_src">Imagen<small>*</small></label>
                            <input type="file" name="img_src" class="cursor-pointer form-control" id="img_src"
                                   accept="image/*" required/>
                        </div>
                        <!-- Making textarea-->
                        <div class="form-floating mb-3">
                        <textarea class="form-control" id="making" name="making"
                                  placeholder="Escribe la receta con todo detalle"></textarea>
                            <label for="making">Elaboración</label><br/>
                        </div>
                        <!-- Admixtures input-->
                        <div class="form-floating mb-3 d-flex flex-row align-items-center">
                        <textarea type="text" class="form-control" id="admixtures_input" name="admixtures_input"
                                  placeholder="Añade un ingrediente y dale al botón +"></textarea>
                            <button type="button" class="btn btn-primary edit-btn admixtures-btn">+</button>
                            <label for="admixtures_input">Ingredientes</label><br/>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control d-none" id="admixtures" name="admixtures"/>
                            <label for="admixtures">La lista está vacía</label><br/>
                        </div>
                        <!-- Submit Button-->
                        <button class="btn btn-primary btn-xl my-3" id="signin_btn" type="submit" name="updtrcp">Send
                        </button>
                        <p class="card-subtitle">
                            ¿No tienes cuenta todavía? Rellena nuestro
                            <a href="?signup">formulario</a>, solo cuesta dos minutos.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php else: ?>
    <!-- Recipes Section-->
    <section class="page-section portfolio mt-6" id="recipe-manage">
        <div class="container">
            <!-- Account Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Gestionar usuarios</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
            <div class="text-center fw-6 text-primary">¡Vaya! Parece que no tienes permiso para estar aquí ^^.</div>
        </div>
    </section>
<?php endif; ?>

<!-- JQuery script-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<!-- Datatables script-->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
<script src="<?= baseurl ?>js/pages.recipe.manage.js"></script>
