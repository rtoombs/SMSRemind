$(document).ready(function () {
    if (document.referrer.indexOf("/user/register") >= 0) {
        $(".is-registered").html("Registration Complete");
    }

    $('#login-link').click(function() {
        var obj = new Object();
        obj.email = $('#login-email').val();
        obj.pass = $('#login-pass').val();

        sendData(obj);
        return false;
    });
});

function sendData(userLogin) {
    $.ajax({
        url: '/data/check_login',
        data: {data: JSON.stringify(userLogin)},
        type: 'POST',
        success: function (msg) {
            var res = JSON.parse(msg);
            if (res.status === 'OK') {
                location.href = '/go';
            }
            else if (res.status === 'INVALID') {
                $('.login-error').html("Wrong username or password");
            }
        },
        error: function (xhr, errormsg) {
            console.log('ooops');
            //window.location = '/';
        }
    });
}