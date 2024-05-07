<script>
    $(document).ready(function() {
        $("#myModal").modal('show');
    });
</script>
<div class="container-fluid my-auto">
    <div>
        <?php if (isset($_SESSION['error'])) : ?>
            <div id="myModal" class="modal" tabindex="-1">
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
            <?php unset($_SESSION['error']); ?>
        <?php endif ?>
    </div>
    <div class="d-flex justify-content-center">
        <div id="login" class="card shadow-sm rounded-0">
            <div class="card-body p-5">
                <h3 class="text-center mb-5">Login</h3>
                <form action="?a=login" method="POST">
                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex flex-column gap-2">
                            <div class="form-floating mb-2">
                                <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="name@example.com" required />
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="" required />
                                <label for="password">Senha</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8"></div>
                            <div class="col-4 overflow-hidden">
                                <a class="btn btn-link text-truncate" href="?a=forgot_password">Esqueceu a senha?</a>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-5">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Login</button>
                            <button class="btn btn-transparent rounded-0 btn-lg px-4 py-2" type="button" onclick="showRegister()">Criar conta</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="register" class="card shadow-sm rounded-0 visibility-hidden">
            <div class="card-body p-5">
                <h3 class="text-center mb-4 text-clip">Registo</h3>
                <form action="?a=register" method="POST">
                    <div class="d-flex flex-column gap-3">
                        <div class="row d-flex flex-nowrap">
                            <div class="col-4 overflow-hidden">
                                <label for="full-name" class="col-form-label">Nome</label>
                            </div>
                            <div class="col-8 overflow-hidden">
                                <input type="text" id="full-name" name="full-name" class="form-control rounded-0" required>
                            </div>
                        </div>
                        <div class="row d-flex flex-nowrap">
                            <div class="col-4">
                                <label for="email" class="col-form-label">Email</label>
                            </div>
                            <div class="col-8 overflow-hidden">
                                <input type="email" id="email" name="email" class="form-control rounded-0" required>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row d-flex flex-nowrap">
                            <div class="col-4 overflow-hidden">
                                <label for="password" class="col-form-label">Senha</label>
                            </div>
                            <div class="col-8 overflow-hidden">
                                <input type="password" id="password" name="password" class="form-control rounded-0" required>
                            </div>
                        </div>
                        <div class="row d-flex flex-nowrap">
                            <div class="col-4 overflow-hidden">
                                <label for="confirm-password" class="col-form-label">Confirmar senha</label>
                            </div>
                            <div class="col-8 overflow-hidden">
                                <input type="password" id="confirm-password" name="confirm-password" class="form-control rounded-0" aria-describedby="passwordHelpInline" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6"></div>
                            <div class="col-6 overflow-hidden">
                                <span id="passwordHelpInline" class="form-text text-end text-truncate">
                                    A senha deve possuir entre 8 e 20 caracteres.
                                </span>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Registar</button>
                            <button class="btn btn-transparent rounded-0 btn-lg px-4 py-2" type="button" onclick="showLogin()">Retornar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
</script>