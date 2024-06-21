<?php if ($banner_url) : ?>
    <div class="home-banner overflow-hidden border-bottom" style="height: <?= ($config && $config->top_message) ? "76dvh" : "81dvh" ?>;">
        <img class="w-100 h-100 object-fit-cover" src="<?= base_url("public/upload/{$banner_url}") ?>" alt="Banner de promoções">
    </div>
<?php endif ?>