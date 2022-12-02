document.addEventListener('DOMContentLoaded', function () {

    const baseurl = 'http://localhost/foropatos/?home';

    let url = window.location.href;

    if (url.match(/\?$/) || url.match(/\/$/)) {
        window.location.assign(baseurl);
    }

    function logged_check() {
        fetch('?is_logged').then(r => r.json()).then(data => {
            console.log(data)
            if (data['response'] === false) {
                window.location.assign(baseurl);
            }
        });
    }

});