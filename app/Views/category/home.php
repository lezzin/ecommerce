<div class="container mb-5">
    <?php if (!empty($products)) : ?>
        <div class="card">
            <div class="border-bottom p-3">
                <div>
                    <h2><?= ucfirst($category->name) ?></h2>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-1 flex-wrap gap-2">
                    <p class="m-0">
                        <span>Mostrando <?= sizeof($products) ?> de <?= $pager->getTotal() ?> resultados</span>
                        <span>(página <?= $pager->getCurrentPage() ?> de <?= $pager->getPageCount() ?>)</span>
                    </p>

                    <div class="dropdown-center" id="order-product-filter">
                        <button class="btn border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Mostrar opções para ordenação de produtos">
                            Ordenar por: <span data-order-display>Ordem alfabética (A-Z)</span>
                        </button>
                        <ul class="dropdown-menu">
                            <li><button title="Ordenar produtos por ordem alfabética" type="button" class="dropdown-item active" data-order="az">Ordem alfabética (A-Z)</button></li>
                            <li><button title="Ordenar produtos por ordem alfabética" type="button" class="dropdown-item" data-order="za">Ordem alfabética (Z-A)</button></li>
                            <li><button title="Ordenar produtos por maior preço" type="button" class="dropdown-item" data-order="highestprice">Maior preço</button></li>
                            <li><button title="Ordenar produtos por menor preço" type="button" class="dropdown-item" data-order="lowestprice">Menor preço</button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="border-bottom p-3">
                <?= view("templates/products_list", ["products" => $products]) ?>
            </div>

            <div class="d-flex justify-content-center mt-3">
                <?= $pager->links('default', 'pager') ?>
            </div>

        </div>
    <?php else : ?>

        <p class="display-4">Oops!</p>
        <p class="display-6">Parece que estamos sem produtos no momento.</p>
        <p class="fw-normal">Mas não se preocupe, estamos trabalhando nisso! Confira outras categorias ou volte mais tarde.</p>
        <a href="<?= base_url() ?>" class="link-primary mt-5">Voltar para a página inicial</a>
        
    <?php endif ?>
</div>

<script src="<?= base_url("public/js/category/home.js") ?>" defer type="module"></script>