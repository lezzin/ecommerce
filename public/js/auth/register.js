import { handleFormSubmit } from "./form-submit.js";

let currentStep = 1;
const totalSteps = $('.form-step').length;

// Atualiza os detalhes das etapas do formulário
function updateStepsDetails() {
    toggleStepsDetailsDisplay();
    highlightActiveSteps();
}

// Mostra ou oculta os detalhes das etapas com base na etapa atual
function toggleStepsDetailsDisplay() {
    if (currentStep === 1) {
        $('.form-steps-details').hide();
    } else {
        $('.form-steps-details').show();
    }
}

// Destaca as etapas ativas
function highlightActiveSteps() {
    $('.step-ball, .step-line').removeClass('active');
    for (let i = 2; i <= currentStep; i++) {
        $('.form-steps-details .step-ball').eq(i - 2).addClass('active');
        if (i < currentStep) {
            $('.form-steps-details .step-line').eq(i - 2).addClass('active');
        }
    }
}

// Valida os campos obrigatórios na etapa atual
function validateCurrentStep() {
    let isValid = true;
    $(`#step-${currentStep} input[required]`).each(function () {
        if ($(this).val() === '') {
            isValid = false;
        }
    });
    return isValid;
}

// Alterna o estado do botão "Próximo" com base na validação da etapa
function toggleNextButton() {
    if (validateCurrentStep()) {
        $('.next-step').prop('disabled', false);
    } else {
        $('.next-step').prop('disabled', true);
    }
}

// Navega para a próxima etapa do formulário
function goToNextStep() {
    if (currentStep < totalSteps && validateCurrentStep()) {
        $(`#step-${currentStep}`).hide();
        currentStep++;
        $(`#step-${currentStep}`).show();
        updateStepsDetails();
        toggleNextButton();
    }
}

// Navega para a etapa anterior do formulário
function goToPreviousStep() {
    if (currentStep > 1) {
        $(`#step-${currentStep}`).hide();
        currentStep--;
        $(`#step-${currentStep}`).show();
        updateStepsDetails();
        toggleNextButton();
    }
}

function initializeFormNavigation() {
    updateStepsDetails();
    toggleNextButton();
}

$('.next-step').click(goToNextStep);
$('.prev-step').click(goToPreviousStep);

$('input[required]').on('input', toggleNextButton);

$("#register-form").submit(function (e) {
    e.preventDefault();
    const $form = $(this);
    handleFormSubmit($form, "Criar conta");
});

initializeFormNavigation();