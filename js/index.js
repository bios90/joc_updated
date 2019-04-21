let reg_form;
let login_form;
let err_div_email;
let err_div_password;
let err_div_name;
let err_div_ooo;
let err_div_adress_ur;
let err_div_okpo;
let err_div_adress_fact;
let err_div_dirfio;
let err_div_phone;
let err_div_time;
let err_div_inn;
let err_div_logo;

$(document).ready(function() {
    init();

    reg_form = $("#reg_form");
    login_form = $("#login_form");

    reg_form.submit(function(event) {
        event.preventDefault();
        // var dataToSend = $(this).serializeArray();
        var dataToSend = new FormData(this);
        console.log($(this).serializeArray());

        $.ajax({
            url: "/sside/register.php",
            type: "POST",
            data: dataToSend,
            async: true,
            success: function(data) {
                console.log(data);
                data = $.parseJSON(data);

                if ($.inArray("failed", data) > -1) {
                    showErrors(data);
                }

                if ($.inArray("success", data) > -1) {
                    clearInputs();
                    $("#modal_reg").modal("hide");
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

    login_form.submit(function(event) {
        event.preventDefault();
        var dataToSend = new FormData(this);
        console.log($(this).serializeArray());

        $.ajax({
            url: "/sside/login.php",
            type: "POST",
            data: dataToSend,
            async: true,
            success: function(data) {
                console.log(data);
                data = $.parseJSON(data);

                if ($.inArray("failed", data) > -1) {
                    showLoginErrors(data);
                    return;
                }

                if ($.inArray("success", data) > -1) {
                    window.location.reload(true);
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });

    $("#reg_cafe_logo").change(function() {
        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $("#logo_logo").removeClass("invisible");
                $("#logo_logo").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);

            var filename = $(this)
                .val()
                .split("\\")
                .pop();
            $("#current_logo_name").html(filename);
        }
    });

    $("#btn_connect").click(function() {
        let logged = $("[data-logged]")
            .first()
            .attr("data-logged");

        if (logged == 1) {
            window.location.replace("https://justordercompany.com/cafe_page.php");
        } else {
            $("#modal_reg").modal("show");
        }
    });
});

function init() {
    err_div_email = $("#err_div_email");
    err_div_password = $("#err_div_password");
    err_div_name = $("#err_div_name");
    err_div_ooo = $("#err_div_ooo");
    err_div_adress_ur = $("#err_div_adress_ur");
    err_div_okpo = $("#err_div_okpo");
    err_div_adress_fact = $("#err_div_adress_fact");
    err_div_dirfio = $("#err_div_dirfio");
    err_div_phone = $("#err_div_phone");
    err_div_time = $("#err_div_time");
    err_div_inn = $("#err_div_inn");
    err_div_logo = $("#err_div_logo");
    err_div_agree = $("#err_div_agree");
}

function showSuccess() {
    $("#my_alert").addClass("alert-success");
    $("#alert-fixed").removeClass("invisible");
    let par = $("#my_alert")
        .find("p")
        .first();
    par.html("Ваша заявка успешно отправлена, в ближайшее время мы свяжемся с вами.");
    $("#my_alert")
        .show()
        .delay(3500)
        .fadeOut();
}

function clearInputs() {
    let allErrorDivs = $(".clearInputs");
    allErrorDivs.addClass("invisible");
    $("input[type=text]").val("");
    $("#reg_cafe_logo").val(null);
    $("#logo_logo").attr("src", "#");
    $("#current_logo_name").html("");
}

function showLoginErrors(data) {

    let message;
    if($.inArray('status',data) > -1)
    {
        message='Ваша зявка находится на рассмотрении';
    }
    else
        {
            message = 'Проверьте введенные данные';
        }

    let err_div_login = $("#err_div_login");
    err_div_login.removeClass("invisible");
    let par = err_div_login.find("p").first();
    let input = $("#login_inputs_container").find("input");
    par.text(message);
    input.addClass("input_box_error");
}

function showErrors(data) {
    console.log(data);

    if ($.inArray("email", data) > -1 || $.inArray("email_already", data) > -1) {
        err_div_email.removeClass("invisible");
        let par = err_div_email.find("p").first();
        let input = err_div_email.prev("div").find("input");
        if ($.inArray("email_already", data) > -1) {
            par.text("Данный email уже занят");
        } else {
            par.text("Введите корректный email");
        }

        input.addClass("input_box_error");
    } else {
        err_div_email.addClass("invisible");
        let par = err_div_email.find("p").first();
        let input = err_div_email.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("password", data) > -1) {
        err_div_password.removeClass("invisible");
        let par = err_div_password.find("p").first();
        let input = err_div_password.prev("div").find("input");
        par.text("Введите пароль, минимум 8 символов.");
        input.addClass("input_box_error");
    } else {
        err_div_password.addClass("invisible");
        let par = err_div_password.find("p").first();
        let input = err_div_password.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("name", data) > -1) {
        err_div_name.removeClass("invisible");
        let par = err_div_name.find("p").first();
        let input = err_div_name.prev("div").find("input");
        par.text("Введите название кафе.");
        input.addClass("input_box_error");
    } else {
        err_div_name.addClass("invisible");
        let par = err_div_name.find("p").first();
        let input = err_div_name.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("ooo", data) > -1) {
        err_div_ooo.removeClass("invisible");
        let par = err_div_ooo.find("p").first();
        let input = err_div_ooo.prev("div").find("input");
        par.text("Введите название ООО или ИП.");
        input.addClass("input_box_error");
    } else {
        err_div_ooo.addClass("invisible");
        let par = err_div_ooo.find("p").first();
        let input = err_div_ooo.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("adress_ur", data) > -1) {
        err_div_adress_ur.removeClass("invisible");
        let par = err_div_adress_ur.find("p").first();
        let input = err_div_adress_ur.prev("div").find("input");
        par.text("Введите Юридический адресс кафе.");
        input.addClass("input_box_error");
    } else {
        err_div_adress_ur.addClass("invisible");
        let par = err_div_adress_ur.find("p").first();
        let input = err_div_adress_ur.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("okpo", data) > -1) {
        err_div_okpo.removeClass("invisible");
        let par = err_div_okpo.find("p").first();
        let input = err_div_okpo.prev("div").find("input");
        par.text("Введите ОКПО.");
        input.addClass("input_box_error");
    } else {
        err_div_okpo.addClass("invisible");
        let par = err_div_okpo.find("p").first();
        let input = err_div_okpo.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("adress_fact", data) > -1) {
        err_div_adress_fact.removeClass("invisible");
        let par = err_div_adress_fact.find("p").first();
        let input = err_div_adress_fact.prev("div").find("input");
        par.text("Введите Фактический адрес кафе.");
        input.addClass("input_box_error");
    } else {
        err_div_adress_fact.addClass("invisible");
        let par = err_div_adress_fact.find("p").first();
        let input = err_div_adress_fact.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("dirfio", data) > -1) {
        err_div_dirfio.removeClass("invisible");
        let par = err_div_dirfio.find("p").first();
        let input = err_div_dirfio.prev("div").find("input");
        par.text("Введите ФИО генерального директора кафе.");
        input.addClass("input_box_error");
    } else {
        err_div_dirfio.addClass("invisible");
        let par = err_div_dirfio.find("p").first();
        let input = err_div_dirfio.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("phone", data) > -1) {
        err_div_phone.removeClass("invisible");
        let par = err_div_phone.find("p").first();
        let input = err_div_phone.prev("div").find("input");
        par.text("Введите ФИО генерального директора кафе.");
        input.addClass("input_box_error");
    } else {
        err_div_phone.addClass("invisible");
        let par = err_div_phone.find("p").first();
        let input = err_div_phone.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if (
        $.inArray("hour_ot", data) > -1 ||
        $.inArray("minute_ot", data) > -1 ||
        $.inArray("hour_do", data) > -1 ||
        $.inArray("minute_do", data) > -1
    ) {
        err_div_time.removeClass("invisible");
        let par = err_div_time.find("p").first();

        let time1 = err_div_time.prev("div").find("#time1");
        let time2 = err_div_time.prev("div").find("#time2");
        let time3 = err_div_time.prev("div").find("#time3");
        let time4 = err_div_time.prev("div").find("#time4");

        if ($.inArray("hour_ot", data) > -1) {
            time1.addClass("input_box_error");
        } else {
            time1.removeClass("input_box_error");
        }

        if ($.inArray("minute_ot", data) > -1) {
            time2.addClass("input_box_error");
        } else {
            time2.removeClass("input_box_error");
        }

        if ($.inArray("hour_do", data) > -1) {
            time3.addClass("input_box_error");
        } else {
            time3.removeClass("input_box_error");
        }

        if ($.inArray("minute_do", data) > -1) {
            time4.addClass("input_box_error");
        } else {
            time4.removeClass("input_box_error");
        }

        par.text("Введите корректное время работы кафе.");
    } else {
        err_div_time.addClass("invisible");
        let par = err_div_time.find("p").first();

        let time1 = err_div_time.prev("div").find("#time1");
        let time2 = err_div_time.prev("div").find("#time2");
        let time3 = err_div_time.prev("div").find("#time3");
        let time4 = err_div_time.prev("div").find("#time4");
        par.text("");

        time1.removeClass("input_box_error");
        time2.removeClass("input_box_error");
        time3.removeClass("input_box_error");
        time4.removeClass("input_box_error");
    }

    if ($.inArray("inn", data) > -1) {
        err_div_inn.removeClass("invisible");
        let par = err_div_inn.find("p").first();
        let input = err_div_inn.prev("div").find("input");
        par.text("Введите ИНН кафе.");
        input.addClass("input_box_error");
    } else {
        err_div_inn.addClass("invisible");
        let par = err_div_inn.find("p").first();
        let input = err_div_inn.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("logo", data) > -1) {
        err_div_logo.removeClass("invisible");
        let par = err_div_logo.find("p").first();
        let input = err_div_logo.prev("div").find("#file_input_div");
        par.text("Добавьте логотип кафе");
        input.addClass("input_box_error");
    } else {
        err_div_logo.addClass("invisible");
        let par = err_div_logo.find("p").first();
        let input = err_div_logo.prev("div").find("#file_input_div");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("agree", data) > -1) {
        err_div_agree.removeClass("invisible");
        let par = err_div_agree.find("p").first();
        let input = err_div_agree.prev("div").find("input");
        par.text("Необходимо подтвердить согласие с условиями договора");
        input.addClass("input_box_error");
    } else {
        err_div_agree.addClass("invisible");
        let par = err_div_agree.find("p").first();
        let input = err_div_agree.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }
}


function showStatusError() {
    $("#my_alert").addClass("alert-warning");
    $("#alert-fixed").removeClass("invisible");
    let par = $("#my_alert")
        .find("p")
        .first();
    par.html("Ваша заявка находится на рассмотрении.");
    $("#my_alert")
        .show()
        .delay(3500)
        .fadeOut();
}
