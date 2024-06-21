import { showMessage, BASE_URL, SPINNER_HTML } from "../script.js";
import { getCategories, getCategory, initSidebarToggler } from "./script.js";

const $table = $("#categories-table");
const $tbody = $table.find("tbody");
const $modalEditCategory = new bootstrap.Modal("#modal-edit-category");
const $modalAddCategory = new bootstrap.Modal("#modal-add-category");
const $formAddCategory = $("#category-form");
const $formEditCategory = $("#category-edit-form");

let categories = [];
let fetchingData = false;

async function populateCategoriesTable() {
    categories = await getCategories();

    if (fetchingData) return;
    fetchingData = true;

    try {
        $tbody.empty();

        if (categories.length < 1) {
            $tbody.append($("<tr>").append($("<td>").addClass("text-center").attr("colspan", 3).text("Nenhuma categoria cadastrada")));
            return;
        }

        categories.forEach((category, index) => {
            addCategoryRowToTable(category, index);
        });

        $table.off("click", "[data-delete]").on("click", "[data-delete]", function () {
            const categoryId = $(this).data("category-id");
            const $tr = $(this).closest("tr");
            handleDeleteCategory(categoryId, $tr);
        });

        $table.off("click", "[data-edit]").on("click", "[data-edit]", function () {
            const categoryId = $(this).data("category-id");
            const categoryIndex = $(this).closest("tr").data("index");
            handleEditCategory(categoryId, categoryIndex);
        });
    } catch (error) {
        showMessage("Requisição: erro ao buscar as categorias" + error);
    } finally {
        fetchingData = false;
    }
}

async function populateCategoryRow(id, categoryRow = null) {
    let category = [];

    [categories, category] = await Promise.all([
        getCategories(),
        getCategory(id)
    ]);

    if (fetchingData) return;
    fetchingData = true;

    try {
        const $tr = $(`tr[data-index=${categoryRow}]`);
        $tr.empty().append(createCategoryRow(category));
    } catch (error) {
        showMessage("Requisição: erro ao buscar a categoria");
    } finally {
        fetchingData = false;
    }
}

function createCategoryRow(category) {
    return $(`
        <td>
            <div class="d-flex align-items-center gap-2">
                <img src="${BASE_URL}public/upload/${category.image}" alt="${category.name}" class="img-thumbnail" style="max-width: 32px;">
                <span class="m-0">${category.name}</span>
            </div>
        </td>
        <td>
            <div class="btn-group">
                <button title="Abrir janela de edição" type="button" data-bs-toggle="modal" data-bs-target="#modal-edit-category" class="btn btn-sm btn-success" data-edit data-category-id="${category.category_id}"><i class="bi bi-pen"></i></button>
                <button title="Excluir categoria" type="button" class="btn btn-sm btn-danger" data-delete data-category-id="${category.category_id}"><i class="bi bi-trash"></i></button>
            </div>
        </td>
    `);
}

function addCategoryRowToTable(category, index) {
    const $tr = $("<tr>").attr("data-index", index);
    $tr.append(createCategoryRow(category));
    $tbody.append($tr);
}

function handleDeleteCategory(categoryId, tableRow) {
    if (!confirm("Realmente deseja excluir essa categoria?")) return;
    deleteCategory(categoryId, tableRow);
}

function handleEditCategory(categoryId, categoryIndex) {
    const { name } = categories.find(category => category.category_id == categoryId);

    $("#edit-category-id").val(categoryId);
    $("#edit-category-name").val(name);
    $("#category-index").val(categoryIndex);
}

function deleteCategory(categoryId, tr) {
    $.ajax({
        url: `${BASE_URL}category/actions/delete/${categoryId}`,
        method: "GET",
    })
        .done(async function (data) {
            showMessage(data.message);
            tr.remove();

            categories = await getCategories();

            if (categories.length < 1) {
                $tbody.empty().append($("<tr>").append($("<td>").addClass("text-center").attr("colspan", 3).text("Nenhuma categoria cadastrada")));
                return;
            }
        })
        .fail(function (_xhr, _status, _error) {
            showMessage("Requisição: erro ao excluir categoria");
        });
}

$formAddCategory.submit(async function (e) {
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
        $form.trigger("reset");
        $modalAddCategory.hide();
        populateCategoriesTable();
    } catch (error) {
        showMessage("Requisição: erro ao enviar dados do formulário");
        console.log(error);
    } finally {
        $form.find('button').text("Adicionar");
    }
});

$formEditCategory.submit(function (e) {
    e.preventDefault();
    const $form = $(this);
    const formData = new FormData($form[0]);
    const action = $form.attr("action");

    const categoryId = $("#edit-category-id").val();
    const categoryRow = $("#category-index").val();

    $form.find('button').html(`${SPINNER_HTML} Carregando...`);

    $.ajax({
        url: action,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            showMessage(data.message);
            if (data.status == "success") {
                $form.trigger("reset");
                $modalEditCategory.hide();

                populateCategoryRow(categoryId, categoryRow);
            }

            $form.find('button').text("Concluir edição");
        },
        error: function (_xhr, _status, _error) {
            showMessage("Requisição: erro ao editar categoria");
        },
    });
});

populateCategoriesTable();
initSidebarToggler();