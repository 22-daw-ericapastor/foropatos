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
            url: '?get_messages', dataSrc: 'data',
        },
        columns: [
            {title: "User", data: "username", class: ""},
            {title: "Mensaje", data: "msg", class: ""},
            {title: "Fecha y hora", data: "datetime", class: ""},
            {title: "Leido", data: "is_read", class: ""}
        ],
        pageLength: rows_in_datatable,
        columnsDefs: [],
        responsive: true, order: [[3, 'desc']],// position 3 -> from more recent to less recent by request date
    });

    table.on('draw.dt', function () {
        const title = document.getElementsByClassName('toggle-msg');
        const msg = document.getElementsByClassName('table-msg_text');
        for (let i = 0; i < title.length; i++) {
            title[i].addEventListener('click', function () {
                msg[i].classList.toggle('show');
            });
        }
        const is_read=document.getElementsByClassName('toggle-is_read');
        // event listener for tick is read not read
    });

});