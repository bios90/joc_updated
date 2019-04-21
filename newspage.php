<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include('sside/db.php');
include('sside/helpers/global_helper.php');
include('sside/models/Model_Cafe.php');
include('sside/remember_me.php');


if (isset($_SESSION['cafe']))
{
    echo "cafe not null";
    $cafe = unserialize($_SESSION['cafe']);
} else
{
    echo "cafe null";
    $cafe = null;
    header("location:index.php");
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
    <!--    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">-->
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
    <link href="css/style.css?t=523sadf4234312323423" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


</head>
<body class="newspage_body">

<section id="section_navbar_cafe_page">
    <div class="container">
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="d-flex w-25 order-0 nav_on_md">
                <a class="navbar-brand mr-1" href="/">JOC</a>
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                        data-target=".navbar-collapse">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div id="collapsingNavbar" class="navbar-collapse collapse justify-content-center order-1 w-50">
                <ul class="navbar-nav mx-auto text-center justify-content-center centerlinks">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">О нас</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link faw-orange" href="/newspage.php">Новости</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Приложения</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Кафе</a>
                    </li>
                </ul>
            </div>

            <div id="collapsingNavbar2" class="navbar-collapse collapse w-25 order-2 dual-collapse2">
                <ul class="navbar-nav justify-content-end ml-auto rightlinks">
                    <?php if ($cafe != null) : ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img id="cafe_nav_logo" src="<?php echo "/images/cafelogos/" . $cafe->logo_name ?>"
                                     alt="">
                                <?php echo $cafe->name ?>
                            </a>
                            <div id="cafe_dropdown" class="dropdown-menu dropdown-menu-right"
                                 aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i>Личный кабинет</a>


                                <?php if ($cafe->is_admin == 1): ?>
                                    <a class="dropdown-item" href="/adminpanel.php"><i class="fas fa-tools"></i>Панель
                                        Администратора</a>
                                <?php endif; ?>


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/sside/logout.php?&logout=1"><i
                                            class="fas fa-door-open"></i>Выйти</a>
                            </div>
                        </li>
                    <?php else : ?>
                        <li class="nav-item regli">
                            <a id="reglink" class="nav-link" href="#" data-toggle="modal" data-target="#modal_reg">Регистация</a>
                        </li>
                        <li class="nav-item enterli">
                            <a id="enterlink" class="nav-link" href="#" data-toggle="modal"
                               data-target="#modal_login">Войти</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>

        </nav>
    </div>
</section>


<section id="news_hero">

    <div id="newsbox" class="container mt-3">

        <div id="cards_div" class="card-columns">

            <div class="card">
                <img class="card-img-top img-fluid" src="https://source.unsplash.com/random/300x200" alt="">
                <div class="card-body">
                    <h4 class="card-title news_title_show">Card title that wraps to a new line</h4>
                    <p class="news_time_show mt-2 mb-0">22.05.1990</p>
                    <p class="card-text news_text_show text_show_card">This is a longer card with supporting text below as a natural lead-in to
                        additional content. This content
                        is a little bit longer.</p>
                </div>
            </div>


            <div class="card">
                <div class="card-body">
                    <h4 class="card-title news_title_show">Card title</h4>
                    <p class="news_time_show mt-2 mb-0">22.05.1990</p>
                    <p class="card-text news_text_show text_show_card">This card has supporting text below as a natural lead-in to additional
                        content.</p>
                </div>
            </div>

        </div>
    </div>


</section>


<!-- ************ Fooret section **************** -->

<section id="section_footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title_footer">Контакты</h2>
            </div>


            <div class="col-md-4 col-xs-12">
                <p class="footer_text">
                    Москва 122773<br/>
                    Краснопресненская набережная 12
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


</section>


<!-- ****************** REGION ALERT ********************-->
<div id="alert-fixed" class="invisible">
    <div class="col-sm-12 col-md-6 offset-md-3">
        <div id="my_alert" class="alert " role="alert">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <p></p>
        </div>
    </div>
</div>
<!-- ****************** END REGION ALERT ********************-->


<!-- ************END Footer SECTION**************** -->

<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script src="js/newspage/loadnews.js?t=3463"></script>

</body>
</html>