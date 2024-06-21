import { updateCart } from "../script.js";

const $orderDropdown = $("#order-product-filter");
const $orderDisplay = $orderDropdown.find("[data-order-display]");
const $productContainer = $("#products-container");

$orderDropdown.on("click", ".dropdown-menu button", function () {
    const selectedOrder = $(this).data("order");
    updateOrderDisplay(selectedOrder, $(this).text());
    sortProducts(selectedOrder);
});

function updateOrderDisplay(order, text) {
    $orderDisplay.text(text);
    $orderDropdown.find(".active").removeClass("active");
    $(`[data-order="${order}"]`).addClass("active");
}

function sortProducts(order) {
    let sortedProducts;
    switch (order) {
        case "az":
            sortedProducts = sortAlphabetically(true);
            break;
        case "za":
            sortedProducts = sortAlphabetically(false);
            break;
        case "highestprice":
            sortedProducts = sortPrice(false);
            break;
        case "lowestprice":
            sortedProducts = sortPrice(true);
            break;
        default:
            return;
    }

    renderProducts(sortedProducts);
}

function sortAlphabetically(ascending) {
    const sorted = [...$productContainer.children()].sort((a, b) => {
        const nameA = $(a).find(".name").text().toUpperCase();
        const nameB = $(b).find(".name").text().toUpperCase();
        return ascending ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
    });
    return sorted;
}

function sortPrice(ascending) {
    const sorted = [...$productContainer.children()].sort((a, b) => {
        const priceA = parseFloat($(a).find(".price").text().replace(/[^\d.-]/g, ''));
        const priceB = parseFloat($(b).find(".price").text().replace(/[^\d.-]/g, ''));

        return ascending ? priceA - priceB : priceB - priceA;
    });
    return sorted;
}

function renderProducts(products) {
    $productContainer.empty().append(products);
}

updateCart();
