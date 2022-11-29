document.addEventListener('DOMContentLoaded', function () {

    const issue_title = document.getElementById('issue-title');

    const issue_text = document.getElementById('issue-msg');

    const issue_btn = document.getElementById('contact-btn');
    console.log(issue_btn)
    const response = document.getElementById('contact-response-msg');

    fetch('?is_logged').then(response => response.json()).then(data => {
        issue_title.disabled = !data['response'];
        issue_text.disabled = !data['response'];
        issue_btn.disabled = true;
        if (!data['response']) {
            response.innerHTML = 'Tienes que estar loggeado para poder enviar un mensaje';
        } else {
            response.innerHTML = '¿Tienes dudas? ¿Sugerenecias? No dudes en escribirnos.';
            [issue_text, issue_title].forEach(field => {
                field.addEventListener('keyup', function () {
                    if (issue_title.value !== '' && issue_text.value !== '' && issue_title.value.length > 3 && issue_text.value.length > 10) {
                        issue_btn.disabled = false;
                    }
                });
            });
        }
    });

});