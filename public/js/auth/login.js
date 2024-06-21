import { handleFormSubmit } from "./form-submit.js";

$("#login-form").submit(function (e) {
    e.preventDefault();
    const $form = $(this);
    handleFormSubmit($form, "Acessar conta");
});
