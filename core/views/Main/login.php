<div class="container-fluid">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h3 class="text-center">LOGIN</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-3 mx-auto">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger mb-3 py-3" role="alert">
                    <ul class="mx-4">
                        <li><?= $_SESSION['error'] ?></li>
                    </ul>
                </div>
            <?php endif ?>
            <?php unset($_SESSION['error']);?>
        </div>
    </div>
    <div class="row">
        <div class="col-3 mx-auto">
            <form action="?a=login" method="POST">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control p-2" type="email" id="email" name="email" required />
                    </div>
                    <div>
                        <label class="form-label" for="password">Senha</label>
                        <input class="form-control p-2" type="password" id="password" name="password" required />
                    </div>
                    <div class="d-flex justify-content-end">
                        <a class="btn btn-link" href="">Esqueceu a senha?</a>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg px-4 py-2" type="submit">Login</button>
                        <a class="btn btn-transparent btn-lg px-4 py-2" href="?a=register">Criar conta</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>