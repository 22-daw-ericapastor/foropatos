document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    const btn = document.querySelectorAll('.edit-btn');

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


    let table = create_table();

    // event on draw
    table.on('draw.dt', async function () {
        await toggle_messages_panel();
        await toggle_message_read();
        await delete_message();

    });

    function format_is_read_btn(btn, is_read) {
        if (is_read === 1) {
            btn.innerHTML = '&#x2713;';
            btn.classList.add('btn-success');
            btn.classList.remove('btn-danger');
        } else if (is_read === 0) {
            btn.innerHTML = '&#x2715;';
            btn.classList.add('btn-danger');
            btn.classList.remove('btn-success');
        }
    }

    document.querySelector('.account_deactivate-btn').onclick = function () {
        const response = document.querySelector('#account_deactivate-response');
        console.log(response)
        fetch('?acc_deactivate').then(r => r.text()).then(data => {
            response.innerHTML = data;
            if (data.match(/desactivado/)) {
                setTimeout(function () {
                    window.location.assign('?signout');
                }, 4000);
            }
        });
    }

    // create table
    function create_table() {
        return new DataTable('#msg-table', {
            processing: true, // fill with ajax request
            ajax: {
                url: '?get_messages', dataSrc: 'data',
            },
            columns: [
                {title: "Usuario", data: "username", class: "pe-3 text-center"},
                {title: "Tema", data: "title", class: "pe-3 text-center"},
                {title: "Fecha y hora", data: "datetime", class: "col-4 pe-3 text-center"},
                {title: "Leido", data: "toggle_read", class: "pe-3 text-center"},
                {title: "Borrar", data: "delete", class: "pe-3 text-center"}
            ],
            pageLength: rows_in_datatable,
            responsive: true,
            order: [[2, 'desc']],// position 3 -> from more recent to less recent by request date
            ordering: false,
        });
    }

    function toggle_messages_panel() {
        const title = document.getElementsByClassName('toggle-msg');
        const msg_panel = document.getElementById('panel-msg_text');
        const msg = document.getElementById('msg-body');
        const close_msg = document.getElementById('close-msg');
        for (let i = 0; i < title.length; i++) {
            // open msg container
            title[i].addEventListener('click', function () {
                msg_panel.classList.add('show');
                msg.innerHTML = table.data()[i]['msg_text'];
            });
            // close msg container
            close_msg.addEventListener('click', function () {
                msg_panel.classList.remove('show');
                msg.innerHTML = '';
            });
        }
    }

    function toggle_message_read() {
        // Event listener for tick is read not read
        const btn_read = document.getElementsByClassName('toggle-is_read');
        for (let i = 0; i < btn_read.length; i++) {
            // fill read and not read
            let is_read = table.data()[i]['is_read'];
            format_is_read_btn(btn_read[i], is_read);
            // create event for click on read button
            let user = document.getElementsByClassName('remitter')[i].innerHTML;
            let slug = table.data()[i]['slug'];
            btn_read[i].addEventListener('click', function () {
                if (is_read === 1) {
                    is_read = 0;
                } else if (is_read === 0) {
                    is_read = 1;
                }
                fetch('?msg_is_read=' + is_read + '&user=' + user + '&slug=' + slug)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        if (data['response'] === true) {
                            format_is_read_btn(btn_read[i], is_read);
                        }
                    });
            });
        }
    }

    function delete_message() {
        const del_msg_btn = document.getElementsByClassName('del_msg-btn');
        const table_data = table.data();
        for (let i = 0; i < del_msg_btn.length; i++) {
            del_msg_btn[i].addEventListener('click', async function () {
                console.log('hi')
                let slug = table_data[i]['slug'];
                console.log(slug)
                await fetch('?delmsg=' + slug)
                    .then(r => r.text())
                    .then(data => {
                        document.getElementById('ajax-table_response').innerHTML = data;
                        table.destroy();
                        table = create_table();
                    });
            });
        }
    }

});