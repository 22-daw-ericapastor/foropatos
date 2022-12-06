document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    const table_response = document.getElementById('ajax-table_response');

    let cur_url = window.location.href;
    if (cur_url.match(/\?/)) {
        cur_url = cur_url.substring(0, cur_url.indexOf('?'));
    }
    const baseurl = cur_url + 'public/';

    function draw_table() {
        return new DataTable('#recipes-table', {
            processing: true, // fill with ajax request
            ajax: {
                url: '?datatable_recipes', dataSrc: 'response',
            },
            columns: [
                {title: "Recetas", data: "title", class: "pe-3 text-center"},
                {title: "", data: "update", class: "pe-3 text-center"},
                {title: "", data: "delete", class: "pe-3 text-center"}
            ],
            pageLength: rows_in_datatable,
            responsive: true,
            ordering: false,
        });
    }

    let table = draw_table();

    // Call delete and modify onclick after table is draw
    table.on('draw.dt', async function () {
        const table_data = table.data();
        const update_link = document.querySelectorAll('.update_recipe');
        const delete_link = document.querySelectorAll('.delete_recipe');
        const titles = document.querySelectorAll('.username');
        const diff_options = document.querySelector('#difficulty').children;
        const index = document.querySelector('.paginate_button.current').getAttribute('data-dt-idx');
        for (let i = 0; i < table_data.length; i++) {
            let recipe_data = table_data[i + index * 10];
            if (update_link[i] && delete_link[i]) {
                update_link[i].onclick = function () {
                    fetch('?is_logged').then(r => r.text()).then(data => {
                        if (data['response'] === false) {
                            table_response.innerHTML = '<span class="text-danger">Tiempo de sesion caducado.<br/>' +
                                'Serás redirigido al login en unos segundos.</span>';
                            setTimeout(function () {
                                window.location.assign('?signout');
                            }, 4000);
                        } else {
                            /*
                             * Fill form fields with recipe data
                             */
                            // Fill title
                            $('#rcp_title').val(titles[i].innerHTML);
                            // Fill description
                            console.log(recipe_data['description']);
                            $('#description').val(recipe_data['description']);
                            // Select difficulty
                            let rcp_diff = recipe_data['difficulty'];
                            for (let i = 0; i < diff_options.length; i++) {
                                if (parseInt(diff_options[i].value) === rcp_diff) {
                                    diff_options[i].selected = true;
                                }
                            }
                            // Fill image
                            $('.updt_rcp-img')[0].style.background = 'url("' + baseurl + recipe_data['src'] + '")';
                            // Fill making
                            $('#making').val(recipe_data['making']);
                            // Fill admixtures if not empty
                            let admixt = recipe_data['admixtures'];
                            if (admixt === '' || admixt === null) admixt = 'La lista está vacía';
                            else $('#admixtures').val(admixt);
                            $('#admixtures ~ label').html(admixt);
                            // put slug in button submit value so it will submit for updating
                            $('#updt-btn').val(recipe_data['slug']);
                        }
                    });
                }
                delete_link[i].onclick = async function () {
                    await fetch('?delete_recipe=' + recipe_data['slug'])
                        .then(res => res.text())
                        .then(data => {
                            table_response.innerHTML = data;
                            if (data.match(/eliminada/)) {
                                table.destroy();
                                table = draw_table();
                            } else if (data.match(/caducado/)) {
                                setTimeout(function () {
                                    window.location.assign('?signout');
                                }, 3000);
                            }
                        });
                }
            }
        }
    });

});