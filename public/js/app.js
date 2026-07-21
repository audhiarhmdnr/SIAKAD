document.addEventListener('DOMContentLoaded', function () {
    var alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(function (el) {
        setTimeout(function () {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(function () { el.remove(); }, 400);
        }, 4000);
    });
});
