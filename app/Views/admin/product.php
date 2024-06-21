<!DOCTYPE html>
<html lang="pt-br">

<?= view("admin/templates/head", ["title" => $title]) ?>

<body data-url="<?= base_url() ?>">
    <div class="d-flex min-vh-100 overflow-x-hidden">
        <?= view("admin/templates/sidebar", ["current" => "product"]) ?>

        <div class="container pt-3 pb-5 admin-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-dark" type="button" id="admin-sidebar-toggler" title="Abrir/fechar menu lateral">
                        <i class="bi bi-arrow-left"></i>
                    </button>
                    <h1 class="h3 m-0">Gerenciar produtos</h1>
                </div>

                <button title="Abrir janela de adição" type="button" data-bs-toggle="modal" data-bs-target="#modal-add-product" class="btn btn-primary">
                    Adicionar
                </button>
            </div>

            <div class="card card-body mt-3">
                <div class="table-responsive">
                    <table class="table table-sm table-hover" id="products-table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Preço</th>
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
                                        <span class="placeholder col-4"></span>
                                    </p>
                                </td>
                                <td>
                                    <p class="m-1 placeholder-glow">
                                        <span class="placeholder col-2"></span>
                                    </p>
                                </td>
                                <td>
                                    <p class="m-1 placeholder-glow">
                                        <span class="placeholder col-2"></span>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-add-product" tabindex="-1" aria-labelledby="modal-add-product-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="h5 modal-title" id="modal-add-product-label">Adicionar produto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="<?= base_url("product/actions/save") ?>" id="add-product-form" enctype="multipart/form-data">
                        <div class="form-group mb-3">
                            <label for="product-category">Categoria</label>
                            <select name="category" data-product-category class="form-select" required>
                                <option>Carregando...</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="product-name">Nome</label>
                            <input type="text" name="name" id="product-name" class="form-control" placeholder="Camisa masculina básica" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="product-price">Preço</label>
                            <input type="text" name="price" id="product-price" class="form-control" placeholder="R$0,00" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="product-description">Descrição</label>
                            <textarea name="description" id="product-description" class="form-control" placeholder="Camisa masculina de algodão e gola alta" rows="3"></textarea>
                        </div>

                        <div class="border rounded p-3 mb-3">
                            <div class="form-group mb-3">
                                <label for="product-image-quantity">Quantidade de imagens</label>
                                <select id="product-image-quantity" aria-labelledby="#product-image-label" class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>

                            <div id="product-images-container">
                                <div class="form-group mb-1">
                                    <label for="product-image-1">Imagem 1</label>
                                    <input type="file" name="image[]" id="product-image-1" class="form-control" required>
                                </div>
                            </div>

                            <span class="form-text" id="product-image-label">* A primeira imagem será a principal</span>
                        </div>

                        <button class="btn btn-primary" type="submit">Adicionar produto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-product" tabindex="-1" aria-labelledby="modal-edit-product-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="h5 modal-title" id="modal-edit-product-label">Editar produto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img class="img-fluid mb-3 mx-auto border rounded p-1" alt="Imagem do produto" id="product-primary-image">

                    <div class="d-flex gap-1 flex-wrap mb-3" id="product-secondary-images"></div>

                    <form method="post" action="<?= base_url("product/actions/save") ?>" enctype="multipart/form-data" id="product-edit-form">
                        <input type="hidden" name="id" id="edit-product-id">

                        <div class="form-group mb-3">
                            <label for="edit-product-category">Categoria</label>
                            <select name="category" id="edit-product-category" data-product-category class="form-select" required>
                                <option>Carregando...</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-product-name">Nome</label>
                            <input type="text" name="name" id="edit-product-name" class="form-control" placeholder="Camisa masculina básica" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-product-price">Preço</label>
                            <input type="text" name="price" id="edit-product-price" class="form-control" placeholder="R$0,00" requiredautocomplete="off">
                        </div>

                        <div class="form-group mb-3">
                            <label for="edit-product-description">Descrição</label>
                            <textarea name="description" id="edit-product-description" class="form-control" placeholder="Camisa masculina de algodão e gola alta" rows="3"></textarea>
                        </div>

                        <button class="btn btn-primary" type="submit">Concluir edição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="stock-modal" tabindex="-1" aria-labelledby="stock-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="h5 modal-title" id="stock-modal-label">Estoque do produto</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tamanho</th>
                                    <th>Quantidade</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="stock-table"></tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-1 flex-wrap mb-3" id="product-secondary-images"></div>

                    <form method="post" action="<?= base_url("stock/actions/save") ?>" id="product-add-stock">
                        <h2 class="h3">Adicionar ao estoque</h2>

                        <input type="hidden" name="product_id" id="stock-product-id">

                        <div class="form-group mb-3">
                            <label for="size">Tamanho</label>
                            <select name="size" id="size" class="form-select" required>
                                <option value="P">P</option>
                                <option value="M">M</option>
                                <option value="G">G</option>
                                <option value="GG">GG</option>
                            </select>
                            <div class="invalid-feedback">
                                Insira o tamanho do produto!
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="quantity">Quantidade</label>
                            <input type="number" name="quantity" id="quantity" placeholder="1" class="form-control" required>
                        </div>

                        <button class="btn btn-primary" type="submit">Adicionar ao estoque</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>

    <script src="<?= base_url("public/js/admin/product.js") ?>" defer type="module"></script>
</body>

</html>