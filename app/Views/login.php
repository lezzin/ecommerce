<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?= base_url("public/bootstrap/css/bootstrap.css") ?>">
    <link rel="stylesheet" href="<?= base_url("public/bootstrap/icons/bootstrap-icons.css") ?>">
    <link rel="stylesheet" href="<?= base_url("public/css/style.css") ?>">

    <link rel="shortcut icon" href="<?= base_url("public/favicon.ico") ?>" type="image/x-icon">

    <script src="<?= base_url("public/bootstrap/js/jquery.min.js") ?>"></script>
    <script src="<?= base_url("public/bootstrap/js/bootstrap.js") ?>"></script>

    <title><?= $title ?></title>
</head>

<body class="bg-light">
    <div class="form-page">
        <div class="card-container">
            <div class="card card-body shadow-sm">
                <form class="row g-3" action="<?= base_url("auth/login") ?>" method="post" id="login-form">
                    <?php if (session()->getFlashdata("message")) : ?>
                        <div class="col-12">
                            <div class="alert alert-info">
                                <p class="m-0"><?= session()->getFlashdata("message") ?></p>
                            </div>
                        </div>
                    <?php endif ?>

                    <div class="text-center">
                        <p class="mb-4 text-primary"><small><?= PAGE_TITLE ?></small></p>
                        <h2 class="mb-2">Login</h2>
                        <p class="mb-4 fw-normal">Seja bem-vindo de volta!</p>
                    </div>

                    <div class="col-12">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="joao@email.com" autocomplete="email" required>
                    </div>

                    <div class="col-12">
                        <label for="password">Senha</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="d-block w-100 btn btn-primary" title="Entrar na conta">Entrar</button>
                        <a href="<?= base_url("auth/register") ?>" class="mt-2 d-block w-100 text-center text-decoration-none link-primary" title="Criar uma nova conta">Não possuo conta</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="image-container d-md-block d-none">
            <img src="<?= base_url("public/images/login-image.jpg") ?>" alt="Imagem de um adolescente com capuz">
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>
    <script src="<?= base_url("public/js/auth/login.js") ?>" type="module"></script>
</body>

</html>