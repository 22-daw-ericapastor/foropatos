document.addEventListener('DOMContentLoaded', function () {

    const admixtures_btn = document.querySelector('.admixtures-btn');
    const admixtures_input = document.querySelector('#admixtures_input');
    const admixtures = document.querySelector('#admixtures');
    console.log(admixtures_input)
    admixtures_btn.onclick = function () {
        add_item();
    }
    admixtures_input.onkeyup = function (evt) {
        if (evt.key === 'Enter') {
            add_item();
        }
    }

    function add_item() {
        if (admixtures_input.value !== '') {
            if (admixtures.value === '') {
                admixtures.value = admixtures_input.value;
            } else {
                admixtures.value = admixtures.value + ", " + admixtures_input.value;
            }
            admixtures_input.value = '';
        }
    }

});