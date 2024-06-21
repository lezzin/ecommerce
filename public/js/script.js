const SPINNER_HTML = '<div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';

// this data attribute is in the templates/header.php file
const BASE_URL = $("body").attr("data-url");

function urlFormat(url) {
    function removeAccents(str) {
        const accents = {
            'á': 'a', 'ã': 'a', 'â': 'a', 'à': 'a', 'ä': 'a',
            'é': 'e', 'ê': 'e', 'è': 'e', 'ë': 'e',
            'í': 'i', 'î': 'i', 'ì': 'i', 'ï': 'i',
            'ó': 'o', 'õ': 'o', 'ô': 'o', 'ò': 'o', 'ö': 'o',
            'ú': 'u', 'û': 'u', 'ù': 'u', 'ü': 'u',
            'ç': 'c',
            'Á': 'a', 'Ã': 'a', 'Â': 'a', 'À': 'a', 'Ä': 'a',
            'É': 'e', 'Ê': 'e', 'È': 'e', 'Ë': 'e',
            'Í': 'i', 'Î': 'i', 'Ì': 'i', 'Ï': 'i',
            'Ó': 'o', 'Õ': 'o', 'Ô': 'o', 'Ò': 'o', 'Ö': 'o',
            'Ú': 'u', 'Û': 'u', 'Ù': 'u', 'Ü': 'u',
            'Ç': 'c'
        };

        return str.replace(/[áãâàäéêèëíîìïóõôòöúûùüçÁÃÂÀÄÉÊÈËÍÎÌÏÓÕÔÒÖÚÛÙÜÇ]/g, function(match) {
            return accents[match];
        });
    }

    return removeAccents(String(url).trim().toLowerCase().replace(/ /g, "-"));
}

function showMessage(message) {
    const $toastContainer = $("#toast-container");
    if (!$toastContainer.length) return;

    const $toast = `
        <div class="toast text-bg-light" role="alert" aria-live="assertive" aria-atomic="true"> 
            <div class="toast-header">
                <strong class="me-auto"><i class="bi bi-bell me-1"></i>Nova notificação</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close" title="Fechar notificação"></button>
            </div>
            <div class="toast-body">${message}</div>
        </div>`;

    $toastContainer.append($toast);
    const toast = new bootstrap.Toast($toastContainer.find(".toast:last")[0]);
    toast.show();
}

function updateCart() {
    const $cartButton = $("#cart-button");

    if (!$cartButton.length) return;

    const $cartContainer = $("#cartOffcanvas");
    const $cartList = $cartContainer.find(".list-group");
    $cartList.empty();

    $.ajax({
        url: `${BASE_URL}cart/actions/get`,
        type: "GET",
        success: function (data) {
            $cartButton.find(".badge").text(data.length);

            if (data.length > 0) {
                data.forEach(cartItem => {
                    const formattedPrice = new Intl.NumberFormat("pt-BR", {
                        style: "currency",
                        currency: "BRL"
                    }).format(cartItem.price);

                    const html = `<li class="list-group-item d-flex align-items-start gap-3">
                                    <div class="ratio ratio-1x1" style="max-width: 48px;">
                                        <img src="${BASE_URL}public/upload/${cartItem.product_image_url}" alt="Uma camisa" class="object-fit-cover img-fluid rounded">
                                    </div>

                                    <div>
                                        <a class="m-0 fw-bold link-dark text-decoration-none" href="${BASE_URL}category/${urlFormat(cartItem.category)}/products/${urlFormat(cartItem.name)}">${cartItem.name}</a>
                                        <p class="m-0" style="font-size: .9rem;">${formattedPrice} (${cartItem.size})</p>
                                    </div>
                                </li>`;

                    $cartList.append(html);
                });
            } else {
                $cartList.append('<li class="list-group-item">Nenhum produto no carrinho</li>');
            }
        },
        error: function (_xhr, _status, error) {
            showMessage("Requisição: erro ao buscar carrinho: " + error);
        }
    });
}

function currencyFormat(number) {
    return new Intl.NumberFormat("pt-BR", {
        style: "currency",
        currency: "BRL"
    }).format(number);
}

export {
    currencyFormat,
    updateCart,
    urlFormat,
    showMessage,
    BASE_URL,
    SPINNER_HTML
};
