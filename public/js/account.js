document.addEventListener('DOMContentLoaded', function () {

    const btn = document.querySelectorAll('.account-edit-btn');

    const form = document.querySelectorAll('.account-edit-form');

    const close = document.querySelectorAll('.close-form');

    for (let i = 0; i < close.length; i++) {
        btn[i].addEventListener('click', function () {
            form[i].classList.add('show');
        });
        close[i].onclick = function () {
            form[i].classList.remove('show');
        }
    }

    let rows_in_datatable = 10;

    let table = new DataTable('#msg-table', {
        processing: true, // fill with ajax request
        ajax: {
            url: '?getRequests', dataSrc: '',
        },
        columns: [
            {title: "Token", data: "token", class: "col-1 js-token px-1"},
            {title: "Fecha solicitud", data: "date", class: "col-2 px-1"},
            {title: "Solicitante", data: "fname", class: "px-1"},
            {title: "Poblacion", data: "poblacion", class: "px-1"},
            {title: "Geolocalizacion", data: "btn_map", class: "col-1 px-1"},
            {title: "Envio", data: "send_value", class: "text-left px-1"},
            {title: "Cobertura", data: "coverage", class: "col-3 px-1"},
        ],
        pageLength: rows_in_datatable,
        columnsDefs: [],
        responsive: true, order: [[1, 'desc']],// position 2 -> from more recent to less recent by request date
    });

});