<section class="page-section mt-6" id="signin">
    <div class="container">
        <!-- Contact Section Form-->
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <form id="login_form" method="post" action="?signin">
                    <p class="h6 text-danger text-center"><?php if (isset($data['response'])) echo $data['response'] ?></p>
                    <!-- Name input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="username" type="text" name="username"
                               placeholder="Enter your name..."/>
                        <label for="username">Username</label>
                    </div>
                    <!-- Password input-->
                    <div class="form-floating mb-3">
                        <input class="form-control" id="passwd" type="password" name="passwd"
                               placeholder="Write your password..."/>
                        <label for="passwd">Password</label>
                    </div>
                    <!-- Submit Button-->
                    <button disabled class="btn btn-primary btn-xl my-3" id="signin_btn" type="submit">Send</button>
                    <p class="card-subtitle">
                        ¿No tienes cuenta todavía? Rellena nuestro
                        <a href="?signup">formulario</a>, solo cuesta dos minutos.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="<?= baseurl ?>js/session.signin.js"></script>
