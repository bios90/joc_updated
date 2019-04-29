<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
include('sside/db.php');
include('sside/models/Model_Cafe.php');
include('sside/remember_me.php');

if (isset($_SESSION['cafe']))
{
    echo "cafe not null";
    $cafe = unserialize($_SESSION['cafe']);
    echo $cafe->is_admin;
} else
{
    echo "cafe null";
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
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>

<body class="index">


<!-- Nav Bar!!!!! -->

<section id="section_navbar" data-logged="<?php
if ($cafe == null)
{
    echo 0;
} else
{
    echo 1;
}
?>">
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
                        <a id="about_us" class="nav-link" href="">О нас</a>
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
                                <a class="dropdown-item" href="/cafe_page.php"><i class="fas fa-user-cog"></i>Личный
                                    кабинет</a>

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


<!-- <section id="section_navbar">
    <div class="container">
        <nav class="navbar navbar-fixed navbar-expand-md">
            <button class="navbar-toggler" data-toggle="collapse"
                data-target="#collapse_target1, #collapse_target2">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse w-50 order-0 order-md-0 dual-collapse2">
                <ul class="navbar-nav mr-auto">
                    <li>
                        <a class="navbar-brand mx-auto" href="#">JOC</a>
                    </li>
                </ul>
            </div>
            <div class="mx-auto w-100 order-0 centerlinks">
                <ul class="navbar-nav mx-auto text-center justify-content-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">О нас</a>
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
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse w-50 order-0 dual-collapse2">
                <ul class="navbar-nav ml-auto rightlinks">
                    <li class="nav-item regli">
                        <a class="nav-link" href="#">Регистация</a>
                    </li>
                    <li class="nav-item enterli">
                        <a id="enterlink" class="nav-link" href="#">Войти</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</section> -->

<!-- ************END NAV BAR**************** -->

<!--*********** Region Login Modal ******************-->

<div class="modal fade" id="modal_login" tabindex="-1" role="dialog" aria-labelledby="modal_login_title"
     aria-hidden="true">
    <div id="my_modal_login" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/" method="post" id="login_form" enctype="multipart/form-data">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 id="modal_login_title" class="text-center">Войти</h4>
                                <p id="modal_login_subtitle" class="text-center">Вход в личный кабинет
                                    зарегистрированного кафе.</p>
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>


                <div class="modal-body">
                    <div id="login_inputs_container" class="container">
                        <div id="email_login_row" class="row input_row">

                            <div id="err_div_login" class="col-sm-12 invisible err_div text-center">
                                <div style="display: inline-block">
                                    <i class="fas fa-exclamation-circle error_icon mt-2"></i>
                                    <p class="input_error"></p>
                                </div>
                            </div>


                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="login_email">Email</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="login_email" name="email">
                                <small class="form-text ">Email указанный при регистрации</small>
                            </div>
                            <div id="err_div_email_login" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>

                        <div class="row input_row mb-4">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_password">Пароль</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="login_password" name="password">

                            </div>
                            <div id="err_div_password_login" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                            <div class="p-0 align-self-center m-auto text-">
                                <small><a href="/forgotpass.php">Забыли Пароль?</a></small>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 offset-md-4 pb-4 pt-4">
                                <input id="cheb_login" type="checkbox" name="remember_me" value="true">
                                <label for="cheb_login"></label>
                                <p id="cheb_text_login">Запомнить меня</p>
                                <input type="submit" class="mybtn w-100 mt-0 mb-0" href="" value="Войти">
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!--**************** END LOGIN MODAL *****************-->

<!-- ************** Region Register Modal   -->


<div class="modal fade" id="modal_reg" tabindex="-1" role="dialog" aria-labelledby="modal_reg_title" aria-hidden="true">
    <div id="my_modal_reg" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/" method="post" id="reg_form" enctype="multipart/form-data">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 id="modal_reg_title" class="text-center">Регистрация кафе</h4>
                                <p id="modal_reg_subtitle" class="text-center">Регистрация - заявка кафе для участия в
                                    программе сервисов JOC. Мы свяжемся с вами для обсуждения всех деталей
                                    соотрудничества.</p>
                            </div>
                        </div>
                    </div>

                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>


                <div class="modal-body">
                    <div class="container">
                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_email">Email</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_email" name="email">
                                <small class="form-text ">На данный email будет приходить информация о посутпающих
                                    заказах
                                </small>
                            </div>
                            <div id="err_div_email" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>

                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_password">Пароль</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_password" name="password">
                                <small class="form-text ">Пароль для входа в личный кабинет</small>
                            </div>
                            <div id="err_div_password" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>

                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_name">Название кафе</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_name" name="name">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_name" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_ooo">Название ООО или ИП</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_ooo" name="ooo">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_ooo" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_adress_ur">Юридический адрес</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_adress_ur"
                                       name="adress_ur">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_adress_ur" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_okpo">Код ОКПО</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_okpo" name="okpo">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_okpo" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_adress_fact">Фактический адрес</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_adress_fact"
                                       name="adress_fact">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_adress_fact" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_dirfio">ФИО Ген. Директора</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_dirfio" name="dirfio">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_dirfio" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_phone">Телефон</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_phone" name="phone">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_phone" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label">Часы работы</label>
                            </div>
                            <div class="col-sm-12 col-lg-6">

                                <div class="time_input_div" style="display: inline-block">
                                    <input id="time1" type="text" class="form-control my_input  time_input"
                                           id="reg_cafe_hour_ot" name="hour_ot">
                                    <input id="time2" type="text" class="form-control my_input  time_input"
                                           id="reg_cafe_minute_ot" name="minute_ot">
                                </div>

                                <p id="middle_p"> - </p>

                                <div class="time_input_div" style="display: inline-block">
                                    <input id="time3" type="text" class="form-control my_input  time_input"
                                           id="reg_cafe_hour_do" name="hour_do">
                                    <input id="time4" type="text" class="form-control my_input  time_input"
                                           id="reg_cafe_minute_do" name="minute_do">
                                </div>

                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_time" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_inn">ИНН</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_inn"
                                       name="inn">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_inn" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_inn">Логотип Кафе</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">

                                <div id="file_input_div" class="form-control" style="float: left">
                                    <p id="icon_upload">
                                        <i id="upd" class="fas fa-upload"></i>
                                        <img id="logo_logo" class="invisible" src="" alt="">
                                    </p>
                                    <input type="file" class="form-control my_input" id="reg_cafe_logo"
                                           name="logo">
                                </div>

                                <small id="logo_small" class="form-text ">Логотип вашего кафе. Квадратные изображение
                                    Jpeg/Png до 5 мб.
                                </small>

                                <p id="current_logo_name"></p>

                            </div>
                            <div id="err_div_logo" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                    </div>
                </div>


                <div class="modal-footer">

                    <div class="container">
                        <div class="row">

                            <div id="err_div_agree" class="col-sm-12 col-md-4 offset-md-4 invisible">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                            <div class="col-sm-12 col-md-4 offset-md-4 pb-4 pt-4">
                                <input id="cheb" type="checkbox" name="agree" value="true">
                                <label for="cheb"></label>
                                <p id="cheb_text">Я согласен с условиями <a href="">договора*</a></p>
                                <input type="submit" class="mybtn w-100 mt-0 mb-0" value="Подключить">
                            </div>
                        </div>
                    </div>

                </div>

            </form>
        </div>

    </div>
</div>


<!-- ********************* END REGISTER MODAL ***********************-->


<!-- ************ Hero section **************** -->


<section class="hero_section">
    <div class="container hero_container h-100">
        <div class="row hero_row">
            <div class="col-md-6 offset-md-6">
                <h2 class="hero_title">Just order Company</h2>
                <p id="dark_banner">Бесплатное обслуживание</p>
                <p class="myp">Продажа фаст фуда через мобильные приложения - самая быстрорастущая инновация последних
                    лет. Нет желания создавать собственную систему мобильных приложений? Подключите наш сервис и
                    встречайте тысячи новых лояльных покупателей!</p>
                <div class="text-center">
                    <a id="btn_connect" class="mybtn text-white">Подключить</a>
                </div>
                <div class="partners_row">
                    <div id="partner1" class="partner_div"></div>
                    <div id="partner2" class="partner_div"></div>
                    <div id="partner3" class="partner_div"></div>
                    <div id="partner4" class="partner_div"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ************END HERO SECTION**************** -->


<!-- ************ Sub-Hero section **************** -->

<section id="about_section" class="section_subhero">

    <div class="container">
        <div class="row">

            <div class="col-12">
                <h2 class="title_subhero">О нас</h2>
                <p class="about_text">Добро пожаловать в «JOC»..
                    <br>Мы-стартап, задача которого экономия самого важного ресурса в жизни человека- времени.
                    <br>С нашей помощью вы упростите процесс покупки и оплаты напитков и выпечки в ваших любимых кафе.
                    <br>Особенность нашего сервиса- простота и удобство в использовании, возможность подобрать под себя
                    оптимальный сеттинг.
                    <br>Делайте заказ и забирайте его к установленному вами времени: наше приложение предоставляет
                    возможность эффективно сохранить такие ценные минуты. Потратьте их на себя, на тех кто вас любит и
                    ждёт.</p>


            </div>

            <div class="col-12">
                <h2 class="title_subhero">Преимущества</h2>
            </div>

            <div class="col-md-4 col-xs-12">
                <img class="subhero_img" src="images/hand.svg" alt="">
                <div class="subhero_feature_div">
                    <p class="feature_title">Клиенты</p>
                    <p class="feature_text">Каждый человек с мобильным устройстовом становится вашим покупателем.
                    </p>
                </div>
            </div>


            <div class="col-md-4 col-xs-12">
                <img class="subhero_img" src="images/delivery.svg" alt="">
                <div class="subhero_feature_div">
                    <p class="feature_title">Скорость</p>
                    <p class="feature_text">Клиенты с уже оплаченными заказами. Экономия на обслуживаниеи до 100%.
                    </p>
                </div>
            </div>


            <div class="col-md-4 col-xs-12">
                <img class="subhero_img" src="images/bag.svg" alt="">
                <div class="subhero_feature_div">
                    <p class="feature_title">Заказы</p>
                    <p class="feature_text">Удобство заказа из приложения гаранитирует повторяемость заказов клиентами.
                    </p>
                </div>
            </div>
        </div>


        <div class="col-12">
            <h2 class="title_subhero">Подключение</h2>
        </div>


        <div style="height: 100px;" class="col-md-6 col-xs-12 offset-md-4 step_row">

            <div class="d-none " id="line">

            </div>

            <div class="subhero_img">
                <p id="circle1" class="circle">1</p>
            </div>
            <div class="step_div">
                <p class="feature_title">Скорость</p>
                <p style="font-size: 11px;" class="feature_text">Клиенты с уже оплаченными заказами. Экономия на
                    обслуживаниеи до 100%.
                </p>
            </div>
        </div>


        <div style="height: 100px;" class="col-md-6 col-xs-12 offset-md-4 step_row">
            <div class="subhero_img">
                <p id="circle2" class="circle">2</p>
            </div>
            <div class="step_div">
                <p class="feature_title">Заполните меню</p>
                <p style="font-size: 11px;" class="feature_text">В личном кабинете представителя кафе вы можете добавить
                    продукты для отображения в меню кафе. После добавления пользователи сразу могут приобретать их.
                </p>
            </div>
        </div>


        <div style="height: 100px;" class="col-md-6 col-xs-12 offset-md-4 step_row">
            <div class="subhero_img">
                <p id="circle3" class="circle">3</p>
            </div>
            <div class="step_div">
                <p class="feature_title">Скорость</p>
                <p style="font-size: 11px;" class="feature_text">Клиенты с уже оплаченными заказами. Экономия на
                    обслуживаниеи до 100%.
                </p>
            </div>
        </div>


        <!-- <div class="col-xs-12 col-md-6 offset-md-4">
            <div class="circle_div">
                <p id="circle1" class="circle">1</p>
            </div>
            <div class="step_div">
                <p class="step_title">Зарегистрируйтесь на сайте</p>
                <p class="step_text">Заполните простую форму регистрации, указав верные данные вашего кафе</p>
            </div>
        </div>



        <div class="col-xs-12 col-md-6 offset-md-4">
            <div class="circle_div">
                <p id="circle2" class="circle">2</p>
            </div>
            <div>
                <p class="step_title">Зарегистрируйтесь на сайте</p>
                <p class="step_text">Заполните простую форму регистрации, указав верные данные вашего кафе</p>
            </div>
        </div> -->


    </div>
    </div>
</section>


<!-- ************END Sub-HERO SECTION**************** -->


<!-- ************ Fooret section **************** -->

<section id="section_footer">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="title_footer">Контакты</h2>
            </div>


            <div class="col-md-4 col-xs-12">
                <p class="footer_text">
                    Москва Нижняя Красносельская 35 ст.52
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
                <!--                <img class="socialicon" src="images/skype.png">-->
                <!--                <img class="socialicon" src="images/twitter.png">-->
                <!--                <img class="socialicon" src="images/gp.png">-->
                <img class="socialicon" src="images/fb.png">
                <img class="socialicon" src="images/vk.png">
                <img class="socialicon" src="images/inst.png">


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


<!-- ************END Footer SECTION**************** -->

<script src="js/index.js?t=52453"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>