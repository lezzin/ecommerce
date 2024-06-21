<!DOCTYPE html>
<html lang="pt-br">

<?= view("admin/templates/head", ["title" => $title]) ?>

<body data-url="<?= base_url() ?>">
    <div class="d-flex min-vh-100 overflow-x-hidden">
        <?= view("admin/templates/sidebar", ["current" => "category"]) ?>

        <div class="container pt-3 pb-5 admin-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-dark" type="button" id="admin-sidebar-toggler" title="Abrir/fechar menu lateral">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <h1 class="h3 m-0">Gerenciar categorias</h1>
                </div>

                <button title="Abrir janela de adição" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-category" class="btn btn-primary">
                    Adicionar
                </button>
            </div>

            <div class="card card-body mt-3">
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="categories-table">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Mais</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <p class="m-1 placeholder-glow">
                                        <span class="placeholder col-1"></span>
                                        <span class="placeholder col-3"></span>
                                    </p>
                                </td>
                                <td>
                                    <p class="m-1 placeholder-glow">
                                        <span class="placeholder col-1"></span>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal-add-category" tabindex="-1" aria-labelledby="add-category-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="h5 modal-title" id="add-category-modal-label">Adicionar categoria</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url("category/actions/save") ?>" id="category-form" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="category-name">Nome</label>
                            <input type="text" class="form-control" name="name" id="category-name" placeholder="Camisa, camiseta..." required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="category-image">Imagem</label>
                            <input type="file" class="form-control" name="image" id="category-image" required>
                            <small class="form-text">A imagem deve ser quadrada (proporção 1:1)</small>
                        </div>

                        <button class="btn btn-primary" type="submit">Adicionar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-category" tabindex="-1" aria-labelledby="edit-category-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="h5 modal-title" id="edit-category-modal-label">Editar categoria</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url("category/actions/save") ?>" id="category-edit-form" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="edit-category-id">
                        <input type="hidden" id="category-index">

                        <div class="form-group mb-3">
                            <label for="category-name">Nome</label>
                            <input type="text" class="form-control" name="name" id="edit-category-name" placeholder="Camisa, camiseta..." required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-category-image">Imagem</label>
                            <input type="file" class="form-control" name="image" id="edit-category-image">
                            <small class="form-text">A imagem deve ser quadrada (proporção 1:1)</small>
                        </div>

                        <button class="btn btn-primary" type="submit">Concluir edição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>
    <script src="<?= base_url("public/js/admin/category.js") ?>" defer type="module"></script>
</body>

</html>