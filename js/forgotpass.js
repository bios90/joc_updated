$(document).ready(function() {
    $("#forgot_form").submit(function(event) {
        event.preventDefault();
        var dataToSend = new FormData(this);

        $.ajax({
            url: "/sside/passrecoverrequest.php",
            type: "POST",
            data: dataToSend,
            async: true,
            success: function(data) {
                console.log(data);

                if (data == "error") {
                    showError();
                    return;
                }

                if (data == "success") {
                    showSuccess();
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });
});

function showError() {
    $("#name").addClass("is-invalid");
    $("#error_par").text("Ошибка, проверьте введенные данные");
}

function showSuccess() {
    $("input").removeClass("is-invalid");
    $("input").addClass("is-valid");

    let par = $("#my_alert")
        .find("p")
        .first();
    $("#my_alert").removeClass("invisible");
    $("#my_alert").addClass("alert-success");
    par.html("На ваш email отправлено письмо для восстановления пароля, пройдите по ссылке в письме для завершения");
    $("#my_alert")
        .show()
        .delay(3500)
        .fadeOut();
    $("input[type=text]").val("");
}
