$(document).ready(function ()
{
    requestNews();
});


function requestNews()
{
    var dataToSend = new FormData();

    let rand = getRandomInt(0,1);
    rand = 0;

    var url;
    if(rand == 0)
    {
        url = "/sside/getallnewsuser.php";
    }
    else
        {
            url = "/sside/getallnewsuser2.php"
        }

    $.ajax({
        url: url,
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
    $('#newsbox').html('');
    $('#newsbox').html(data);
}

function getRandomInt(min, max) {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
}