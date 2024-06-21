    <footer class="bg-light pt-5 pb-2" style="margin-top: 8rem">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12">
                    <h4 class="h6 mb-3 text-uppercase">Políticas</h4>
                    <ul class="list-unstyled mb-0">
                        <li><a title="Acessar página de Política de Privacidade" href="<?= base_url("politica-privacidade") ?>" class="link-dark py-1 text-decoration-none">Política de Privacidade</a></li>
                        <li><a title="Acessar página de Trocas e Devolução" href="<?= base_url() ?>" class="link-dark py-1 text-decoration-none">Trocas e Devolução</a></li>
                        <li><a title="Acessar página de Termos de serviço" href="<?= base_url() ?>" class="link-dark py-1 text-decoration-none">Termos de serviço</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-12 mt-md-0 mt-5">
                    <h4 class="h6 mb-3 text-uppercase">Menu principal</h4>
                    <ul class="list-unstyled mb-0">
                        <li>
                            <a title="Acessar página inicial" href="<?= base_url() ?>" class="link-dark py-1 text-decoration-none">Início</a>
                        </li>
                        <?php foreach ($categories as $category) : ?>
                            <li>
                                <a title="Acssar categoria" href="<?= base_url("category/" . url_format($category->name)) ?>" class="link-dark py-1 text-decoration-none"><?= $category->name ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="col-md-4 col-12 mt-md-0 mt-5">
                    <h4 class="h6 mb-3 text-uppercase">Atendimento</h4>
                    <p class="m-0">Não achou nenhum produto de seu interesse? Entre em contato:</p>
                    <ul class="list-unstyled mb-0 mt-1">
                        <li><i class="bi bi-envelope"></i> loja_qualquer@gmail.com</li>
                        <li><i class="bi bi-whatsapp"></i> (35) 99999-9999</li>
                        <li><i class="bi bi-instagram"></i> @nome_da_loja</li>
                    </ul>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center" style="margin-top: 4rem; font-size: .9rem">
                <a title="Acessar Instagram da loja" class="link-dark text-decoration-none" href="https://instagram.com"><i class="bi bi-instagram"></i> Siga-nos no Instagram</a>

                <p class="m-0">&copy; <?= PAGE_TITLE ?></p>
            </div>
        </div>
    </footer>
</main>
</body>

</html>