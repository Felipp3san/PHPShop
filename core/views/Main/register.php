<div class="container mx-auto">
    <div class="row my-5">
        <div class="col-12">
            <h3 class="text-center">Registo de novo cliente</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mx-auto">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger p-3 mb-3" role="alert">
                    <?= $_SESSION['error'] ?>
                </div>
            <?php endif ?>
            <?php unset($_SESSION['error']);?>
        </div>
    </div>
    <div class="row">
        <div class="col-6 mx-auto">
            <form action="?a=create_user" method="POST">
                <div class="d-flex flex-column gap-3">
                    <div>
                        <label class="form-label" for="full-name">Nome completo</label>
                        <input class="form-control p-2" type="text" id="full-name" name="full-name" required />
                    </div>
                    <div>
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control p-2" type="email" id="email" name="email" required />
                    </div>
                    <div>
                        <label class="form-label" for="password">Senha</label>
                        <input class="form-control p-2" type="password" id="password" name="password" required />
                    </div>
                    <div>
                        <label class="form-label" for="confirm-password">Confirmar Senha</label>
                        <input class="form-control p-2" type="password" id="confirm-password" name="confirm-password" required />
                    </div>
                    <div>
                        <label class="form-label" for="address">Morada</label>
                        <input class="form-control p-2" type="text" id="address" name="address" required />
                    </div>
                    <div>
                        <label class="form-label" for="city">Cidade</label>
                        <input class="form-control p-2" type="text" id="city" name="city" required />
                    </div>
                    <div>
                        <label class="form-label" for="phone">Telefone</label>
                        <input class="form-control p-2" type="text" id="phone" name="phone" />
                    </div>
                    <div class="d-flex gap-2 mx-auto">
                        <button class="btn btn-primary btn-lg px-4 py-2" type="submit">Registar</button>
                        <a class="btn btn-secondary btn-lg px-4 py-2" href="?a=index">Retornar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
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