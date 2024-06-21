<!DOCTYPE html>
<html lang="pt-br">

<?= view("admin/templates/head", ["title" => $title]) ?>

<body data-url="<?= base_url() ?>">
    <div class="d-flex min-vh-100 overflow-x-hidden">
        <?= view("admin/templates/sidebar", ["current" => "customs"]) ?>

        <div class="container pt-3 pb-5 admin-panel">
            <div class="d-flex align-items-center gap-2 mb-3">
                <button class="btn btn-outline-dark" type="button" id="admin-sidebar-toggler" title="Abrir/fechar menu lateral">
                    <i class="bi bi-arrow-left"></i>
                </button>
                <h1 class="h3 m-0">Gerenciar configurações</h1>
            </div>

            <div class="card card-body">
                <form action="<?= base_url("config/actions/save") ?>" method="post" id="form-add-message" data-add>
                    <h2 class="h4 mb-3">Mensagem superior da tela</h2>

                    <div class="form-group mb-3">
                        <label for="top-message">Descrição</label>
                        <input type="text" class="form-control" id="top-message" name="top_message" placeholder="Nova mensagem" required>
                    </div>
                </form>

                <form action="<?= base_url("config/actions/delete") ?>" id="form-remove-message" data-delete method="post">
                    <input type="hidden" name="id" data-config-id>
                    <input type="hidden" name="column" value="top_message">
                </form>

                <div class="d-flex gap-1">
                    <button type="submit" class="btn btn-primary" form="form-add-message">Alterar</button>
                    <button type="submit" class="btn btn-danger" form="form-remove-message" id="btn-delete-message" style="display: none;">Remover</button>
                </div>
            </div>

            <div class="card card-body mt-3">
                <form action="<?= base_url("config/actions/save") ?>" method="post" enctype="multipart/form-data" id="form-add-banner" data-add>
                    <h2 class="h4 mb-3">Banner da página principal</h2>

                    <div class="mb-3 ratio" id="banner-image-display" style="aspect-ratio: 16/7; display: none">
                        <img class="img-fluid rounded object-fit-cover" alt="Banner da página principal">
                    </div>

                    <div class="form-group mb-3">
                        <label for="banner-image">Imagem</label>
                        <input type="file" class="form-control" id="banner-image" name="banner_url" required>
                    </div>
                </form>

                <form action="<?= base_url("config/actions/delete") ?>" id="form-remove-banner" data-delete method="post">
                    <input type="hidden" name="id" data-config-id>
                    <input type="hidden" name="column" value="banner_url">
                </form>

                <div class="d-flex gap-1">
                    <button type="submit" class="btn btn-primary" form="form-add-banner">Alterar</button>
                    <button type="submit" class="btn btn-danger" form="form-remove-banner" id="btn-delete-banner" style="display: none;">Remover</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>
    <script src="<?= base_url("public/js/admin/customs.js") ?>" defer type="module"></script>
</body>

</html>