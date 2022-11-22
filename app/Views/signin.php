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
                <form id="signin_form" method="post" action="?signin">
                    <?php if (isset($data['session_error'])) {
                        echo '<p class="card-subtitle text-danger">' . $data['session_error'] . '</p>';
                    } ?>
                    <!-- Username input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" type="text" name="username"
                               placeholder="Escribe tu nombre completo..." data-sb-validations="required"/>
                        <label for="username">Nombre completo</label>
                        <div class="invalid-feedback" data-sb-feedback="username:required">A name is required.</div>
                    </div>
                    <!-- Email address input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="email" type="email" placeholder="name@example.com" name="email"
                               data-sb-validations="required,email"/>
                        <label for="email">Email address</label>
                        <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                        <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                    </div>
                    <!-- Password input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="passwd" type="password" name="passwd"
                               placeholder="Write your password..." data-sb-validations="required"/>
                        <label for="passwd">Password</label>
                        <div class="invalid-feedback" data-sb-feedback="passwd:required">Password is required.
                        </div>
                    </div>
                    <!-- Repeat password input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="passwd_repeat" type="password" name="passwd_repeat"
                               placeholder="Repeat your password..." data-sb-validations="required"/>
                        <label for="passwd_repeat">Repeat password</label>
                        <div class="invalid-feedback" data-sb-feedback="passwd_repeat:required">Repeating password is
                            required.
                        </div>
                    </div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl my-3" id="submitButton" type="submit">Send</button>
                    <p class="card-subtitle">
                        ¿Ya tienes cuenta? Entra <a href="?login">aqui</a>.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>