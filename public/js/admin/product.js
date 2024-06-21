import { showMessage, SPINNER_HTML, BASE_URL, currencyFormat } from "../script.js";
import { getProducts, getLastProduct, getCategories, getProductStocks, getLastProductStock, initSidebarToggler } from "./script.js";

const $table = $("#products-table");
const $tbody = $table.children("tbody");

const $stockTable = $("#stock-table");

const $addProductModal = new bootstrap.Modal("#modal-add-product");
const $editProductModal = new bootstrap.Modal("#modal-edit-product");

let productsCopy = [];
let fetchingData = false;

async function populateProductsTable() {
    if (fetchingData) return;
    fetchingData = true;

    try {
        const products = await getProducts();

        $tbody.empty();

        if (products.length < 1) {
            $tbody.append(`<tr><td colspan="5" class="text-center">Nenhum produto cadastrado</td></tr>`);
            return;
        }

        for (const product of products) {
            await appendProductRowToTable(product);
        }
    } catch (error) {
        showMessage("Requisição: erro ao buscar os produtos");
    } finally {
        fetchingData = false;
    }
}

async function appendProductRowToTable(product) {
    const { product_id } = product;
    const stocks = await getProductStocks(product_id);
    const isEmpty = stocks.length <= 0;

    const data = {
        ...product,
        is_empty: isEmpty,
        stocks: stocks
    }

    if (productsCopy.length === 0) {
        $tbody.empty();
    }

    productsCopy.push(data);
    await appendProductRow(data);
}

function createProductRow(product) {
    const { product_id, is_empty, primaryImage, name, price, description } = product;
    const formattedPrice = currencyFormat(price);

    const $tr = $(`
        <tr data-product-id="${product_id}">
            <td>
                <div class="d-flex align-items-center gap-2" style="max-width: 350px;">
                    <img src="${BASE_URL}public/upload/${primaryImage.url}" alt="${name}" class="img-thumbnail" style="max-width: 32px;">
                    <p class="m-0 text-truncate product-name">${name}${is_empty ? ` <span class="badge bg-danger text-white">Sem estoque</span>` : ""}</p>
                </div>
            </td>
            <td style="max-width:300px;"><p class="m-0 text-truncate product-description">${description}</p></td>
            <td class="product-price">${formattedPrice}</td>
            <td>
                <div class="btn-group">
                    <button title="Abrir janela de estoque" data-bs-toggle="modal" data-product-id="${product_id}" data-bs-target="#stock-modal" type="button" class="btn btn-sm btn-primary"><i class="bi bi-archive"></i></button>
                    <button title="Abrir janela de edição" data-bs-toggle="modal" data-product-id="${product_id}" data-bs-target="#modal-edit-product" type="button" class="btn btn-sm btn-success"><i class="bi bi-pen"></i></button>
                    <button title="Excluir produto" data-delete-product data-product-id="${product_id}" type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                </div>
            </td>
        </tr>`
    );

    return $tr;
}

async function appendProductRow(product) {
    const $tr = createProductRow(product);
    $tbody.append($tr);
}

async function populateProductModal(product) {
    const { product_id, category_id, primaryImage, secondaryImages, name, price, description } = product;

    $("#product-primary-image").attr("src", `${BASE_URL}public/upload/${primaryImage.url}`).attr("alt", name);
    $("#product-secondary-images").empty();

    if (secondaryImages.length > 0) {
        secondaryImages.forEach(image => {
            $("#product-secondary-images").append(
                `<div class="ratio ratio-1x1 p-2 bg-light" style="max-width: 72px">
                    <img src="${BASE_URL}public/upload/${image.url}" class="object-fit-cover img-fluid rounded border p-1" alt="${name}">
                </div>`
            );
        });
    }

    $("#edit-product-id").val(product_id);
    $("#edit-product-category").val(category_id);
    $("#edit-product-name").val(name);
    $("#edit-product-price").val(price);
    $("#edit-product-description").text(description);
}

