<div class="row p-0 m-0" id="products-container">
    <?php foreach ($products as $product) : ?>
        <a class="col-md-3 col-12 <?= (isset($page) && $page == "home") ? "p-1" : "p-0" ?> text-decoration-none" href="<?= base_url("category/" . url_format($product->category) . "/products/" . url_format($product->name)) ?>" title="Acessar produto">
            <div class="card <?= (isset($page) && $page == "home") ? "rounded" : "rounded-0" ?> border-primary-hover overflow-hidden">
                <div class="image-content ratio ratio-1x1 border-bottom">
                    <img src="<?= base_url("public/upload/{$product->image}") ?>" alt="<?= $product->name ?>" class="object-fit-cover img-fluid">
                </div>

                <div class="card-body py-2">
                    <p class="name link-primary m-0 text-truncate text-nowrap" style="max-width: 100%"><?= $product->name ?></p>
                    <p class="price link-primary m-0 fw-bold fs-5"><?= format_currency($product->price) ?></p>
                </div>
            </div>
        </a>
    <?php endforeach ?>
</div>