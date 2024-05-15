<script>
    $(document).ready(function() {
        $("#errorModal").modal('show');
        $("#successModal").modal('show');
    });
</script>
<div>
    <!-- ERRO -->
    <?php if (isset($_SESSION['error'])) : ?>
        <div id="errorModal" class="modal modal-bg" tabindex="-1">
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
        <div id="successModal" class="modal modal-bg" tabindex="-1">
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