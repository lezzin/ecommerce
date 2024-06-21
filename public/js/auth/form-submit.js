import { showMessage, SPINNER_HTML } from "../script.js";

export function handleFormSubmit($form, buttonText) {
    const formData = new FormData($form[0]);
    const action = $form.attr("action");
    $form.find('button[type="submit"]').html(`${SPINNER_HTML} Carregando...`);

    $.ajax({
        url: action,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.status === "redirect") {
                window.location.href = data.message;
                return;
            }

            showMessage(data.message);
            $form.find('button[type="submit"]').text(buttonText);
        },
        error: function (_xhr, _status, _error) {
            showMessage("Requisição: erro ao enviar dados do formulário");
            $form.find('button[type="submit"]').text(buttonText);
        },
    });
}
