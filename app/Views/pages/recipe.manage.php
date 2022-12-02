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
                    <table id="recipes-table" class="table hover order-column compact table-responsive"></table>
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
<script src="<?=baseurl?>js/pages.recipe.manage.js"></script>
