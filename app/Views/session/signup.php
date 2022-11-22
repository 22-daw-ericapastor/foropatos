<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Registrarse</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="signin_form" method="post" action="?signup">
                    <p class="card-subtitle text-danger" id="session_error">
                        <?php if (isset($data['session_error'])) echo $data['session_error']; ?>
                    </p>
                    <p>
                        <?php if (isset($data['signup_success'])) echo $data['signup_success']; ?>
                    </p>
                    <!-- Username input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" type="text" name="username"
                               placeholder="Escribe tu nombre completo..."/>
                        <label for="username">Crea un nombre de usuario</label>
                    </div>
                    <!-- Email address input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" type="email" placeholder="name@example.com"
                               name="email"/>
                        <label for="email">Correo electrónico</label>
                        <div class="invalid-feedback" id="email_error"></div>
                    </div>
                    <!-- Password input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="passwd" type="password" name="passwd"
                               placeholder="Write your password..."/>
                        <label for="passwd">Password</label>
                        <div class="invalid-feedback" id="passwd_error">La contraseña debe tener al menos 8 dígitos
                        </div>
                    </div>
                    <!-- Repeat password input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="passwd_repeat" type="password" name="passwd_repeat"
                               placeholder="Repeat your password..."/>
                        <label for="passwd_repeat">Repeat password</label>
                        <div class="invalid-feedback" id="passwd_repeat_error">Las contraseñas deben coincidir.</div>
                    </div>
                    <!-- Submit Button-->
                    <button disabled class="btn btn-primary btn-xl my-3" id="signup_btn" type="submit">Send</button>
                    <p class="card-subtitle">
                        ¿Ya tienes cuenta? Entra <a href="?signin">aqui</a>.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="<?= baseurl ?>js/session_signup.js"></script>