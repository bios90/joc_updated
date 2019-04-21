var editMode = false;
var last_id;

$(document).ready(function ()
{
    $('#btn_add_news').click(function (e)
    {
        $('#modal_add_news').modal('show');
    });

    $("#img_news").change(function ()
    {
        console.log('changed');

        var input = this;
        var url = $(this).val();
        var ext = url.substring(url.lastIndexOf(".") + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "png" || ext == "jpeg" || ext == "jpg"))
        {
            var reader = new FileReader();

            reader.onload = function (e)
            {
                $("#logo_news").removeClass("invisible");
                $("#logo_news").attr("src", e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    });

    $('#form_add_news').submit(function (event)
    {
        event.preventDefault();
        var dataToSend = new FormData(this);

        if (editMode)
        {
            dataToSend.append('news_id',last_id);
            updateNews(dataToSend);
        }
        else
        {
            addNewNews(dataToSend);
        }

    });

    $('.nav-tabs').find('#newsTabLabel').on('shown.bs.tab', function ()
    {
        requestNews();
    });

    $(document).on("hidden.bs.modal", "#modal_add_news", function (e)
    {
        editMode = false;
        clearInputs();
    });

    $(document).on("show.bs.modal", "#modal_add_news", function (e)
    {
        if (editMode)
        {
            $('#add_news_btn').attr('value','Сохранить');
            requestNewsInfo();
        }
        else
            {
                $('#add_news_btn').attr('value','Добавить');
            }
    });
});


function showErrors(data)
{
    if ($.inArray("text", data) > -1)
    {
        $('#inp_text').addClass("input_box_error");
    } else
    {
        $('#inp_text').removeClass("input_box_error");
    }

    if ($.inArray("title", data) > -1)
    {
        $('#inp_title').addClass("input_box_error");
    } else
    {
        $('#inp_title').removeClass("input_box_error");
    }
}

function clearInputs()
{
    $("input[type=text]").val("");
    $("textarea[type=text]").val("");

    $("#img_news").val(null);
    $("#logo_news").attr("src", "#");
    $("#logo_news").addClass("invisible");

    $('#btn_delete_div').addClass('d-none');
}

function showSuccess()
{
    var message = "Новость добавлена";
    if(editMode)
    {
        message = 'Новость успешно отредактирована';
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

function requestNews()
{
    var dataToSend = new FormData();

    $.ajax({
        url: "/sside/getallnews.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            displayNews(data);

        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {

        },
        cache: false,
        contentType: false,
        processData: false
    });
}


function displayNews(data)
{
    $('#tab_news').html('');
    $('#tab_news').html(data);

    updateEditListeners();
}

function updateEditListeners()
{
    $('.btn-edit-news').click(function (e)
    {
        editMode = true;
        $id = $(this).attr('data-news-id');
        last_id = $id;

        $('#modal_add_news').modal('show');
    });

    $('#btn_delete_news').click(function (e)
    {
        makeDeleteNews();
    });
}

function addNewNews(dataToSend)
{
    $.ajax({
        url: "/sside/addnews.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);

            data = $.parseJSON(data);

            if ($.inArray("failed", data) > -1)
            {
                showErrors(data);
            }

            if ($.inArray("success", data) > -1)
            {
                clearInputs();
                $("#modal_add_news").modal("hide");
                showSuccess();
                requestNews();
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function updateNews(dataToSend)
{
    $.ajax({
        url: "/sside/updatenews.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);

            data = $.parseJSON(data);


            if ($.inArray("success", data) > -1)
            {
                clearInputs();
                $("#modal_add_news").modal("hide");
                showSuccess();
                requestNews();
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function requestNewsInfo()
{
    var dataToSend = new FormData();
    dataToSend.append("news_id", last_id);

    $.ajax({
        url: "/sside/requestnewsinfo.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);

            if (isJson(data))
            {
                loadInfoToModal(data);
            }

        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {

        },
        cache: false,
        contentType: false,
        processData: false
    });
}

function loadInfoToModal(data)
{
    data = JSON.parse(data);

    clearInputs();

    $('#inp_title').val(data['title']);
    $('#inp_text').val(data['text']);

    if (data['image'] != null)
    {
        $("#logo_news").attr("src", "/images/news/" + data["image"]);
        $("#logo_news").removeClass("invisible");
    }

    $('#btn_delete_div').removeClass('d-none');
}


function makeDeleteNews()
{
    var dataToSend = new FormData();
    dataToSend.append("news_id", last_id);

    $.ajax({
        url: "/sside/deletenews.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);
            clearInputs();
            $("#modal_add_news").modal("hide");
            showDeleteSuccess()
            requestNews();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {

        },
        cache: false,
        contentType: false,
        processData: false
    });
}

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

function showDeleteSuccess()
{
    var message = "Новость удалена";

    $("#my_alert").addClass("alert-warning");
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