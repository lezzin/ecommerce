<!DOCTYPE html>
<html lang="pt-br">

<?= view("admin/templates/head", ["title" => $title]) ?>

<body>
    <div class="d-flex min-vh-100 overflow-x-hidden">
        <?= view("admin/templates/sidebar", ["current" => "home"]) ?>

        <div class="container pt-3 admin-panel">
            <div class="d-flex align-items-center gap-2 mb-3">
                <button class="btn btn-outline-dark" type="button" id="admin-sidebar-toggler" title="Abrir/fechar menu lateral">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <h1 class="h3 m-0">Dashboard</h1>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card card-body text-bg-success">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <p class="fs-5 m-0"><?= $categories_quantity ?></p>
                            <span class="display-4 opacity-25"><i class="bi bi-basket"></i> </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-md-0 mt-1">
                    <div class="card card-body text-bg-primary">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <p class="fs-5 m-0"><?= $products_quantity ?></p>
                            <span class="display-4 opacity-25"><i class="bi bi-basket"></i> </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mt-md-0 mt-1">
                    <div class="card card-body text-bg-info">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <p class="fs-5 m-0"><?= $users_quantity ?></p>
                            <span class="display-4 opacity-25"><i class="bi bi-people"></i> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url("public/js/admin/home.js") ?>" defer type="module"></script>
</body>

</html>