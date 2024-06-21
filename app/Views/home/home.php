<?= view("templates/banner", ["banner_url" => $banner_url]) ?>

<div class="container mb-5">
    <?php if (!empty($categories)) : ?>

        <section>
            <h3 class="h4 mt-4">Categorias</h3>
            <div class="swiper swiper-slide-categories">
                <div class="swiper-wrapper">
                    <?php foreach ($categories as $category) : ?>
                        <a class="swiper-slide p-2 text-decoration-none" href="<?= base_url("category/" . url_format($category->name)) ?>" title="Acessar categoria">
                            <div class="border border-primary-hover rounded-circle overflow-hidden ratio ratio-1x1">
                                <img src="<?= base_url("public/upload/{$category->image}") ?>" alt="Imagem da categoria <?= strtolower($category->name) ?>" class="object-fit-cover img-fluid">
                            </div>

                            <p class="link-dark mt-2 mb-0 text-center"><?= $category->name ?></p>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </section>
        <?php if (!empty($products)) : ?>
            <section>
                <h3 class="h4 mt-4">Produtos recentes</h3>
                <?= view("templates/products_list", ["products" => $products, "page" => "home"]) ?>
            </section>
        <?php endif ?>

    <?php else : ?>

        <div class="d-flex justify-content-center flex-column align-items-center text-center mt-5 pt-5">
            <p class="display-4">Oops!</p>
            <p class="display-6">Parece que estamos sem produtos no momento.</p>
            <p class="fw-normal">Mas não se preocupe, estamos trabalhando nisso!</p>
        </div>

    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?= base_url("public/js/home/home.js") ?>" defer type="module"></script>