document.addEventListener('DOMContentLoaded', function () {

    const username = document.getElementById('username'),
        passwd = document.getElementById('passwd');

    [username, passwd].forEach(inputfield => {
        inputfield.addEventListener('keyup', function (evt) {
            validate_form(evt);
        });
    });
    document.onclick = function (evt) {
        validate_form(evt);
    }

    function validate_form(evt) {
        if (username.value !== '' && passwd.value !== '') {
            document.getElementById('signin_btn').disabled = false;
        } else {
            document.getElementById('signin_btn').disabled = true;
        }
    }

});