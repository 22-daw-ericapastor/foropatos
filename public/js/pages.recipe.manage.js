document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    const table_response = document.getElementById('ajax-table_response');

    const updt_container=document.getElementById('uptd_rcp-container');

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
        for (let i = 0; i < update_link.length; i++) {
            let slug = table_data[i]['slug'];
            update_link[i].onclick = async function () {
                updt_container.classList.remove('d-none');
                updt_container.classList.add('d-block');
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