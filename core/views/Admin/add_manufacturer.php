<div class="container my-5">
    <h2>Adicionar Fabricante</h2>
    <?php if (isset($_SESSION['error'])) : ?>
        <div class="alert alert-danger mb-3 p-3 text-center" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif ?>
    <?php if (isset($_SESSION['success'])) : ?>
        <div class="alert alert-success mb-3 p-3 text-center" role="alert">
            <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif ?>
    <form action="?a=add_manufacturer" method="POST">
        <div class="d-flex flex-column gap-3 mt-5">
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control rounded-0" id="nome" name="nome" required>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary rounded-0">Adicionar Fabricante</button>
                <a class="btn btn-secondary rounded-0" href="?a=management_panel">Retornar</a>
            </div>
        </div>
    </form>
</div>