import { showMessage, BASE_URL } from "../script.js";

async function fetchData(endpoint) {
    try {
        return await $.get(`${BASE_URL}${endpoint}`);
    } catch (error) {
        showMessage("Requisição: erro ao realizar requisição");
        return [];
    }
}

async function getCategories() {
    return await fetchData("category/actions/all");
}

async function getCategory(id) {
    return await fetchData(`category/actions/get/${id}`);
}

async function getProducts() {
    return await fetchData("product/actions/all");
}
async function getLastProduct() {
    return await fetchData(`product/actions/get_last`);
}

async function getProductStocks(id) {
    return await fetchData(`stock/actions/all/${id}`);
}

async function getLastProductStock() {
    return await fetchData(`stock/actions/get_last`);
}

function initSidebarToggler() {
    const sidebar = $("#admin-sidebar");
    const toggler = $("#admin-sidebar-toggler");

    toggler.on("click", function () {
        sidebar.toggleClass("active");
        toggler.toggleClass("active");
    });
}

export {
    getCategory,
    getCategories,
    getLastProduct,
    getProducts,
    getLastProductStock,
    getProductStocks,
    initSidebarToggler
};
