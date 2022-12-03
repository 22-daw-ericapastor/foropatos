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
                {title: "", data: "title", class: "pe-3 text-center"},
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
        for (let i = 0; i < update_link.length; i++) {
            let slug = table_data[i]['slug'];
            update_link[i].onclick = async function () {
                // Fill form fields with recipe data
                // Fill title
                $('#rcp_title').val(titles[i].innerHTML);
                // Fill description
                $('#description').val(table_data[i]['description']);
                // Select difficulty
                let rcp_diff = table_data[i]['difficulty'];
                for (let i = 0; i < diff_options.length; i++) {
                    if (parseInt(diff_options[i].value) === rcp_diff) {
                        diff_options[i].selected = true;
                    }
                }
                // Fill image?
                document.querySelector('.updt_rcp-img').style.background = 'url("' + baseurl + table_data[i]['src'] + '")';
                // Fill making
                $('#making').val(table_data[i]['making']);
                // Fill admixtures if not empty
                let admixt = table_data[i]['admixtures'];
                console.log(admixt)
                if (admixt === '' || admixt === null) admixt = 'La lista está vacía';
                else $('#admixtures').val(admixt);
                $('#admixtures ~ label').html(admixt);
                // put slug in button submit value so it will submit for updating
                $('#updt-btn').val(table_data[i]['slug']);
            }
            delete_link[i].onclick = function () {
                fetch('?delete_recipe=' + slug)
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
    });

});