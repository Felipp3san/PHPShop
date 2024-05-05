<div class="col-4 p-5 mt-auto mx-auto container-background">
    <h3 class="text-center">Admin</h3>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger mb-3 p-3 text-center" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <form action="?a=admin" method="POST">
        <div class="d-flex flex-column gap-3">
            <div>
                <label class="form-label" for="email">Username</label>
                <input class="form-control rounded-0 p-2" type="text" id="username" name="username" required />
            </div>
            <div>
                <label class="form-label" for="password">Senha</label>
                <input class="form-control rounded-0 p-2" type="password" id="password" name="password" required />
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Login</button>
            </div>
        </div>
    </form>
</div>