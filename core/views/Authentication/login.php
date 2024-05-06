<div class="container-fluid my-auto">
    <div class="col-md-6 mx-auto">
        <div class="card mb-4 shadow-sm rounded-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-5">Login</h3>
                <?php if (isset($_SESSION['error'])) : ?>
                    <div class="alert alert-danger mb-3 p-3 text-center" role="alert">
                        <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif ?>
                <form action="?a=login" method="POST">
                    <div class="d-flex flex-column gap-3">
                        <div class="form-floating mb-2">
                            <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="name@example.com" required />
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="" required />
                            <label for="password">Senha</label>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-link" href="?a=forgot_password">Esqueceu a senha?</a>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Login</button>
                            <a class="btn btn-transparent rounded-0 btn-lg px-4 py-2" href="?a=register">Criar conta</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>