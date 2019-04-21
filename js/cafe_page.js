var inp_weight_weight;
var inp_weight_price;
var btn_add_weight;
var err_div_weight;
var div_for_weights;

var inp_add_name;
var inp_add_price;
var btn_add_add;
var err_div_add;
var div_for_adds;

var inp_milk_name;
var inp_milk_price;
var btn_add_milk;
var err_div_milk;
var div_for_milks;

var form_add_drink;
var form_add_desert;
var cafe_form_edit;

var err_div_name;
var err_div_description;
var err_div_logo;

var err_div_name_desert;
var err_div_description_desert;
var err_div_logo_desert;
var err_div_price_desert;

var btn_cafe_edit;
var numAddedWeight = 0;

var btn_delete_drink;
var btn_delete_desert;

var err_div_email;
var err_div_password;
var err_div_name_cafe_edit;
var err_div_ooo;
var err_div_adress_ur;
var err_div_okpo;
var err_div_adress_fact;
var err_div_dirfio;
var err_div_phone;
var err_div_time;
var err_div_inn;
var err_div_logo_cafe_edit;

var sub_nav_div_all;

var editMode = false;

$(document).ready(function ()
{
    init();

    $("#categ_my_cafe").click(function (e)
    {
        activaTab("myCafeTab");
    });

    $("#hot_drinks_cafe").click(function (e)
    {
        activaTab("hotDrinksTab");
    });

    $("#cold_drinks_cafe").click(function (e)
    {
        activaTab("coldDrinksTab");
    });

    $("#deserts_cafe").click(function (e)
    {
        console.log("clicked");
        activaTab("desertsTab");
    });

    $("#card_add").click(function (e)
    {
        $("#modal_add_drink").modal("show");
        $("#select_categ").val("0");
    });

    $("#card_add_cold").click(function (e)
    {
        $("#modal_add_drink").modal("show");
        $("#select_categ").val("1");
    });

    $("#card_add_desert").click(function (e)
    {
        $("#modal_add_desert").modal("show");
    });

    btn_cafe_edit.click(function ()
    {
        $("#modal_cafe_edit").modal("show");
    });

    sub_nav_div.click(function (e)
    {
        makeActiveTabcolor();
    });

    btn_add_weight.click(function (e)
    {
        makeAddWeight();
    });

    btn_add_add.click(function (e)
    {
        makeAddAdd();
    });

    btn_add_milk.click(function (e)
    {
        makeAddMilk();
    });

    btn_delete_drink.click(function (e)
    {
        let product_id = $("#modal_add_drink").attr("data-product-id");
        makeDeleteDrink(product_id);
    });

    btn_delete_desert.click(function (e)
    {
        let product_id = $("#modal_add_desert").attr("data-product-id");
        makeDeleteDrink(product_id);
    });


    cafe_form_edit.submit(function (event)
    {
        event.preventDefault();

        var dataToSend = new FormData(this);
        let cafe_id = $("[data-cafe-id]")
            .first()
            .attr("data-cafe-id");
        dataToSend.append("cafe_id", cafe_id);

        for (var pair of dataToSend.entries())
        {
            console.log(pair[0] + ", " + pair[1]);
        }

        $.ajax({
            url: "/sside/updatecafe.php",
            type: "POST",
            data: dataToSend,
            async: true,
            success: function (data)
            {
                console.log(data);

                if (isJson(data))
                {
                    data = $.parseJSON(data);
                }

                if ($.inArray("failed", data) > -1)
                {
                    showErrorsCafeUpdate(data);
                }

                if ($.inArray("success", data) > -1)
                {
                    if ($.inArray("pass", data) > -1)
                    {
                        //TODO make right urls
                        window.location.replace("/sside/logout.php?logout=1");
                    }

                    if ($.inArray("no_pass", data) > -1)
                    {
                        //TODO make right urls
                        location.reload();
                    }
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown)
            {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });

    form_add_desert.submit(function (event)
    {
        event.preventDefault();
        var dataToSend = new FormData(this);
        dataToSend.append("categ", "2");

        var url = "/sside/adddesert.php";
        if (editMode)
        {
            let product_id = $("#modal_add_desert").attr("data-product-id");
            url = "/sside/editdesert.php";

            dataToSend.append("product_id", product_id);
        }

        for (var pair of dataToSend.entries())
        {
            console.log(pair[0] + ", " + pair[1]);
        }

        $.ajax({
            url: url,
            type: "POST",
            data: dataToSend,
            async: true,
            success: function (data)
            {
                console.log(data);

                if (isJson(data))
                {
                    data = $.parseJSON(data);
                }

                if ($.inArray("failed", data) > -1)
                {
                    showErrorsDesert(data);
                }

                if ($.inArray("success", data) > -1)
                {
                    clearAll();
                    $("#modal_add_desert").modal("hide");
                    showSuccess();
                    loadAllData();
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown)
            {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });

    form_add_drink.submit(function (event)
    {
        event.preventDefault();
        var dataToSend = new FormData(this);

        var allWeightsRow = $("#div_for_weights").find(".row_line");
        var i = 0;
        allWeightsRow.each(function ()
        {
            let row = $(this);
            let weight = row
                .find("p")
                .eq(0)
                .text()
                .replace(/[^0-9]/gi, "");
            let price = row
                .find("p")
                .eq(1)
                .text()
                .replace(/[^0-9]/gi, "");

            let weight_name = "weight" + i;
            let price_name = "weight_price" + i;

            dataToSend.append(weight_name, weight);
            dataToSend.append(price_name, price);

            i++;
        });

        var allAddsRow = $("#div_for_adds").find(".row_line");
        var y = 0;

        allAddsRow.each(function ()
        {
            let row = $(this);
            let name = row
                .find("p")
                .eq(0)
                .text();
            let price = row
                .find("p")
                .eq(1)
                .text()
                .replace(/[^0-9]/gi, "");

            let name_name = "add" + y;
            let price_name = "add_price" + y;

            dataToSend.append(name_name, name);
            dataToSend.append(price_name, price);

            y++;
        });

        var allMilksRow = $("#div_for_milks").find(".row_line");
        var z = 0;
        allMilksRow.each(function ()
        {
            let row = $(this);
            let name = row
                .find("p")
                .eq(0)
                .text();
            let price = row
                .find("p")
                .eq(1)
                .text()
                .replace(/[^0-9]/gi, "");

            let name_name = "milk" + z;
            let price_name = "milk_price" + z;

            dataToSend.append(name_name, name);
            dataToSend.append(price_name, price);

            z++;
        });

        var url = "/sside/addproduct.php";
        if (editMode)
        {
            let product_id = $("#modal_add_drink").attr("data-product-id");
            url = "/sside/editproduct.php";

            dataToSend.append("product_id", product_id);
        }

        for (var pair of dataToSend.entries())
        {
            console.log(pair[0] + ", " + pair[1]);
        }

        $.ajax({
            url: url,
            type: "POST",
            data: dataToSend,
            async: true,
            success: function (data)
            {
                console.log(data);

                if (isJson(data))
                {
                    data = $.parseJSON(data);
                }

                if ($.inArray("failed", data) > -1)
                {
                    showErrors(data);
                }

                if ($.inArray("success", data) > -1)
                {
                    clearAll();
                    showSuccess();
                    $("#modal_add_drink").modal("hide");
                    loadAllData();
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown)
            {
                console.log(data);
            },
            cache: false,
            contentType: false,
            processData: false
        });

        return false;
    });

    loadAllData();

    $(document).on("show.bs.modal", "#modal_add_drink", function (e)
    {
        console.log("opens");
        let modal = $("#modal_add_drink");

        if (editMode)
        {
            modal.find(".modal_title").text("Редактирование продукта");
            modal.find(".modal_subtitle").text("Измените параметры уже добавленного продукта");
            modal.find('[type="submit"]').attr("value", "Сохранить");
            modal.find('#remove_drink_row').removeClass('d-none');
        } else
        {
            modal.find(".modal_title").text("Добавление продукта");
            modal
                .find(".modal_subtitle")
                .text("Добавьте новый продукт в меню приложения. Сразу после добавлния продукт станет доступен для заказа.");
            modal.find('[type="submit"]').attr("value", "Добавить");
            modal.find('#remove_drink_row').addClass('d-none');
        }
    });

    $("#modal_add_drink").on("hidden.bs.modal", function ()
    {
        editMode = false;
        clearAll();
        console.log("closed modal");
    });

    $(document).on("show.bs.modal", "#modal_add_desert", function (e)
    {
        console.log("opens");
        let modal = $("#modal_add_desert");

        if (editMode)
        {
            modal.find(".modal_title").text("Редактирование продукта");
            modal.find(".modal_subtitle").text("Измените параметры уже добавленного продукта");
            modal.find('[type="submit"]').attr("value", "Сохранить");
            modal.find('#remove_desert_row').removeClass('d-none');
        }
        else
        {
            modal.find(".modal_title").text("Добавление десерта");
            modal
                .find(".modal_subtitle")
                .text("Добавьте новый продукт в меню приложения. Сразу после добавлния продукт станет доступен для заказа.");
            modal.find('[type="submit"]').attr("value", "Добавить");
            modal.find('#remove_desert_row').addClass('d-none');
        }
    });

    $("#modal_add_desert").on("hidden.bs.modal", function ()
    {
        editMode = false;
        clearAll();
        console.log("closed modal");
    });
});

function loadAllData()
{
    loadHotDrinks();
    loadColdDrinks();
    loadDeserts();
}

function loadDeserts()
{
    let cafe_id = $("[data-cafe-id]")
        .first()
        .attr("data-cafe-id");

    var dataToSend = new FormData();
    dataToSend.append("cafe_id", cafe_id);
    dataToSend.append("categ", 2);

    $.ajax({
        url: "/sside/getproducts.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);
            if (isJson(data))
            {
                showDeserts(data);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            console.log(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function loadColdDrinks()
{
    let cafe_id = $("[data-cafe-id]")
        .first()
        .attr("data-cafe-id");

    var dataToSend = new FormData();
    dataToSend.append("cafe_id", cafe_id);
    dataToSend.append("categ", 1);

    $.ajax({
        url: "/sside/getproducts.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);
            if (isJson(data))
            {
                showColdDrinks(data);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            console.log(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function loadHotDrinks()
{
    let cafe_id = $("[data-cafe-id]")
        .first()
        .attr("data-cafe-id");

    var dataToSend = new FormData();
    dataToSend.append("cafe_id", cafe_id);
    dataToSend.append("categ", 0);

    $.ajax({
        url: "/sside/getproducts.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);
            if (isJson(data))
            {
                showHotDrinks(data);
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            console.log(errorThrown);
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function showDeserts(data)
{
    let row_for_deserts = $("#row_for_deserts");
    data = $.parseJSON(data);

    let allCurrentCards = row_for_deserts.find(".mycard");
    allCurrentCards.remove();

    jQuery.each(data, function (i, product)
    {
        let item = getHtmlElementFromProduct(product);
        row_for_deserts.append(item);
    });

    updateCardListeners();
}

function showHotDrinks(data)
{
    let row_for_hot_drinks = $("#row_for_hot_drinks");
    data = $.parseJSON(data);

    let allCurrentCards = row_for_hot_drinks.find(".mycard");
    allCurrentCards.remove();

    jQuery.each(data, function (i, product)
    {
        let item = getHtmlElementFromProduct(product);
        row_for_hot_drinks.append(item);
    });

    updateCardListeners();
}

function showColdDrinks(data)
{
    let row_for_cold_drinks = $("#row_for_cold_drinks");
    data = $.parseJSON(data);

    let allCurrentCards = row_for_cold_drinks.find(".mycard");
    allCurrentCards.remove();

    jQuery.each(data, function (i, product)
    {
        let item = getHtmlElementFromProduct(product);
        row_for_cold_drinks.append(item);
    });

    updateCardListeners();
}

function showErrorsCafeUpdate(data)
{
    if ($.inArray("password", data) > -1)
    {
        err_div_password.removeClass("invisible");
        let par = err_div_password.find("p").first();
        let input = err_div_password.prev("div").find("input");
        par.text("Введите пароль, минимум 8 символов.");
        input.addClass("input_box_error");
    } else
    {
        err_div_password.addClass("invisible");
        let par = err_div_password.find("p").first();
        let input = err_div_password.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("name", data) > -1)
    {
        err_div_name_cafe_edit.removeClass("invisible");
        let par = err_div_name_cafe_edit.find("p").first();
        let input = err_div_name_cafe_edit.prev("div").find("input");
        par.text("Введите название кафе.");
        input.addClass("input_box_error");
    } else
    {
        err_div_name_cafe_edit.addClass("invisible");
        let par = err_div_name_cafe_edit.find("p").first();
        let input = err_div_name_cafe_edit.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("ooo", data) > -1)
    {
        err_div_ooo.removeClass("invisible");
        let par = err_div_ooo.find("p").first();
        let input = err_div_ooo.prev("div").find("input");
        par.text("Введите название ООО или ИП.");
        input.addClass("input_box_error");
    } else
    {
        err_div_ooo.addClass("invisible");
        let par = err_div_ooo.find("p").first();
        let input = err_div_ooo.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("adress_ur", data) > -1)
    {
        err_div_adress_ur.removeClass("invisible");
        let par = err_div_adress_ur.find("p").first();
        let input = err_div_adress_ur.prev("div").find("input");
        par.text("Введите Юридический адресс кафе.");
        input.addClass("input_box_error");
    } else
    {
        err_div_adress_ur.addClass("invisible");
        let par = err_div_adress_ur.find("p").first();
        let input = err_div_adress_ur.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("okpo", data) > -1)
    {
        err_div_okpo.removeClass("invisible");
        let par = err_div_okpo.find("p").first();
        let input = err_div_okpo.prev("div").find("input");
        par.text("Введите ОКПО.");
        input.addClass("input_box_error");
    } else
    {
        err_div_okpo.addClass("invisible");
        let par = err_div_okpo.find("p").first();
        let input = err_div_okpo.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("adress_fact", data) > -1)
    {
        err_div_adress_fact.removeClass("invisible");
        let par = err_div_adress_fact.find("p").first();
        let input = err_div_adress_fact.prev("div").find("input");
        par.text("Введите Фактический адрес кафе.");
        input.addClass("input_box_error");
    } else
    {
        err_div_adress_fact.addClass("invisible");
        let par = err_div_adress_fact.find("p").first();
        let input = err_div_adress_fact.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("dirfio", data) > -1)
    {
        err_div_dirfio.removeClass("invisible");
        let par = err_div_dirfio.find("p").first();
        let input = err_div_dirfio.prev("div").find("input");
        par.text("Введите ФИО генерального директора кафе.");
        input.addClass("input_box_error");
    } else
    {
        err_div_dirfio.addClass("invisible");
        let par = err_div_dirfio.find("p").first();
        let input = err_div_dirfio.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("phone", data) > -1)
    {
        err_div_phone.removeClass("invisible");
        let par = err_div_phone.find("p").first();
        let input = err_div_phone.prev("div").find("input");
        par.text("Введите ФИО генерального директора кафе.");
        input.addClass("input_box_error");
    } else
    {
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
    )
    {
        err_div_time.removeClass("invisible");
        let par = err_div_time.find("p").first();

        let time1 = err_div_time.prev("div").find("#time1");
        let time2 = err_div_time.prev("div").find("#time2");
        let time3 = err_div_time.prev("div").find("#time3");
        let time4 = err_div_time.prev("div").find("#time4");

        if ($.inArray("hour_ot", data) > -1)
        {
            time1.addClass("input_box_error");
        } else
        {
            time1.removeClass("input_box_error");
        }

        if ($.inArray("minute_ot", data) > -1)
        {
            time2.addClass("input_box_error");
        } else
        {
            time2.removeClass("input_box_error");
        }

        if ($.inArray("hour_do", data) > -1)
        {
            time3.addClass("input_box_error");
        } else
        {
            time3.removeClass("input_box_error");
        }

        if ($.inArray("minute_do", data) > -1)
        {
            time4.addClass("input_box_error");
        } else
        {
            time4.removeClass("input_box_error");
        }

        par.text("Введите корректное время работы кафе.");
    } else
    {
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

    if ($.inArray("inn", data) > -1)
    {
        err_div_inn.removeClass("invisible");
        let par = err_div_inn.find("p").first();
        let input = err_div_inn.prev("div").find("input");
        par.text("Введите ИНН кафе.");
        input.addClass("input_box_error");
    } else
    {
        err_div_inn.addClass("invisible");
        let par = err_div_inn.find("p").first();
        let input = err_div_inn.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("logo", data) > -1)
    {
        err_div_logo_cafe_edit.removeClass("invisible");
        let par = err_div_logo_cafe_edit.find("p").first();
        let input = err_div_logo_cafe_edit.prev("div").find("#file_input_div");
        par.text("Добавьте логотип кафе");
        input.addClass("input_box_error");
    } else
    {
        err_div_logo_cafe_edit.addClass("invisible");
        let par = err_div_logo_cafe_edit.find("p").first();
        let input = err_div_logo_cafe_edit.prev("div").find("#file_input_div");
        par.text("");
        input.removeClass("input_box_error");
    }
}

function showErrorsDesert(data)
{
    if ($.inArray("name", data) > -1)
    {
        err_div_name_desert.removeClass("invisible");
        let par = err_div_name_desert.find("p").first();
        let input = err_div_name_desert.prev("div").find("input");
        par.text("Заполните поле Название.");
        input.addClass("input_box_error");
    } else
    {
        err_div_name_desert.addClass("invisible");
        let par = err_div_name_desert.find("p").first();
        let input = err_div_name_desert.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("description", data) > -1)
    {
        err_div_description_desert.removeClass("invisible");
        let par = err_div_description_desert.find("p").first();
        let input = err_div_description_desert.prev("div").find("textarea");
        par.text("Заполните поле Описание");
        input.addClass("input_box_error");
    } else
    {
        err_div_description_desert.addClass("invisible");
        let par = err_div_description_desert.find("p").first();
        let input = err_div_description_desert.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("price", data) > -1)
    {
        err_div_price_desert.removeClass("invisible");
        let par = err_div_price_desert.find("p").first();
        let input = err_div_price_desert.prev("div").find("input");
        par.text("Заполните поле Цена");
        input.addClass("input_box_error");
    } else
    {
        err_div_price_desert.addClass("invisible");
        let par = err_div_price_desert.find("p").first();
        let input = err_div_price_desert.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("img_product", data) > -1)
    {
        err_div_logo_desert.removeClass("invisible");
        let par = err_div_logo_desert.find("p").first();
        let input = err_div_logo_desert.prev("div").find("#file_input_div");
        par.text("Добавьте изображение продукта");
        input.addClass("input_box_error");
    } else
    {
        err_div_logo_desert.addClass("invisible");
        let par = err_div_logo_desert.find("p").first();
        let input = err_div_logo_desert.prev("div").find("#file_input_div");
        par.text("");
        input.removeClass("input_box_error");
    }
}

function showErrors(data)
{
    if ($.inArray("name", data) > -1)
    {
        err_div_name.removeClass("invisible");
        let par = err_div_name.find("p").first();
        let input = err_div_name.prev("div").find("input");
        par.text("Заполните поле Название.");
        input.addClass("input_box_error");
    } else
    {
        err_div_name.addClass("invisible");
        let par = err_div_name.find("p").first();
        let input = err_div_name.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("description", data) > -1)
    {
        err_div_description.removeClass("invisible");
        let par = err_div_description.find("p").first();
        let input = err_div_description.prev("div").find("input");
        par.text("Заполните поле Описание");
        input.addClass("input_box_error");
    } else
    {
        err_div_description.addClass("invisible");
        let par = err_div_description.find("p").first();
        let input = err_div_description.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("weight", data) > -1)
    {
        err_div_weight.removeClass("invisible");
        let par = err_div_weight.find("p").first();
        let input = err_div_weight.prev("div").find("input");
        par.text("Добавьте минимум один объем");
        input.addClass("input_box_error");
    } else
    {
        err_div_weight.addClass("invisible");
        let par = err_div_weight.find("p").first();
        let input = err_div_weight.prev("div").find("input");
        par.text("");
        input.removeClass("input_box_error");
    }

    if ($.inArray("img_product", data) > -1)
    {
        err_div_logo.removeClass("invisible");
        let par = err_div_logo.find("p").first();
        let input = err_div_logo.prev("div").find("#file_input_div");
        par.text("Добавьте изображение продукта");
        input.addClass("input_box_error");
    } else
    {
        err_div_logo.addClass("invisible");
        let par = err_div_logo.find("p").first();
        let input = err_div_logo.prev("div").find("#file_input_div");
        par.text("");
        input.removeClass("input_box_error");
    }
}

function clearAll()
{
    var allWeightsRow = $(".row_line");
    allWeightsRow.remove();
    let allErrorDivs = $(".clearInputs");
    allErrorDivs.addClass("invisible");
    $("input[type=text]").val("");
    $("textarea[type=text]").text("");

    $("#img_product").val(null);
    $("#logo_logo").attr("src", "#");
    $("#logo_logo").addClass("invisible");
    $("#current_logo_name").html("");
    $("#description").val("");

    $("#img_product_desert").val(null);
    $("#logo_logo_desert").attr("src", "#");
    $("#logo_logo_desert").addClass("invisible");
    $("#current_logo_name_desert").html("");
    $("#description_desert").val("");
}

function showSuccess()
{
    var message = "Продукт успешно добавлен";
    if (editMode)
    {
        message = "Продукт успешно изменен";
    }
    $("#my_alert").addClass("alert-success");
    $("#alert-fixed").removeClass("invisible");
    let par = $("#my_alert")
        .find("p")
        .first();
    par.html(message);
    $("#my_alert")
        .show()
        .delay(3500)
        .fadeOut();
}

function showDeleteSuccess()
{
    var message = "Продукт удален";

    $("#my_alert").addClass("alert-success");
    $("#alert-fixed").removeClass("invisible");
    let par = $("#my_alert")
        .find("p")
        .first();
    par.html(message);
    $("#my_alert")
        .show()
        .delay(3500)
        .fadeOut();
}

function makeAddMilk()
{
    var name = inp_milk_name.val();
    var price = inp_milk_price.val().replace(/[^0-9]/gi, "");

    if (name.length < 1 || price.length < 1)
    {
        err_div_milk.removeClass("invisible");
        let par = err_div_milk.find("p").first();
        par.text("Введите корректные данные");
        return;
    }

    err_div_milk.addClass("invisible");

    var newRow =
        `
        <div class="row_line">
            <p class="third d-inline-block text-center mb-0">` +
        name +
        `</p>
            <p class="third third-center d-inline-block text-center mb-0">` +
        price +
        "р" +
        `</p>
            <div class="third d-inline-block text-center">
                <p class="remove_circle d-inline-block mb-0">×</p>
            </div>
        </div>`;
    div_for_milks.append(newRow);

    updateRemoveCircles();

    inp_milk_name.val("");
    inp_milk_price.val("");
}

function makeAddAdd()
{
    var name = inp_add_name.val();
    var price = inp_add_price.val().replace(/[^0-9]/gi, "");

    if (name.length < 1 || price.length < 1)
    {
        err_div_add.removeClass("invisible");
        let par = err_div_add.find("p").first();
        par.text("Введите корректные данные");
        return;
    }

    err_div_add.addClass("invisible");

    var newRow =
        `
        <div class="row_line">
            <p class="third d-inline-block text-center mb-0">` +
        name +
        `</p>
            <p class="third third-center d-inline-block text-center mb-0">` +
        price +
        `р</p>
            <div class="third d-inline-block text-center">
                <p class="remove_circle d-inline-block mb-0">×</p>
            </div> 
        </div>
        `;

    div_for_adds.append(newRow);

    updateRemoveCircles();

    inp_add_name.val("");
    inp_add_price.val("");
}

function makeAddWeight()
{
    var weight = inp_weight_weight.val().replace(/[^0-9]/gi, "");
    var price = inp_weight_price.val().replace(/[^0-9]/gi, "");

    if (weight.length < 1 || price.length < 1)
    {
        err_div_weight.removeClass("invisible");
        let par = err_div_weight.find("p").first();
        par.text("Введите корректные данные");
        return;
    }

    err_div_weight.addClass("invisible");

    var newRow =
        `
        <div class="row_line">
            <p class="third d-inline-block text-center mb-0">` +
        weight +
        `мл</p>
            <p class="third third-center d-inline-block text-center mb-0">` +
        price +
        "р" +
        `</p>
            <div class="third d-inline-block text-center">
                <p class="remove_circle d-inline-block mb-0">×</p>
            </div>
        </div>
        `;
    div_for_weights.append(newRow);

    updateRemoveCircles();

    inp_weight_weight.val("");
    inp_weight_price.val("");
}

function updateRemoveCircles()
{
    var weightRows = $(".row_line");
    weightRows.each(function ()
    {
        let row = $(this);
        var btn = $(this).find(".remove_circle");
        btn.unbind("click").click(function ()
        {
            row.remove();
        });
    });
}

function updateCardListeners()
{
    var allCards = $(".mycard");
    allCards.unbind("click").click(function ()
    {
        let card = $(this);
        let product_id = card.attr("data-product-id");

        $.ajax({
            url: "/sside/getproductbyid.php",
            type: "POST",
            data: jQuery.param({product_id: product_id}),
            async: true,
            success: function (data)
            {
                console.log(data);

                if (isJson(data))
                {
                    data = $.parseJSON(data);
                    if (data["categ"] == 0 || data["categ"] == 1)
                    {
                        editMode = true;
                        showEditDrinkModal(data);
                    }

                    if (data["categ"] == 2)
                    {
                        editMode = true;
                        showEditDesertModal(data);
                    }
                }
            },
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            cache: false
        });

        return false;
    });
}

function showEditDesertModal(data)
{
    editMode = true;

    let modal = $("#modal_add_desert");
    modal.attr("data-product-id", data["id"]);

    let price = Math.round(data["price"]);
    modal.find('[name="name"]').val(data["name"]);
    modal.find('[name="price"]').val(price);
    modal.find("#description_desert").val(data["description"]);

    modal.find("#logo_logo_desert").attr("src", "/images/products/" + data["img_name"]);
    modal.find("#logo_logo_desert").removeClass("invisible");

    modal.modal("show");
}

function showEditDrinkModal(data)
{
    editMode = true;

    let modal = $("#modal_add_drink");

    modal.attr("data-product-id", data["id"]);

    modal.find('[name="name"]').val(data["name"]);
    modal.find('[name="categ"]').val(data["categ"]);
    modal.find("#description").val(data["description"]);

    modal.find("#logo_logo").attr("src", "/images/products/" + data["img_name"]);
    modal.find("#logo_logo").removeClass("invisible");

    let div_for_weights = modal.find("#div_for_weights");
    let weights = data["listOfWeights"];
    $.each(weights, function (i, item)
    {
        let row = getWeightHtmlElement(item);
        div_for_weights.append(row);
    });

    let div_for_adds = modal.find("#div_for_adds");
    let adds = data["listOfAdds"];
    $.each(adds, function (i, item)
    {
        let row = getAddOrMilkHtmlElement(item);
        div_for_adds.append(row);
    });

    let div_for_milks = modal.find("#div_for_milks");
    let milks = data["listOfMilks"];
    $.each(milks, function (i, item)
    {
        let row = getAddOrMilkHtmlElement(item);
        div_for_milks.append(row);
    });

    updateRemoveCircles();

    modal.modal("show");
}

function init()
{
    inp_weight_weight = $("#inp_weight_weight");
    inp_weight_price = $("#inp_weight_price");
    btn_add_weight = $("#btn_add_weight");
    err_div_weight = $("#err_div_weight");
    div_for_weights = $("#div_for_weights");

    inp_add_name = $("#inp_add_name");
    inp_add_price = $("#inp_add_price");
    btn_add_add = $("#btn_add_add");
    err_div_add = $("#err_div_add");
    div_for_adds = $("#div_for_adds");

    inp_milk_name = $("#inp_milk_name");
    inp_milk_price = $("#inp_milk_price");
    btn_add_milk = $("#btn_add_milk");
    err_div_milk = $("#err_div_milk");
    div_for_milks = $("#div_for_milks");

    form_add_drink = $("#form_add_drink");
    form_add_desert = $("#form_add_desert");
    cafe_form_edit = $("#cafe_form_edit");

    err_div_name = $("#err_div_name");
    err_div_description = $("#err_div_description");
    err_div_logo = $("#err_div_logo");

    err_div_name_desert = $("#err_div_name_desert");
    err_div_description_desert = $("#err_div_description_desert");
    err_div_logo_desert = $("#err_div_logo_desert");
    err_div_price_desert = $("#err_div_price_desert");

    btn_cafe_edit = $("#btn_cafe_edit");

    err_div_email = $("#err_div_email");
    err_div_password = $("#err_div_password");
    err_div_name_cafe_edit = $("#err_div_name_cafe_edit");
    err_div_ooo = $("#err_div_ooo");
    err_div_adress_ur = $("#err_div_adress_ur");
    err_div_okpo = $("#err_div_okpo");
    err_div_adress_fact = $("#err_div_adress_fact");
    err_div_dirfio = $("#err_div_dirfio");
    err_div_phone = $("#err_div_phone");
    err_div_time = $("#err_div_time");
    err_div_inn = $("#err_div_inn");
    err_div_logo_cafe_edit = $("#err_div_logo_cafe_edit");
    err_div_agree = $("#err_div_agree");

    sub_nav_div = $(".sub_nav_div");

    btn_delete_drink = $('#btn_delete_drink');
    btn_delete_desert = $('#btn_delete_desert');
}

function activaTab(tab)
{
    $('.nav-tabs a[href="#' + tab + '"]').tab("show");
}

$("#img_product").change(function ()
{
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg"))
    {
        var reader = new FileReader();

        reader.onload = function (e)
        {
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

$("#img_product_desert").change(function ()
{
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
    if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg"))
    {
        var reader = new FileReader();

        reader.onload = function (e)
        {
            $("#logo_logo_desert").removeClass("invisible");
            $("#logo_logo_desert").attr("src", e.target.result);
        };

        reader.readAsDataURL(input.files[0]);

        var filename = $(this)
            .val()
            .split("\\")
            .pop();
        $("#current_logo_name_desert").html(filename);
    }
});

function isJson(str)
{
    try
    {
        JSON.parse(str);
    } catch (e)
    {
        return false;
    }
    return true;
}

function getHtmlElementFromProduct(product)
{
    var price = "0";
    if (Object.keys(product["listOfWeights"]).length > 0)
    {
        price = Math.round(product["listOfWeights"][0]["price"]) + "р";
    } else
    {
        price = Math.round(product["price"]) + "р";
    }

    let text =
        `<div class="col-sm-12 col-md-4 col-lg-3 mycard" data-product-id="` +
        product["id"] +
        `">
            <div class="product_card position-relative">
                 <img class="product_img mt-3" src="/images/products/` +
        product["img_name"] +
        `">
                 <h4 class="text-center product_name pl-3 pr-3 mt-3 mb-3">` +
        product["name"] +
        `</h4>
                 <p class="product_desc pl-2 pr-2 text-left">` +
        product["description"] +
        `</p>
                 <p class="count_p position-absolute mb-2 ml-3"><span class="count_span">248</span> заказов</p>
                 <p class="price position-absolute mb-2 mr-3">` +
        price +
        `</p>
            </div>
        </div>
            `;

    return text;
}

function getWeightHtmlElement(weight)
{
    var newRow =
        `
        <div class="row_line">
            <p class="third d-inline-block text-center mb-0">` +
        weight["weight"] +
        `мл</p>
            <p class="third third-center d-inline-block text-center mb-0">` +
        Math.round(weight["price"]) +
        "р" +
        `</p>
            <div class="third d-inline-block text-center">
                <p class="remove_circle d-inline-block mb-0">×</p>
            </div>
        </div>
        `;

    return newRow;
}

function getAddOrMilkHtmlElement(item)
{
    var newRow =
        `
        <div class="row_line">
            <p class="third d-inline-block text-center mb-0">` +
        item["text"] +
        `</p>
            <p class="third third-center d-inline-block text-center mb-0">` +
        Math.round(item["price"]) +
        `р</p>
            <div class="third d-inline-block text-center">
                <p class="remove_circle d-inline-block mb-0">×</p>
            </div> 
        </div>
        `;

    return newRow;
}

function makeDeleteDrink(productId)
{
    var dataToSend = new FormData();
    dataToSend.append("product_id", productId);

    $.ajax({
        url: "/sside/deleteproduct.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);

            if (data == 'success')
            {
                clearAll();
                $("#modal_add_drink").modal("hide");
                $("#modal_add_desert").modal("hide");
                loadAllData();
                showDeleteSuccess();
            }
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            console.log(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });

};

function makeActiveTabcolor()
{
    let active_link = $("#ul_sub_links")
        .find(".active")
        .first();
    let selected_num = active_link.attr("data-tab-num");

    let img_cafe = $("#categ_my_cafe")
        .find("img")
        .first();
    let img_hot = $("#hot_drinks_cafe")
        .find("img")
        .first();
    let img_cold = $("#cold_drinks_cafe")
        .find("img")
        .first();
    let img_desert = $("#deserts_cafe")
        .find("img")
        .first();

    let name_cafe = $("#categ_my_cafe")
        .find(".div_categ_name")
        .first();
    let name_hot = $("#hot_drinks_cafe")
        .find(".div_categ_name")
        .first();
    let name_cold = $("#cold_drinks_cafe")
        .find(".div_categ_name")
        .first();
    let name_desert = $("#deserts_cafe")
        .find(".div_categ_name")
        .first();

    if (selected_num == 0)
    {
        img_cafe.attr("src", "/images/user_grad.png");
        name_cafe.addClass("grad-text");
    } else
    {
        img_cafe.attr("src", "/images/user.png");
        name_cafe.removeClass("grad-text");
    }

    if (selected_num == 1)
    {
        img_hot.attr("src", "/images/hot_grad.png");
        name_hot.addClass("grad-text");
    } else
    {
        img_hot.attr("src", "/images/hot.png");
        name_hot.removeClass("grad-text");
    }

    if (selected_num == 2)
    {
        img_cold.attr("src", "/images/cold_grad.png");
        name_cold.addClass("grad-text");
    } else
    {
        img_cold.attr("src", "/images/cold.png");
        name_cold.removeClass("grad-text");
    }

    if (selected_num == 3)
    {
        img_desert.attr("src", "/images/desert_grad.png");
        name_desert.addClass("grad-text");
    } else
    {
        img_desert.attr("src", "/images/desert.png");
        name_desert.removeClass("grad-text");
    }
}
