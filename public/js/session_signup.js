document.addEventListener('DOMContentLoaded', function () {

    const username = document.getElementById('username'),
        email = document.getElementById('email'),
        passwd = document.getElementById('passwd'),
        passwd_repeat = document.getElementById('passwd_repeat');

    [username, email, passwd, passwd_repeat].forEach(inputfield => {
        inputfield.addEventListener('keyup', function (evt) {
            validate_form(evt);
        });
    });
    document.onclick = function (evt) {
        validate_form(evt);
    }

    function validate_form(evt) {
        let user_n_email = false, passwds = false;
        if (username.value === '' && email.value === '') {
            user_n_email = false;
        } else {
            user_n_email = true;
        }
        if (passwd.value.length > 0 && passwd.value.length < 8) {
            if (evt.target !== passwd) {
                document.getElementById('passwd_error').style.display = 'block';
            }
        } else if (passwd.value.length >= 8) {
            document.getElementById('passwd_error').style.display = 'none';
            if (passwd_repeat.value !== '' && passwd_repeat.value !== passwd.value) {
                if (evt.target !== passwd_repeat) {
                    document.getElementById('passwd_repeat_error').style.display = 'block';
                }
                passwds = false;
            } else if (passwd_repeat.value === passwd.value) {
                document.getElementById('passwd_repeat_error').style.display = 'none';
                passwds = true;
            }
        }
        if (user_n_email && passwds) {
            document.getElementById('signup_btn').disabled = false;
        } else {
            document.getElementById('signup_btn').disabled = true;
        }
    }

});