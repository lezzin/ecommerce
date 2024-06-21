<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" id="admin-sidebar">
    <a href="<?= base_url() ?>" class="link-dark text-decoration-none">
        <?= PAGE_TITLE ?>
    </a>
    
    <hr>
    
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?= base_url("admin") ?>" class="nav-link <?= $current == "home" ? "active" : "" ?>">
                <i class="bi bi-graph-up"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url("admin/category") ?>" class="nav-link <?= $current == "category" ? "active" : "" ?>">
                <i class="bi bi-list"></i>
                Categorias
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url("admin/product") ?>" class="nav-link <?= $current == "product" ? "active" : "" ?>">
                <i class="bi bi-bag"></i>
                Produtos
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= base_url("admin/customs") ?>" class="nav-link <?= $current == "customs" ? "active" : "" ?>">
                <i class="bi bi-gear"></i>
                Configurações
            </a>
        </li>
    </ul>

    <hr>

    <div class="btn-group w-100">
        <a class="btn btn-primary" href="<?= base_url() ?>" role="button">
            <i class="bi bi-house"></i> Página inicial
        </a>

        <a class="btn btn-danger" href="<?= base_url("auth/logout") ?>" role="button">
            <i class="bi bi-box-arrow-left"></i> Sair
        </a>
    </div>
</div>