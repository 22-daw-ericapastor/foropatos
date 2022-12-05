document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    const table_response = document.getElementById('ajax-table_response');

    function draw_table() {
        return new DataTable('#users-table', {
            processing: true, // fill with ajax request
            ajax: {
                url: '?get_users', dataSrc: 'data',
            },
            columns: [
                {title: "Usuario", data: "username", class: "pe-3 text-center"},
                {title: "", data: "toggle_active", class: "pe-3 text-center"},
                {title: "", data: "toggle_permissions", class: "pe-3 text-center"},
                {title: "", data: "delete_user", class: "pe-3 text-center"}
            ],
            pageLength: rows_in_datatable,
            responsive: true,
            ordering: false,
        });
    }

    let table = draw_table();

    table.on('draw.dt', async function () {
        const toggle_active = document.getElementsByClassName('toggle-user_active');
        const toggle_permissions = document.getElementsByClassName('toggle-user_permissions');
        const delete_user_btn = document.getElementsByClassName('delete_user');
        const users = document.getElementsByClassName('username');
        const table_data = table.data();
        const index = document.querySelector('.paginate_button.current').getAttribute('data-dt-idx');
        for (let i = 0; i < table_data.length; i++) {
            let data = table_data[i + index * 10];
            // user of this row
            let user = users[i].innerHTML;
            // Toggle user (in)active onclick
            if (toggle_active[i] && toggle_permissions[i] && delete_user_btn[i]) {
                let is_active = data['is_active'];
                toggle_active[i].addEventListener('click', function () {
                    is_active = is_active === '1' || is_active === 1 ? 0 : 1;
                    toggle_user_active(is_active, user);
                });
                // Toggle permissions admin/user onclick
                let permissions = data['permissions'];
                toggle_permissions[i].addEventListener('click', function () {
                    permissions = permissions === '1' || permissions === 1 ? 0 : 1;
                    toggle_user_permissions(permissions, user);
                });
                // Delete user onclick
                delete_user_btn[i].addEventListener('click', function () {
                    delete_user(user);
                });
            }

        }

        async function toggle_user_active(is_active, user) {
            await fetch('?toggle_active=' + is_active + '&user=' + user)
                .then(r => r.text())
                .then(data => {
                    table_response.innerHTML = data;
                    if (data.match(/!/)) {
                        table.destroy();
                        table = draw_table();
                    }
                })
        }

        async function toggle_user_permissions(permissions, user) {
            await fetch('?toggle_permissions=' + permissions + '&user=' + user)
                .then(r => r.text())
                .then(data => {
                    table_response.innerHTML = data;
                    if (data.match(/!/)) {
                        table.destroy();
                        table = draw_table();
                    }
                })
        }

        async function delete_user(user) {
            await fetch('?delete_user=' + user)
                .then(r => r.text())
                .then(data => {
                    table_response.innerHTML = data;
                    if (data.match(/fue eliminado/)) {
                        table.destroy();
                        table = draw_table();
                    }
                });
        }

    });

});