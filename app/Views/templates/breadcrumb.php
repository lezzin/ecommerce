<div class="container pt-3 pb-1 fw-normal">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><small><a href="<?= base_url() ?>" title="Acessar página inicial">Início</a></small></li>
            <?php foreach ($breadcrumbLinks as $link) :  ?>
                <?php if ($link["active"]) : ?>
                    <li class="breadcrumb-item" aria-current="page"><small><?= $link["name"] ?></small></li>
                <?php else : ?>
                    <li class="breadcrumb-item"><a title="Acessar página" href="<?= url_format(base_url($link["url"])) ?>"><small><?= $link["name"] ?></small></a></li>
                <?php endif; ?>
            <?php endforeach ?>
        </ol>
    </nav>
</div>