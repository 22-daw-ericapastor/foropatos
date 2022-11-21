<section class="page-section" id="contact">
    <div class="container">
        <!-- Contact Section Heading-->
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">Entrar</h2>
        <!-- Icon Divider-->
        <div class="divider-custom">
            <div class="divider-custom-line"></div>
            <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
            <div class="divider-custom-line"></div>
        </div>
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="login_form" method="post" action="?login">
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" type="text" name="username"
                               data-sb-validations="required" placeholder="Enter your name..."/>
                        <label for="username">Username</label>
                        <div class="invalid-feedback" data-sb-feedback="username:required">A name is required.</div>
                    </div>
                    <!-- Password input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="passwd" type="password" name="passwd"
                               placeholder="Write your password..." data-sb-validations="required"/>
                        <label for="passwd">Password</label>
                        <div class="invalid-feedback" data-sb-feedback="passwd:required">A phone number is required.
                        </div>
                    </div>
                    <!-- Submit Button-->
                    <button class="btn btn-primary btn-xl disabled my-3" id="submitButton" type="submit">Send</button>
                    <p class="card-subtitle">
                        ¿No tienes cuenta todavía? Rellena nuestro
                        <a href="?signin">formulario</a>, solo cuesta dos minutos.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>