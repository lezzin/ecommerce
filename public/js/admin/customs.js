import { BASE_URL, showMessage, SPINNER_HTML } from "../script.js";
import { initSidebarToggler } from "./script.js";

function updateCustomData() {
    $.ajax({
        url: `${BASE_URL}config/actions/get`,
        type: "GET",
        success: function ({ config }) {
            updateDisplay(config);
        },
        error: function (_xhr, _status, _error) {
            showMessage("Requisição: erro ao atualizar configurações");
        },
    });
}

function updateDisplay(config) {
    $("#banner-image-display, #btn-delete-message, #btn-delete-banner").hide();
    $("#top-message").val("");

    $("[data-config-id]").val(config.config_id);

    if (config.banner_url) {
        $("#banner-image-display").show();
        $("#banner-image-display img").attr("src", `${BASE_URL}public/upload/${config.banner_url}`);
        $("#btn-delete-banner").show();
    }

    if (config.top_message) {
        $("#top-message").val(config.top_message);
        $("#btn-delete-message").show();
    }
}

$("[data-add], [data-delete]").each(function (_, form) {
    $(form).submit(async function (e) {
        e.preventDefault();

        const $form = $(this);
        const formData = new FormData($form[0]);
        const action = $form.attr("action");

        $form.find('button[type="submit"]').html(`${SPINNER_HTML} Carregando...`);

        try {
            const response = await $.ajax({
                url: action,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
            });

            $form.trigger("reset");
            showMessage(response.message);
            updateCustomData();
        } catch (error) {
            showMessage("Requisição: erro ao atualizar configurações");
        } finally {
            $form.find('button[type="submit"]').text("Alterar");
        }
    });
});

updateCustomData();
initSidebarToggler();
