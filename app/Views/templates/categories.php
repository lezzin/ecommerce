<div class="container-fluid px-5 py-3 border-bottom">
    <nav class="d-flex gap-3 justify-content-center mx-auto">
        <a title="Acessar página inicial" href="<?= base_url() ?>" class="text-decoration-none">Página inicial</a>
        <?php foreach ($categories as $category) : ?>
            <a title="Acessar categoria" href="<?= base_url("category/" . url_format($category->name)) ?>" class="text-decoration-none"><?= ucfirst($category->name) ?></a>
        <?php endforeach ?>
    </nav>
</div>