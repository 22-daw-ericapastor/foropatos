document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    let table = new DataTable('#users-table', {
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

    table.on('draw.dt', function () {
        const toggle_active = document.getElementsByClassName('toggle-user_active');
        const toggle_permissions = document.getElementsByClassName('toggle-user_permissions');
        for (let i = 0; i < toggle_active.length; i++) {
            let user = table.data()[i]['username'];
            let is_active = table.data()[i]['is_active'];
            let permissions = table.data()[i]['permissions'];
            toggle_active[i].addEventListener('click', async function () {
                is_active = is_active === '1' || is_active === 1 ? 0 : 1;
                await toggle_user_active(is_active, user);
            });
            toggle_permissions[i].addEventListener('click', async function () {
                permissions = permissions === '1' || permissions === 1 ? 0 : 1;
                await toggle_user_permissions(permissions, user);
            });
        }

        async function toggle_user_active(is_active, user) {
            console.log(is_active)
            await fetch('?toggle_active=' + is_active + '&user=' + user)
                .then(r => r.json())
                .then(data => {
                    if (data['response'] !== false) {
                        window.location.assign(window.location.href);
                    }
                })
        }

        async function toggle_user_permissions(permissions, user) {
            await fetch('?toggle_permissions=' + permissions + '&user=' + user)
                .then(r => r.text())
                .then(data => {
                    console.log(data)
                    /*if (data['response'] !== false) {
                        window.location.assign(window.location.href);
                    }*/
                })
        }

    });

});