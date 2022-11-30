<?php if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1): ?>
    <!-- Recipes Section-->
    <section class="page-section portfolio mt-6" id="account">
        <div class="container account-container">
            <!-- Account Section Heading-->
            <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Gestionar usuarios</h2>
            <!-- Icon Divider-->
            <div class="divider-custom">
                <div class="divider-custom-line"></div>
                <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                <div class="divider-custom-line"></div>
            </div>
        </div>
    </section>
<?php else: ?>
    <!-- Recipes Section-->
    <section class="page-section portfolio mt-6" id="account">
        <div class="container account-container">
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