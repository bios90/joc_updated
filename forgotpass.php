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
    header("Location: /cafe_page.php");
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
    <link href="css/style.css?t=456242dfsdf" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>

<body class="forgot_pass">
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
                    <a class="nav-link" href="#">О нас</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/newspage.php">Новости</a>
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



<section id="forgot_pass_hero">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card bg-white">
                    <div class="card-header">
                        <h4 class="text-center text-dark m-0">Восстановление пароля</h4>
                    </div>

                    <div class="card-body">
                        <form id="forgot_form">
                            <div>
                                <p id="error_par" class="input_error d-block text-center h-auto m-0"></p>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" type="text" id="name" name="email" />
                                <small>Введите email указанный при регистрации</small>
                            </div>

                            <button type="submit" class="btn btn-block mybtn">Восстановить</button>
                        </form>
                    </div>
                    
                </div>
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

<!-- <section id="section_footer" class="mt-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title_footer">Контакты</h2>
            </div>


            <div class="col-md-4 col-xs-12">
                <p class="footer_text">
                    Нижняя Красносельская 35 ст.52
                </p>
            </div>

            <div class="col-md-4 col-xs-12 text-center">
                <p class="footer_phone">
                    +7 919 123 4567
                </p>
                <p class="footer_email">justorder@mail.com</p>
                <p class="footer_email">justordrerpartners@mail.com</p>
            </div>

            <div class="col-xs-12 col-md-4 text-center socicons">
                <img class="socialicon" src="images/skype.svg">
                <img class="socialicon" src="images/twitter.svg">
                <img class="socialicon" src="images/vk.svg">
                <img class="socialicon" src="images/gp.svg">
                <img class="socialicon" src="images/fb.svg">
            </div>

            <div class="col-12">
                <p class="bottom_footer">Just Order Company 2019 ® All Rights Recieved</p>
            </div>

        </div>
    </div>


    <div id="alert-fixed" class="invisible">
        <div class="col-sm-12 col-md-6 offset-md-3">
            <div id="my_alert" class="alert " role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <p></p>
            </div>
        </div>
    </div>


</section> -->


<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="js/forgotpass.js?t=234"></script>


</body>

</html>