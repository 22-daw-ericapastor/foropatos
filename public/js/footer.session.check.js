document.addEventListener('DOMContentLoaded', function () {

    const baseurl = 'http://localhost/foropatos/?home';

    logged_check();

    function logged_check() {
        // get base url
        let url = window.location.href;
        if (url.match(/\?$/) || url.match(/\/$/)) {
            window.location.assign(baseurl);
        }
    }

});