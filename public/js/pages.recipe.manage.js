document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    const table_response = document.getElementById('ajax-table_response');

    const updt_container = document.getElementById('uptd_rcp-container');

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
        const img = document.querySelector('#img_src');
        const diff_options = document.querySelector('#difficulty').children;
        const index = document.querySelector('.paginate_button.current').getAttribute('data-dt-idx');
        console.log(img)
        for (let i = 0; i < table_data.length; i++) {
            let data = table_data[i + index * 10];
            if (update_link[i] && delete_link[i]) {
                update_link[i].onclick = function () {
                    /*
                     * Fill form fields with recipe data
                     */
                    // Fill title
                    $('#rcp_title').val(titles[i].innerHTML);
                    // Fill description
                    $('#description').val(data['description']);
                    // Select difficulty
                    let rcp_diff = data['difficulty'];
                    for (let i = 0; i < diff_options.length; i++) {
                        if (parseInt(diff_options[i].value) === rcp_diff) {
                            diff_options[i].selected = true;
                        }
                    }
                    // Fill image
                    $('.updt_rcp-img')[0].style.background = 'url("' + baseurl + data['src'] + '")';
                    // Fill making
                    $('#making').val(data['making']);
                    // Fill admixtures if not empty
                    let admixt = data['admixtures'];
                    if (admixt === '' || admixt === null) admixt = 'La lista está vacía';
                    else $('#admixtures').val(admixt);
                    $('#admixtures ~ label').html(admixt);
                    // put slug in button submit value so it will submit for updating
                    $('#updt-btn').val(data['slug']);
                }
                delete_link[i].onclick = function () {
                    fetch('?delete_recipe=' + data['slug'])
                        .then(res => res.text())
                        .then(data => {
                            table_response.innerHTML = data;
                            if (data.match(/eliminada/)) {
                                table.destroy();
                                table = draw_table();
                            }
                        });
                }
            }
        }
    });

});