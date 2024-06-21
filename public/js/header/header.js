import { BASE_URL, urlFormat, currencyFormat } from "../script.js";

const $searchForm = $("#search-product-form");
const $productsList = $searchForm.find(".list-group");

async function getProducts() {
    const value = urlFormat($searchForm.find("input").val());

    if (!value) return;

    $productsList.html('<div class="list-group-item text-center">Carregando...</div>');

    try {
        const products = await $.get(`${BASE_URL}product/actions/search/${value}`);

        if (products.length <= 0) {
            $productsList.html('<div class="list-group-item text-center">Nenhum produto encontrado</div>');
            return;
        }

        $productsList.empty();

        products.forEach(product => {
            const formattedPrice = currencyFormat(product.price);
            const productURL = `${BASE_URL}category/${urlFormat(product.category)}/products/${urlFormat(product.name)}`;

            $productsList.append(`
                <a class="list-group-item list-group-item-action" href="${productURL}" title="Acessar produto pesquisado">
                    <div class="d-flex gap-1 align-items-center">
                        <div class="ratio ratio-1x1" style="max-width: 40px">
                            <img class="rounded border" src="${BASE_URL}public/upload/${product.image}" alt="Imagem do produto">
                        </div>
                        <div>
                            <p class="m-0">${product.name}</p>
                            <p class="m-0 text-muted" style="font-size: .9rem;">${formattedPrice}</p>
                        </div>
                    </div>
                </a>`);
        });
    } catch (error) {
        $productsList.html('<div class="list-group-item text-center">Ocorreu um erro ao buscar os produtos</div>');
    }
}

$searchForm.on("submit", async function (e) {
    e.preventDefault();
    await getProducts();
});

$(document).on("click", function (e) {
    const productListIsNotClicked = !$(e.target).closest($productsList).length;

    if (productListIsNotClicked) {
        $productsList.empty();
    }
});