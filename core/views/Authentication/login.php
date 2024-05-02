<div class="col-4 p-5 mt-auto mx-auto container-background">
    <h3 class="text-center">Login</h3>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger mb-3 p-3 text-center" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <form action="?a=login" method="POST">
        <div class="d-flex flex-column gap-3">
            <div>
                <label class="form-label" for="email">Email</label>
                <input class="form-control rounded-0 p-2" type="email" id="email" name="email" required />
            </div>
            <div>
                <label class="form-label" for="password">Senha</label>
                <input class="form-control rounded-0 p-2" type="password" id="password" name="password" required />
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