<div class="container-fluid">
    <div class="row my-5">
        <div class="col-12 text-center">
            <h3 class="text-center">Recuperar Password</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-4 mx-auto">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger mb-3 py-3 text-center" role="alert">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']);?>
            <?php endif ?>
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success mb-3 py-3 text-center" role="alert">
                    <?= $_SESSION['success'] ?>
                </div>
                <?php unset($_SESSION['success']);?>
            <?php endif ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4 mx-auto">
            <form action="?a=forgot_password" method="POST">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <p class="text-center">Informe o email associado a conta</p>
                    </div>
                    <div>
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control p-2" type="email" id="email" name="email" required />
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg px-4 py-2" type="submit">Enviar email</button>
                        <a class="btn btn-transparent btn-lg px-4 py-2" href="?a=<?= $_SESSION['previous-action']?>">Retornar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>