<div class="container mb-5">
    <?php if (sizeof($product->stocks) >= 1) : ?>
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card card-body">
                    <?php if ($product->secondaryImages) : ?>
                        <div class="row">
                            <div class="col-md-2 order-2 order-md-1 mt-md-0 mt-2">
                                <div class="d-flex flex-wrap gap-1" data-secondary-images>
                                    <?php if ($product->secondaryImages) :  ?>
                                        <?php foreach ($product->secondaryImages as $image) :  ?>
                                            <button type="button" class="btn btn-light border p-1" title="Visualizar imagem do produto">
                                                <div class="ratio ratio-1x1" style="width: 4rem;">
                                                    <img src="<?= base_url("public/upload/{$image->url}") ?>" alt="Imagem do produto" class="object-fit-cover img-fluid rounded">
                                                </div>
                                            </button>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-md-10 order-1 order-md-2">
                                <div class="ratio ratio-1x1 text-center">
                                    <img src="<?= base_url("public/upload/{$product->primaryImage->url}") ?>" alt="Imagem do produto" class="object-fit-cover img-fluid rounded border" data-primary-image>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="ratio ratio-1x1 text-center">
                            <img src="<?= base_url("public/upload/{$product->primaryImage->url}") ?>" alt="Imagem do produto" class="object-fit-cover img-fluid rounded border" data-primary-image>
                        </div>
                    <?php endif ?>
                </div>

                <div class="card card-body mt-2">
                    <p class="m-0"><?= $product->description ?></p>
                </div>
            </div>
            <div class="col-md-6 col-12 mt-2 mt-md-0">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h3"><?= $product->name ?></h2>
                        <h3 class="h4"><?= format_currency($product->price) ?></h3>

                        <form class="my-4" action="<?= base_url("/cart/actions/save") ?>" method="post" id="add-cart-form">
                            <input type="hidden" name="product_id" value="<?= $product->product_id ?>">

                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group" data-size-group>
                                        <label>Tamanho</label>

                                        <select name="size" id="product-size" class="form-select">
                                            <?php foreach ($product->stocks as $stock) : ?>
                                                <option data-quantity="<?= $stock->quantity ?>"><?= $stock->size ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12 mt-md-0 mt-2">
                                    <div class="form-group">
                                        <label for="product-quantity">Quantidade</label>
                                        <select name="quantity" id="product-quantity" class="form-select" required></select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer bg-white">
                        <?php if (session()->has("user")) : ?>
                            <?php if (session("user")->user_type != "admin") : ?>
                                <button type="submit" form="add-cart-form" id="add-cart-btn" class="btn btn-primary w-100 d-block text-center" title="Adicionar produto ao carrinho">Adicionar produto ao carrinho</button>
                            <?php else : ?>
                                <div class="alert alert-info mb-0 py-2 text-center">
                                    <p class="m-0"><i class="bi bi-exclamation-circle"></i> Você está logado como administrador</p>
                                </div>
                            <?php endif ?>
                        <?php else : ?>
                            <a class="btn btn-primary w-100 d-block text-center" href="<?= base_url("set_redirect" . "?session_redirect=category/" . url_format($product->category) . "/products/" . url_format($product->name) . "&redirect=auth/login") ?>">Fazer login para adicionar produto ao carrinho</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    <?php else : ?>
        <div class="d-flex justify-content-center flex-column align-items-center mt-5 pt-5">
            <p class="display-4">Oops!</p>
            <p class="display-6">Parece que estamos sem esse produto no momento.</p>
            <p class="fw-normal">Mas não se preocupe, estamos trabalhando nisso! Confira outros produtos enquanto isso.</p>
            <a href="<?= base_url(url_format("category/" .  $category->name)) ?>" class="link-primary mt-3">Voltar para a categoria</a>
        </div>
    <?php endif ?>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>

<script src="<?= base_url("public/js/category/product.js") ?>" defer type="module"></script>