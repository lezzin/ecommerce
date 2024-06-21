<div class="container mb-5">
    <section>
        <h3 class="h4 mt-4">Carrinho</h3>

        <div class="card card-body mt-5">
            <?php if ($cart) : ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Preço unitário</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart as $cartItem) : ?>
                                <tr>
                                    <td>
                                        <div class="d-flex gap-2 align-items-center">
                                            <div class="ratio ratio-1x1" style="width: 3rem;">
                                                <img src="<?= base_url("public/upload/{$cartItem->product_image_url}") ?>" alt="Imagem do produto" class="object-fit-cover img-fluid rounded border">
                                            </div>
                                            <div>
                                                <p class="m-0 text-nowrap"><?= $cartItem->name ?></p>
                                                <p class="m-0 text-muted" style="font-size: .9rem;"><?= $cartItem->size ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <form action="<?= base_url("cart/actions/update_quantity") ?>" id="form-increase-<?= $cartItem->cart_id ?>" method="post">
                                            <input type="hidden" name="cart_id" value="<?= $cartItem->cart_id ?>">
                                            <input type="hidden" name="action" value="increase">
                                        </form>

                                        <form action="<?= base_url("cart/actions/update_quantity") ?>" id="form-decrease-<?= $cartItem->cart_id ?>" method="post">
                                            <input type="hidden" name="cart_id" value="<?= $cartItem->cart_id ?>">
                                            <input type="hidden" name="action" value="decrease">
                                        </form>

                                        <div class="input-group flex-nowrap">
                                            <button title="Remover 1 produto" type="submit" class="btn btn-light border" form="form-decrease-<?= $cartItem->cart_id ?>">
                                                <i class="bi bi-arrow-left"></i>
                                            </button>
                                            <span class="input-group-text px-3"><?= $cartItem->quantity ?></span>
                                            <button title="Adicionar 1 produto" type="submit" class="btn btn-light border" form="form-increase-<?= $cartItem->cart_id ?>">
                                                <i class="bi bi-arrow-right"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td><?= format_currency($cartItem->price)  ?></td>
                                    <td><?= format_currency($cartItem->price * $cartItem->quantity) ?></td>
                                    <td>
                                        <a href="<?= base_url("cart/actions/delete/{$cartItem->cart_id}") ?>" role="button" class="btn btn-sm btn-danger" title="Remover produto do carrinho">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            <tr>
                                <td colspan="5">
                                    <form>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h3 class="h5 m-0 text-nowrap">Total da compra: <?= format_currency($total) ?></h3>
                                            <button type="submit" class="btn btn-primary" title="Concluir compra">Concluir compra</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php else : ?>
                <div class="alert alert-info m-0">
                    <p class="m-0"><i class="bi bi-exclamation-circle"></i> Nenhum produto cadastrado no carrinho</p>
                </div>
            <?php endif ?>
        </div>
    </section>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3" id="toast-container"></div>

<script src="<?= base_url("public/js/cart/home.js") ?>" defer type="module"></script>