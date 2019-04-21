

var last_sort = null;


$(document).ready(function ()
{
    init();
    setListeners();

    $('.nav-tabs').find('#myCafeTabLabel').on('shown.bs.tab', function ()
    {
        requestCafes(null);
    });
    
});




function setListeners()
{
    $('#sort_cafe').click(function(event)
    {
        event.preventDefault();
        last_sort = "name";
        requestCafes();
    });

    $('#sort_adress').click(function(event)
    {
        event.preventDefault();
        last_sort = "adress_fact";
        requestCafes();
    });

    $('#sort_dir').click(function(event)
    {
        event.preventDefault();
        last_sort = "dirfio";
        requestCafes();
    });

    $('#sort_phone').click(function(event)
    {
        event.preventDefault();
        last_sort = "phone";
        requestCafes();
    });

    $('#sort_email').click(function(event)
    {
        event.preventDefault();
        last_sort = "email";
        requestCafes();
    });

    $('#sort_status').click(function (event)
    {
        event.preventDefault();
        last_sort = "status";
        requestCafes();
    });
}


function requestCafes()
{
    var dataToSend = new FormData();

    if(last_sort != null)
    {
        dataToSend.append('sort', last_sort);
    }

    $.ajax({
        url: "/sside/getcafetable.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {

            if(data != 'error')
            {
                displayTable(data);
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

function displayTable(data)
{
    $('[data-toggle="tooltip"]').tooltip('dispose');
    $('#allcafes_tbody').html('');
    $('#allcafes_tbody').html(data);
    $('[data-toggle="tooltip"]').tooltip();
    if(data.length > 10)
    {
        $('#all_cafes_table').removeClass('invisible');
    }

    updateStatusListeners();
    setListeners();
}


function updateStatusListeners()
{
    $('.btn-status').click(function (event)
    {
        let id = $(this).attr('data-cafe-id');
        changeStatus(id);
    })
}


function changeStatus(id)
{
    var dataToSend = new FormData();
    dataToSend.append('cafe_id', id);

    $.ajax({
        url: "/sside/updatestatus.php",
        type: "POST",
        data: dataToSend,
        async: true,
        success: function (data)
        {
            console.log(data);

            requestCafes();
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {

        },
        cache: false,
        contentType: false,
        processData: false
    });
}











