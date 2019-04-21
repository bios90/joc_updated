$(document).ready(function ()
{
    $("#categ_all_cafe").click(function (e)
    {
        activaTab("tab_all_cafe");
        changeColors(0);
    });

    $("#categ_news").click(function (e)
    {
        activaTab("tab_news");
        changeColors(1);
    });
});

function changeColors(num)
{
    if(num == 0)
    {
        $('#categ_all_cafe').find('i').addClass('faw-orange');
        $('#categ_all_cafe').find('.div_categ_name').addClass('grad-text');

        $('#categ_news').find('i').removeClass('faw-orange');
        $('#categ_news').find('.div_categ_name').removeClass('grad-text');
    }else
        {
            $('#categ_news').find('i').addClass('faw-orange');
            $('#categ_news').find('.div_categ_name').addClass('grad-text');

            $('#categ_all_cafe').find('i').removeClass('faw-orange');
            $('#categ_all_cafe').find('.div_categ_name').removeClass('grad-text');
        }
}



function activaTab(tab)
{
    $('.nav-tabs a[href="#' + tab + '"]').tab("show");
}