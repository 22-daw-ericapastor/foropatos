document.addEventListener('DOMContentLoaded', function () {

    /**
     * Modal dialog section for messages
     * -----------------------------------------------------------------------------------------------------------------
     * @type {HTMLElement}
     */
    const msgs_info = document.getElementById('msgs-info');

    const cursor_pointer = document.getElementsByClassName('cursor-pointer');

    fetch('?get_messages')
        .then(response => response.json())
        .then(data => {
            if (data['null']) {
                msgs_info.innerHTML = data['null'];
            } else {
                for (let i in data) {
                    // fill messages
                }
            }
        });

    for (let i in cursor_pointer) {
        cursor_pointer[i].onclick = function () {
            let collapse_list = document.querySelector('.cursor-pointer ~ .collapse');
            if (collapse_list) {
                collapse_list.classList.toggle('show');
            }
        }
    }

});