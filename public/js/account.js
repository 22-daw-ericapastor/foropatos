document.addEventListener('DOMContentLoaded', function () {

    /**
     * Modal dialog section for messages
     * -----------------------------------------------------------------------------------------------------------------
     * @type {HTMLElement}
     */
    const msgs_info = document.getElementById('msgs-info');

    /**
     * Cursor pointer items
     * -----------------------------------------------------------------------------------------------------------------
     * @type {HTMLCollectionOf<Element>}
     */
    const cursor_pointer = document.getElementsByClassName('cursor-pointer');

    /**
     * Collapse items
     * -----------------------------------------------------------------------------------------------------------------
     * @type {NodeListOf<Element>}
     */
    const collapse_list = document.querySelectorAll('.cursor-pointer ~ .collapse');

    // Fetch messages from Database
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

    // Activate click event for the cursor pointer items to show the collapse items.
    for (let i = 0; i < cursor_pointer.length; i++) {
        cursor_pointer[i].addEventListener('click', function () {
            for (let j = 0; j < collapse_list.length; j++) {
                if (i !== j) collapse_list[j].classList.remove('show');
            }
            collapse_list[i].classList.toggle('show');
        });
    }

});