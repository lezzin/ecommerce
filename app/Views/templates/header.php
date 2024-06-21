<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url("public/css/style.css") ?>">

    <script src="<?= base_url("public/bootstrap/js/jquery.min.js") ?>" defer></script>
    <script src="<?= base_url("public/bootstrap/js/bootstrap.js") ?>" defer></script>
    <script src="<?= base_url("public/js/header/header.js") ?>" defer type="module"></script>

    <link rel="shortcut icon" href="<?= base_url("public/favicon.ico") ?>" type="image/x-icon">

    <title><?= $title ?></title>
</head>

<body data-url="<?= base_url() ?>">
    <header>
        <?php if ($config && $config->top_message) : ?>
            <div class="text-bg-primary py-1 text-center text-uppercase">
                <p class="m-0"><?= $config->top_message ?></p>
            </div>
        <?php endif ?>

        <nav class="navbar navbar-expand-lg bg-dark py-3">
            <div class="container mx-auto">
                <a class="navbar-brand link-light" href="<?= base_url() ?>" title="Página inicial"><?= PAGE_TITLE ?></a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#header-navbar" aria-controls="header-navbar" aria-expanded="false" aria-label="Mudar menu de navegação" data-bs-theme="dark" title="Mudar menu de navegação">
                    <span class="navbar-toggler-icon text-light"></span>
                </button>

                <div class="collapse navbar-collapse" id="header-navbar">
                    <form class="d-flex w-100 mx-auto position-relative mt-md-0 mt-2" role="search" id="search-product-form" style="max-width: 600px">
                        <div class="input-group">
                            <input class="form-control" type="search" placeholder="Pesquisar por produto..." aria-label="Search" required>
                            <button class="btn btn-primary" type="submit" title="Pesquisar por produto"><i class="bi bi-search"></i></button>
                        </div>

                        <div class="position-absolute top-100 w-100 mt-1" style="z-index: 999;">
                            <div class="list-group overflow-y-auto" style="max-height: 60vh;"></div>
                        </div>
                    </form>

                    <ul class="navbar-nav mb-2 mb-lg-0 mt-md-0 mt-2">
                        <?php if (!session()->has("user")) : ?>

                            <li class="nav-item">
                                <a class="btn btn-primary" href="<?= base_url("auth/login") ?>" role="button" title="Criar nova conta/fazer login">
                                    <i class="bi bi-box-arrow-right"></i>
                                </a>
                            </li>

                        <?php else : ?>

                            <?php if (session()->get("user")->user_type == "customer") : ?>
                                <li class="nav-item">
                                    <button class="position-relative btn btn-secondary d-block w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" id="cart-button" title="Abrir menu do carrinho">
                                        <i class="bi bi-cart"></i>
                                        <span class="position-absolute badge rounded-pill bg-danger" style="top: -1px; right: -1px"></span>
                                    </button>
                                </li>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a class="btn btn-primary d-block w-100" href="<?= base_url("admin") ?>" role="button" title="Acessar página de administração">
                                        Administração
                                    </a>
                                </li>
                            <?php endif ?>

                            <li class="nav-item mt-2 mt-md-0 ms-0 ms-md-2">
                                <a class="btn btn-danger d-block w-100" href="<?= base_url("auth/logout") ?>" role="button" title="Sair da conta">
                                    <i class="bi bi-box-arrow-left"></i>
                                    <span class="d-md-none">Sair</span>
                                </a>
                            </li>

                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="cartOffcanvasLabel">Carrinho</h5>
            <button type="button" class="btn-close text-light" data-bs-dismiss="offcanvas" aria-label="Close" title="Fechar menu de carrinho"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="list-group"></ul>
            <a class="btn btn-dark mt-3 d-block w-100" role="button" href="<?= base_url("cart") ?>" title="Acessar página do carrinho">Acessar carrinho</a>
        </div>
    </div>

    <main>