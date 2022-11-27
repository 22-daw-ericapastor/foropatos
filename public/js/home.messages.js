document.addEventListener('DOMContentLoaded', function () {

    const issue_title = document.getElementById('issue-title');

    const issue_text = document.getElementById('issue-msg');

    const issue_btn = document.getElementById('issue-btn');

    const error_message = document.getElementById('submitErrorMessage');

    fetch('?is_logged').then(response => response.json()).then(data => {
        if (!data['response']) {
            issue_title.disabled = true;
            issue_text.disabled = true;
            issue_btn.disabled = true;
            error_message.classList.remove('d-none');
            error_message.classList.toggle('d-block');
            error_message.innerHTML = "Tienes que estar loggeado para poder enviar un mensaje";
        } else {
            issue_btn.addEventListener('click', function () {
                fetch('?message')
            });
        }
    });

});