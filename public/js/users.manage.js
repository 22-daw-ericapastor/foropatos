document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    function draw_table() {
        return new DataTable('#users-table', {
            processing: true, // fill with ajax request
            ajax: {
                url: '?get_users', dataSrc: 'data',
            },
            columns: [
                {title: "", data: "username", class: "pe-3 text-center"},
                {title: "", data: "toggle_active", class: "pe-3 text-center"},
                {title: "", data: "toggle_permissions", class: "pe-3 text-center"},
                {title: "", data: "delete_user", class: "pe-3 text-center"}
            ],
            pageLength: rows_in_datatable,
            responsive: true,
            order: [[2, 'desc']],// position 3 -> from more recent to less recent by request date
            ordering: false,
        });
    }

    let table = draw_table();

    table.on('draw.dt', async function () {
        const toggle_active = document.getElementsByClassName('toggle-user_active');
        const toggle_permissions = document.getElementsByClassName('toggle-user_permissions');
        const user = document.getElementsByClassName('username');
        const data = table.data();
        for (let i = 0; i < toggle_active.length; i++) {
            // Toggle user (in)active onclick
            let is_active = data[i]['is_active'];
            toggle_active[i].addEventListener('click', function () {
                is_active = is_active === '1' || is_active === 1 ? 0 : 1;
                toggle_user_active(is_active, user[i].innerHTML);
            });
            // Toggle permissions admin/user onclick
            let permissions = data[i]['permissions'];
            console.log(toggle_permissions)
            toggle_permissions[i].addEventListener('click', function () {
                console.log(permissions)
                permissions = permissions === '1' || permissions === 1 ? 0 : 1;
                console.log(permissions)
                toggle_user_permissions(permissions, user[i].innerHTML);
            });

        }

        async function toggle_user_active(is_active, user) {
            await fetch('?toggle_active=' + is_active + '&user=' + user)
                .then(r => r.json())
                .then(data => {
                    console.log(data);
                    // cambiar inner HTML y rellenar
                })
        }

        async function toggle_user_permissions(permissions, user) {
            await fetch('?toggle_permissions=' + permissions + '&user=' + user)
                .then(r => r.text())
                .then(data => {
                    console.log(data)
                    // cambiar inner HTML y rellenar
                })
        }

    });

    table.on('draw.dt', async function () {
    });

});