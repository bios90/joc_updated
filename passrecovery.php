<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include('sside/db.php');
include('sside/models/Model_Cafe.php');
include('sside/remember_me.php');

if(isset($_SESSION['cafe']))
{
    $cafe = unserialize($_SESSION['cafe']);
    // header("Location: /cafe_page.php");
}
else
    {
        $cafe = null;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=320, height=device-height, target-densitydpi=medium-dpi"/>
    <title>Just Order Company</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!--    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css"-->
    <!--          rel="stylesheet">-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script> -->
    <!--    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/cupertino/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHoROJoCnsD4-7gkV4uPWo0j4DwyyLRU4&libraries=places"></script>
    <link href="css/style.css?t=4564125s3343242dfsdf" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>

<body class="pass_recover">
<nav id="forgot_pass_nav" class="navbar fixed-top navbar-expand-lg">
    <div class="container pb-2">
        <div class="d-flex w-25 order-0 nav_on_md">
            <a class="navbar-brand mr-1" href="/">JOC</a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        <div id="collapsingNavbar" class="navbar-collapse collapse justify-content-center order-1 w-50">
            <ul class="navbar-nav mx-auto text-center justify-content-center centerlinks">
                <li class="nav-item active">
                    <a class="nav-link mynowrap" href="#">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="//codeply.com">Новости</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Приложения</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Кафе</a>
                </li>
            </ul>
        </div>

        <div class="w-25 order-2">

        </div>
    </div>
</nav>


<?php

$error = array();

if(!isset($_GET['cafe_id']) || !isset($_GET['key']))
{
    echo '<div class="alert alert-danger">Ошибка, проверьте ссылку в письме.</div>'; 
    $error[] = "no get info";
}

$cafe_id = $_GET['cafe_id'];
$key = $_GET['key'];
$time = time() - 86400;
    
$cafe_id = mysqli_real_escape_string($conn, $cafe_id);
$key = mysqli_real_escape_string($conn, $key);

    
$sql = "SELECT * FROM forgot_pass WHERE `resetkey`='$key' AND `cafe_id`=$cafe_id AND time > DATE_SUB(NOW(), INTERVAL 1 DAY) AND status='0'";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    $error[] = "sql";
}


$count = mysqli_num_rows($result);
if($count !== 1)
{
    $error[] = "num";
}
?>



<section id="forgot_pass_hero">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">

            <?php if(count($error) > 0 ) : ?>

            <div class="alert alert-danger">Ошибка, не удалось найти учетные данные, проверьте ссылку в письме.</div>

            <?php else : ?>
            
                <div class="card bg-white">
                    <div class="card-header">
                        <h4 class="text-center text-dark m-0">Изменение пароля</h4>
                    </div>

                    <div class="card-body">
                        <form id="reset_form">
                            <div>
                                <p id="error_par" class="input_error d-block text-center h-auto m-0"></p>
                            </div>

                            <input type="hidden" name="cafe_id" value="<?= $cafe_id ?>">
                            <input type="hidden" name="key" value="<?= $key ?>">

                            <div class="form-group">
                                <label for="email">Новый пароль</label>
                                <input class="form-control" type="text" id="name" name="pass" />
                                <small>Введите новый пароль</small>
                            </div>

                            <div class="form-group">
                                <label for="email">Повторите пароль</label>
                                <input class="form-control" type="text" id="name" name="pass2" />
                                <small>Повторите новый пароль</small>
                            </div>

                            <button type="submit" class="btn btn-block mybtn">Сохранить</button>
                        </form>
                    </div>
                    
                </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<div id="alert-fixed">
    <div class="col-sm-12 col-md-6 offset-md-3">
        <div id="my_alert" class="alert invisible" role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p></p>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
            
            $("#reset_form").submit(function(event)
            { 
                event.preventDefault();
                var datatopost = $(this).serializeArray();
                
                
                $.ajax({
                    url: "/sside/storeresetpassword.php",
                    type: "POST",
                    data: datatopost,
                    success: function(data)
                    {
                        data = $.parseJSON(data);

                        if ($.inArray("failed", data) > -1) 
                        {
                            showErrors(data);
                        }

                        if ($.inArray("success", data) > -1) 
                        {
                            showSuccess();
                        }
                    },
                    error: function()
                    {
                    
                    }

                });

            });
            
            
            function showErrors(data)
            {
                $("input").addClass("is-invalid");
                $("#error_par").text("Ошибка введите пароль, минимум 8 символов");
            }

            function showSuccess() 
            {
            $("input").removeClass("is-invalid");
            $("input").addClass("is-valid");

            let par = $("#my_alert")
                .find("p")
                .first();
            $("#my_alert").removeClass("invisible");
            $("#my_alert").addClass("alert-success");
            par.html("Пароль успешно изменен");
            $("#my_alert")
                .show()
                .delay(3500)
                .fadeOut();
            $("input[type=text]").val("");
        }
            
</script>
</body>

</html>