async function populateStockModal(productId) {
    $stockTable.empty().append(`
        <tr>
            <td>
                <p class="m-1 placeholder-glow">
                    <span class="placeholder col-3"></span>
                </p>
            </td>
            <td>
                <p class="m-1 placeholder-glow">
                    <span class="placeholder col-2"></span>
                </p>
            </td>
            <td>
                <p class="m-1 placeholder-glow">
                    <span class="placeholder col-4"></span>
                </p>
            </td>
        </tr>
        `);

    $("#stock-product-id").val(productId);

    try {
        const stocks = productsCopy.find(product => product.product_id == productId)?.stocks || [];
        $stockTable.empty();

        if (stocks.length <= 0) {
            $stockTable.append(`<tr><td colspan="3" class="text-center">Produto sem estoque</td></tr>`);
            return;
        }

        stocks.forEach(stock => {
            const { product_stock_id, product_id, size, quantity } = stock;
            $stockTable.append(`
                <tr>
                    <td>${size}</td>
                    <td>${quantity}</td>
                    <td><button title="Excluir estoque" type="button" class="btn btn-sm btn-danger delete-stock" data-product-id="${product_id}" data-stock-id="${product_stock_id}"><i class="bi bi-trash"></i></button></td>
                </tr>`
            );
        });
    } catch (error) {
        showMessage("Requisição: erro ao buscar estoque do produto");
    }
}

function attachProductEvents() {
    $tbody.off("click", "[data-delete-product]").on("click", "[data-delete-product]", function () {
        const productId = $(this).data("product-id");
        deleteProduct(productId);
    });

    $tbody.off("click", "[data-bs-target=\"#stock-modal\"]").on("click", "[data-bs-target=\"#stock-modal\"]", function () {
        const productId = $(this).data("product-id");
        populateStockModal(productId);
    });

    $tbody.off("click", "[data-bs-target=\"#modal-edit-product\"]").on("click", "[data-bs-target=\"#modal-edit-product\"]", function () {
        const productId = $(this).data("product-id");
        const selectedProduct = productsCopy.find(product => product.product_id == productId);
        populateProductModal(selectedProduct);
    });

    $stockTable.off("click", ".delete-stock").on("click", ".delete-stock", function () {
        const stockId = $(this).data("stock-id");
        const productId = $(this).data("product-id");

        deleteStock(productId, stockId);
    });
}

async function populateCategoriesSelect() {
    try {
        const categories = await getCategories();
        const productCategory = $("[data-product-category]");

        productCategory.empty();

        categories.forEach(category => {
            productCategory.append(`<option value="${category.category_id}">${category.name}</option>`);
        });
    } catch (error) {
        showMessage("Requisição: erro ao buscar as categorias");
    }
}

async function deleteProduct(productId) {
    if (!confirm("Realmente deseja deletar esse produto?")) return;

    try {
        const response = await $.ajax({
            url: `${BASE_URL}product/actions/delete/${productId}`,
            type: "GET",
        });

        showMessage(response.message);

        if (response.status == "success") {
            productsCopy = productsCopy.filter(product => product.product_id != productId);
            const $productRow = $tbody.find(`[data-product-id="${productId}"]`);
            $productRow.remove();
        }

        if (productsCopy.length < 1) {
            $tbody.append(`<tr><td colspan="5" class="text-center">Nenhum produto cadastrado</td></tr>`);
            return;
        }
    } catch (error) {
        showMessage("Requisição: erro ao deletar produto");
    }
}

async function deleteStock(productId, stockId) {
    if (!confirm("Realmente deseja deletar esse estoque?")) return;

    try {
        const response = await $.ajax({
            url: `${BASE_URL}stock/actions/delete/${stockId}`,
            type: "GET",
        });

        showMessage(response.message);

        if (response.status == "success") {
            const currentProduct = productsCopy.find(product => product.product_id == productId);
            if (currentProduct) {
                currentProduct.stocks = currentProduct.stocks.filter(stock => stock.product_stock_id != stockId);
                populateStockModal(productId);

                if (currentProduct.stocks.length === 0) {
                    const $productName = $tbody.find(`[data-product-id="${productId}"] .product-name`);
                    $productName.append(' <span class="badge bg-danger text-white">Sem estoque</span>');
                }
            }
        }
    } catch (error) {
        showMessage("Requisição: erro ao excluir estoque");
    }
}

