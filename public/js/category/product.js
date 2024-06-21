import { showMessage, updateCart, SPINNER_HTML } from "../script.js";

const $productSize = $("#product-size");
const $productQuantity = $("#product-quantity");
const $secondaryImages = $("[data-secondary-images]");
const $primaryImage = $("[data-primary-image]");
const $addCartForm = $("#add-cart-form");

function populateQuantitySelect(quantity) {
    $productQuantity.closest(".form-group").show();
    $productQuantity.empty();

    for (let index = 1; index <= quantity; index++) {
        $productQuantity.append(`<option value="${index}">${index}</option>`);
    }
}

$productSize.on("change", function () {
    const quantity = +$(this).find("option:selected").attr("data-quantity");
    populateQuantitySelect(quantity);
});

$secondaryImages.on("click", "button", function () {
    const $oldImage = $primaryImage.attr("src");
    const $newImage = $(this).find("img").attr("src");
    const animationTimer = 100;

    $primaryImage.fadeOut(animationTimer, function () {
        $primaryImage.attr("src", $newImage).fadeIn(animationTimer);
    });

    $(this).find("img").fadeOut(animationTimer, function () {
        $(this).attr("src", $oldImage).fadeIn(animationTimer);
    });
});

$addCartForm.on("submit", function (e) {
    e.preventDefault();

    const $form = $(this);
    const formData = new FormData($form[0]);
    const action = $form.attr("action");
    const $submitButton = $('#add-cart-btn');

    $submitButton.html(`${SPINNER_HTML} Carregando...`);

    $.ajax({
        url: action,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            showMessage(data.message);
            updateCart();
        },
        error: function (_xhr, _status, _error) {
            showMessage("Requisição: Erro ao atualizar carrinho");
        },
        complete: function () {
            $submitButton.text("Adicionar produto ao carrinho..");
        },
    });
});

$productQuantity.closest(".form-group").hide();
updateCart();

const initialQuantity = +$productSize.find("option:selected").attr("data-quantity");
populateQuantitySelect(initialQuantity);
