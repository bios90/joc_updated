$(document).on('change', '.btn-file :file', function() 
{
    var input = $(this),
    numFiles = input.get(0).files ? input.get(0).files.length : 1,
    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
});
  
$(document).ready( function() 
  {
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
          
        var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;
          
        if( input.length )
            {
                input.val(log);
            } 
            else 
            {
              if( log ) alert(log);
            } 
    });
});


$("#form_add_cafe").submit(function(event)
{ 
    event.preventDefault();
    // var datatopost = $(this).serializeArray();
    // console.log(datatopost);
    var form = $('form')[0]; // You need to use standard javascript object here
    var formData = new FormData(form);  

    $.ajax(
    {
        url: "http://justordercompany.com/sside/addcafe.php",
        type: 'POST',
        data: formData,
        async: true,
        success: function (data) 
        {
            console.log(data);
            $("#message").html(data);
        },
        cache: false,
        contentType: false,
        processData: false
    });

    return false;

});