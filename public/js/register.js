//TODO Check if form is empty.
//TODO Make sure email is actually an email
//TODO Event handler if passwords don't match
//TODO Make sure password is less than 4096 chars and greater than 6 chars


$(document).ready(function () {
    $('#register-submit').click(function() {
        var userRegister = gatherData();
        sendData(userRegister);
        return false;
    });
});

function gatherData () {
    var obj = new Object();
    obj.email = $('#register-email').val();

    var x = $('#register-password').val();
    var y = $('#register-repassword').val();

    if (x === y){
        obj.pass = x;
    }
    return obj;
}

function sendData(userRegister) {
    $.ajax({
        url: '/data/register',
        data: {data: JSON.stringify(userRegister)},
        type: 'POST',
        success: function (msg) {
            var res = JSON.parse(msg);
            if (res.status === 'AID') {
                $(".AID").html("This email is already in use")
            }
            else if (res.status === 'OK') {
                location.href = "/";
            }
        },
        error: function (xhr, errormsg) {
            console.log('ooops');
            //window.location = '/';
        }
    });
}