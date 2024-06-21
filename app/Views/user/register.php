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
    <div class="form-page register">
        <div class="image-container d-md-block d-none">
            <img src="<?= base_url("public/images/register-image.jpg") ?>" alt="Imagem de um adolescente com capuz">
        </div>

        <div class="card-container">
            <div class="card card-body shadow-sm">
                <div class="form-steps-details mb-2" style="display: none;">
                    <span class="step-ball">1</span>
                    <span class="step-line"></span>
                    <span class="step-ball">2</span>
                    <span class="step-line"></span>
                    <span class="step-ball">3</span>
                </div>

                <form class="row g-4" method="post" action="<?= base_url('auth/register') ?>" id="register-form">
                    <div class="form-step text-center h-100" id="step-1">
                        <p class="mb-4 text-primary"><small><?= PAGE_TITLE ?></small></p>
                        <h2 class="mb-2 mt-0">Registro</h2>
                        <p class="fw-normal">É bom te ver aqui!</p>
                        <p class="display-6 mt-5">Complete os 3 passos para criar sua conta.</p>
                        <button type="button" class="d-block mt-2 mb-4 mx-auto btn btn-outline-primary next-step">
                            <i class="bi bi-play"></i>
                            <span>Começar agora</span>
                        </button>
                    </div>

                    <div class="form-step" id="step-2" style="display: none;">
                        <h2 class="text-center mb-5">Informações pessoais</h2>

                        <div class="col-12">
                            <label for="username">Nome de usuário</label>
                            <div class="input-group">
                                <span class="input-group-text" id="username-prepend">@</span>
                                <input type="text" class="form-control" id="username" name="username" placeholder="joaozinho" required>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="full_name">Nome completo</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="João da Silva" required>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="phone_number">Telefone</label>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="(35) 99999-9999" required>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-secondary prev-step"><i class="bi bi-arrow-left-short"></i> Anterior</button>
                            <button type="button" class="btn btn-primary next-step" disabled>Próximo <i class="bi bi-arrow-right-short"></i></button>
                        </div>
                    </div>

                    <div class="form-step" id="step-3" style="display: none;">
                        <h2 class="text-center mb-5">Informações de login</h2>

                        <div class="col-12">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="joao@email.com" required>
                        </div>

                        <div class="col-12 mt-3">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-between gap-1">
                            <button type="button" class="btn btn-outline-secondary prev-step"><i class="bi bi-arrow-left-short"></i> Anterior</button>
                            <button type="button" class="btn btn-primary next-step" disabled>Próximo <i class="bi bi-arrow-right-short"></i> </button>
                        </div>
                    </div>

                    <div class="form-step" id="step-4" style="display: none;">
                        <h2 class="text-center mb-5">Informações de localidade</h2>

                        <div class="col-12">
                            <label for="address">Endereço</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Av. Centro" required>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12 col-md-8">
                                <label for="district">Bairro</label>
                                <input type="text" class="form-control" id="district" name="district" placeholder="Rua Centro" required>
                            </div>
                            <div class="col-md-4 col-12 mt-3 mt-md-0">
                                <label for="house_number">Número</label>
                                <input type="number" class="form-control" id="house_number" name="house_number" placeholder="1" required>
                            </div>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary prev-step"><i class="bi bi-arrow-left-short"></i> Anterior</button>
                            <button type="submit" class="btn btn-primary">Criar conta <i class="bi bi-check"></i></button>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <a href="<?= base_url('/auth/login') ?>" class="d-block w-100 text-center text-decoration-none link-primary" title="Fazer login em uma conta">Já tenho uma conta</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>
    <script src="<?= base_url("public/js/auth/register.js") ?>" type="module"></script>
</body>

</html>