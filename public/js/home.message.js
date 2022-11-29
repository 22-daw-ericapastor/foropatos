document.addEventListener('DOMContentLoaded', function () {

    const issue_title = document.getElementById('issue-title');

    const issue_text = document.getElementById('issue-msg');

    const issue_btn = document.getElementById('contact-btn');

    const logged_info = document.getElementById('contact-logged-info');

    let json = '';

    fetch('?is_logged').then(response => response.json()).then(data => {
        issue_title.disabled = !data['response'];
        issue_text.disabled = !data['response'];
        issue_btn.disabled = true;
        if (!data['response']) {
            logged_info.innerHTML = 'Tienes que estar loggeado para poder enviar un mensaje';
        } else {
            logged_info.innerHTML = '¿Tienes dudas? ¿Sugerenecias? No dudes en escribirnos.';
            [issue_text, issue_title].forEach(field => {
                field.addEventListener('keyup', function () {
                    if (issue_title.value !== '' && issue_text.value !== ''
                        && issue_title.value.length > 3 && issue_text.value.length > 9) {
                        issue_btn.disabled = false;
                    } else {
                        issue_btn.disabled = true;
                    }
                });
            });
        }
        issue_btn.onclick = async function () {
            fetch('?message=' + issue_text.value + '&title=' + issue_title.value)
                .then(response => response.text())
                .then(data => {
                    let response = document.getElementById('contact-response-msg');
                    response.innerHTML = data;
                    if (data.match(/enviado/)) {
                        setTimeout(function () {
                            response.innerHTML = '';
                        }, 4000);
                    }
                });
        }
    });

});