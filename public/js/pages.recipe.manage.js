document.addEventListener('DOMContentLoaded', function () {

    const rows_in_datatable = 10;

    const table_response = document.getElementById('ajax-table_response');

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
            paging: false
        });
    }

    let table = draw_table();

    table.on('draw.dt', async function () {
    });

});