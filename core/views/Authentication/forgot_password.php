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

        <!-- RECUPERAR ACESSO -->
        <form action="?a=forgot_password" method="POST">
            <div id="recovery" class="card shadow-sm rounded-0">
                <div class="card-body p-5">
                    <div class="d-flex flex-column gap-3">
                        <h3 class="text-center">Recuperar acesso</h3>
                        <div class="d-grid">
                            <p class="text-center">Informe o email associado a conta</p>
                            <div class="form-floating">
                                    <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="name@example.com" required />
                                    <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button class="btn btn-primary rounded-0 btn-lg px-4 py-2" type="submit">Enviar email</button>
                            <a class="btn btn-transparent rounded-0 btn-lg px-4 py-2" href="?a=<?= $_SESSION['previous-action'] ?>">Retornar</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>