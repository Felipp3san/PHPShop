<script>
    $(document).ready(function() {
        $("#errorModal").modal('show');
        $("#successModal").modal('show');
    });
</script>
<div>
    <!-- ERRO -->
    <?php if (isset($_SESSION['error'])) : ?>
        <div id="errorModal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $_SESSION['error-title'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body align-items-center d-flex">
                        <p class="m-0"><?= $_SESSION['error'] ?>
                        <p>
                    </div>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['error-title']); ?>
        <?php unset($_SESSION['error']); ?>
        <!-- SUCESSO -->
    <?php elseif (isset($_SESSION['success'])) : ?>
        <div id="successModal" class="modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $_SESSION['success-title'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body align-items-center d-flex">
                        <p class="m-0"><?= $_SESSION['success'] ?>
                        <p>
                    </div>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['success-title']); ?>
        <?php unset($_SESSION['success']); ?>
    <?php endif ?>
</div>

<div class="container-fluid my-auto">
    <div class="d-flex justify-content-center">

        <!-- LOGIN -->
        <form action="?a=login" method="POST">
            <div id="login" class="card shadow-sm rounded-0">
                <div class="card-body p-5">
                    <h3 class="text-center">Login</h3>
                    <div class="d-flex flex-column h-100 justify-content-evenly">
                        <div class="d-grid gap-3">
                            <div class="form-floating">
                                <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="name@example.com" required />
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="" required />
                                <label for="password">Senha</label>
                            </div>
                            <div class="row">
                                <div class="col-7"></div>
                                <div class="col-5 overflow-hidden">
                                    <a class="btn btn-link text-truncate fs-5" href="?a=forgot_password">Esqueceu a senha?</a>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Iniciar Sessão</button>
                            <button class="btn btn-transparent rounded-0 btn-lg px-4 py-2" type="button" onclick="showRegister()">Criar conta</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- REGISTO -->
        <form action="?a=register" method="POST">
            <div id="register" class="card shadow-sm rounded-0 visibility-hidden">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Registo</h3>
                    <div class="d-flex flex-column gap-3">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-0" id="full-name" name="full-name" placeholder="" required />
                            <label for="email">Nome</label>
                        </div>
                        <div class="form-floating">
                            <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="" required />
                            <label for="email">Email</label>
                        </div>
                        <div class="d-flex flex-nowrap row overflow-hidden">
                            <div class="col-6">
                                <div class="form-floating overflow-hidden">
                                    <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="" required />
                                    <label for="password">Senha</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating overflow-hidden">
                                    <input type="password" class="form-control rounded-0" id="confirm-password" name="confirm-password" placeholder="" required />
                                    <label for="password">Confirmar senha</label>
                                </div>
                                <span id="passwordHelpInline" class="form-text text-end text-truncate text-nowrap">
                                    A senha deve possuir entre 8 e 20 caracteres.
                                </span>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Registar</button>
                            <button class="btn btn-transparent rounded-0 btn-lg px-4 py-2" type="button" onclick="showLogin()">Retornar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<script>

    const registerDiv = document.getElementById("register");
    const loginDiv = document.getElementById("login");

    function showRegister() {
        registerDiv.classList.remove("visibility-hidden");
        loginDiv.style.width = "0px"
        registerDiv.style.width = "700px"
        loginDiv.classList.add("visibility-hidden");
    }

    function showLogin() {
        loginDiv.classList.remove("visibility-hidden");
        registerDiv.style.width = "0px"
        loginDiv.style.width = "600px"
        registerDiv.classList.add("visibility-hidden");
    }

    <?php
        if(isset($_SESSION['previous-action']) && $_SESSION['previous-action'] == 'register'){
            echo 'showRegister()';
        } elseif (isset($_SESSION['previous-action']) && $_SESSION['previous-action'] == 'login'){
            echo 'showLogin()';
        }
    ?>

</script>