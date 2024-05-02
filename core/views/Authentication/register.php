<div class="col-6 p-5 my-5 mx-auto container-background">
    <h3 class="text-center mb-4">Registo</h3>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger mb-3 p-3 text-center" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <form action="?a=register" method="POST">
        <div class="d-flex flex-column gap-3">
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col-auto">
                    <label for="full-name" class="col-form-label">Nome</label>
                </div>
                <div class="col-8">
                    <input type="text" id="full-name" name="full-name" class="form-control rounded-0" required>
                </div>
            </div>
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col-auto">
                    <label for="email" class="col-form-label">Email</label>
                </div>
                <div class="col-8">
                    <input type="email" id="email" name="email" class="form-control rounded-0" required>
                </div>
            </div>
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col-auto">
                    <label for="password" class="col-form-label">Senha</label>
                </div>
                <div class="col-8">
                    <input type="password" id="password" name="password" class="form-control rounded-0" required>
                </div>
            </div>
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col-auto">
                    <label for="confirm-password" class="col-form-label">Confirmar senha</label>
                </div>
                <div class="col-8">
                    <input type="password" id="confirm-password" name="confirm-password" class="form-control rounded-0" aria-describedby="passwordHelpInline" required>
                </div>
            </div>
            <div class="row align-items-start d-flex justify-content-between">
                <span id="passwordHelpInline" class="form-text text-end">
                    A senha deve possuir entre 8 e 20 caracteres.
                </span>
            </div>
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col-auto">
                    <label for="address" class="col-form-label">Morada</label>
                </div>
                <div class="col-8">
                    <input type="text" id="address" name="address" class="form-control rounded-0" required>
                </div>
            </div>
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col-auto">
                    <label for="city" class="col-form-label">Cidade</label>
                </div>
                <div class="col-8">
                    <input type="text" id="city" name="city" class="form-control rounded-0" required>
                </div>
            </div>
            <div class="row align-items-center d-flex justify-content-between">
                <div class="col-auto">
                    <label for="phone" class="col-form-label">Telefone</label>
                </div>
                <div class="col-8">
                    <input type="text" id="phone" name="phone" class="form-control rounded-0" >
                </div>
            </div>
            <div class="d-flex gap-2 mx-auto mt-3">
                <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Registar</button>
                <a class="btn btn-secondary rounded-0 btn-lg px-4 py-2" href="?a=<?= $_SESSION['previous-action'] ?>">Retornar</a>
            </div>
        </div>
    </form>
</div>

<!--
( * obrigatórios)
* nome_completo
* email
* senha_1
* senha_2
* morada
* cidade
telefone
-->