document.addEventListener('DOMContentLoaded', function () {

    const baseurl = 'http://localhost/foropatos/?home';

    let url = window.location.href;

    if (url.match(/\?$/) || url.match(/\/$/)) {
        window.location.assign(baseurl);
    }

    setInterval(function () {
        logged_check();
    }, 30000);

    function logged_check() {
        fetch('?is_logged').then(r => r.json()).then(data => {
            console.log(data)
            if (data['response'] === false) {
                alert("<p class='text-center'>" +
                    "    Llevas más de cinco minutos inactivo." +
                    "    <br/>" +
                    "    Debes loggearte de nuevo." +
                    "</p>")
                window.location.assign(baseurl);
            }
        });
    }

});