<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Foropatos</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?= baseurl ?>assets/imgs/cake.png"/>
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css"/>
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet"
          type="text/css"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= baseurl ?>css/freelancer_template.css" rel="stylesheet"/>
</head>
<body id="page-top">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top">Inicio</a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive"
                aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded" href="#recetas">Recetas</a>
                </li>
                <li class="nav-item mx-0 mx-lg-1">
                    <a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contacto</a>
                </li>
                <?php if (isset($_SESSION['__user'])): ?>
                    <?php if ($_SESSION['__user']['permissions'] === 1): ?>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded" href="?">Gestionar recetas</a>
                        </li>
                        <li class="nav-item mx-0 mx-lg-1">
                            <a class="nav-link py-3 px-0 px-lg-3 rounded" href="?">Gestionar usuarios</a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="?account">Tu Cuenta</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="?signout">Sign out</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="?signin">Sign in</a>
                    </li>
                    <li class="nav-item mx-0 mx-lg-1">
                        <a class="nav-link py-3 px-0 px-lg-3 rounded" href="?signup">Sign up</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
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