async function updateProductInTable(productData) {
    const { id, name, description, price } = productData;
    const formattedPrice = currencyFormat(price);

    const { length } = await getProductStocks(id);
    const isEmpty = length <= 0;

    const productToUpdate = productsCopy.find(product => product.product_id == id);
    if (productToUpdate) {
        productToUpdate.name = `${name}${isEmpty ? ` <span class="badge bg-danger text-white">Sem estoque</span>` : ""}`;
        productToUpdate.description = description;
        productToUpdate.price = price;
    }

    const $productRow = $tbody.find(`[data-product-id="${id}"]`);

    $productRow.find('.product-name').text(name);
    $productRow.find('.product-description').text(description);
    $productRow.find('.product-price').text(formattedPrice);
}

async function handleEditFormSuccess(formData) {
    const productData = Object.fromEntries(formData.entries());
    await updateProductInTable(productData);
    $editProductModal.hide();
}

async function handleAddStockFormSuccess(formData) {
    const productId = formData.get("product_id");
    const stock = await getLastProductStock();
    const stocks = productsCopy.find(product => product.product_id == productId)?.stocks || [];

    const stockSizeAlreadyExists = stocks.find(s => s.size === formData.get("size"));
    const $productRow = $tbody.find(`[data-product-id="${productId}"]`);

    if (stocks.length === 0) {
        $productRow.find('.product-name span').remove();
    }

    if (stockSizeAlreadyExists) {
        stockSizeAlreadyExists.quantity = parseInt(formData.get("quantity")) + parseInt(stockSizeAlreadyExists.quantity);
    } else {
        stocks.push(stock);
    }

    populateStockModal(productId);
}

async function handleAddProductFormSuccess() {
    $addProductModal.hide();
    $("#product-images-container").empty().append(`
        <div class="form-group mb-2">
            <label for="product-image-1">Imagem 1</label>
            <input type="file" name="image[]" id="product-image-1" class="form-control" required>
            <div class="invalid-feedback">Insira a imagem 1!</div>
        </div>`);

    const product = await getLastProduct();
    appendProductRowToTable(product);
}

function handleForm($form, formData, status) {
    if (status == "success") $form.trigger("reset");

    if ($form.is("#product-edit-form")) {
        if (status == "success") handleEditFormSuccess(formData);
        $form.find("button").text("Concluir edição");
        return;
    }

    if ($form.is("#product-add-stock")) {
        if (status == "success") handleAddStockFormSuccess(formData);
        $form.find("button").text("Adicionar estoque");
        return;
    }

    if ($form.is("#add-product-form")) {
        if (status == "success") handleAddProductFormSuccess();
        $form.find("button").text("Adicionar produto");
        return;
    }
}

$("#add-product-form, #product-edit-form, #product-add-stock").submit(async function (e) {
    e.preventDefault();

    const $form = $(this);
    const formData = new FormData($form[0]);
    const action = $form.attr("action");

    $form.find('button').html(`${SPINNER_HTML} Carregando...`);

    try {
        const response = await $.ajax({
            url: action,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
        });

        showMessage(response.message);

        handleForm($form, formData, response.status);
    } catch (error) {
        showMessage("Requisição: erro ao enviar dados do formulário");
        console.log(error);
    }
});

$("#product-image-quantity").on("change", function () {
    const $fileInputQuantity = $(this).val();
    const productImagesContainer = $("#product-images-container");
    productImagesContainer.empty();

    for (let index = 1; index <= $fileInputQuantity; index++) {
        const formGroupClass = index >= $fileInputQuantity ? "mb-1" : "mb-2";
        productImagesContainer.append(`
            <div class="form-group ${formGroupClass}">
                <label for="product-image-${index}">Imagem ${index}</label>
                <input type="file" name="image[]" id="product-image-${index}" class="form-control" required>
                <div class="invalid-feedback">Insira a imagem ${index}!</div>
            </div>`
        );
    }
});

populateCategoriesSelect();
populateProductsTable();
attachProductEvents();
initSidebarToggler();