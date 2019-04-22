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
<body class="admin_panel">

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
                                <a class="dropdown-item" href="/cafe_page.php"><i class="fas fa-user-cog"></i>Личный кабинет</a>


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


<section id="admin_hero">

    <div class="row invisible position-absolute">
        <div class="col-xs-12">
            <ul id="ul_sub_links" class="nav nav-tabs nav-fill" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="myCafeTabLabel" data-toggle="tab" href="#tab_all_cafe" role="tab"
                       aria-controls="myCafeTab" aria-selected="true" data-tab-num="0"></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="newsTabLabel" data-toggle="tab" href="#tab_news" role="tab"
                       aria-controls="hotDrinksTabs" aria-selected="false" data-tab-num="1"></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="container mb-4">
        <div id="row_categ_links" class="row">

            <div id="categ_all_cafe" class="sub_nav_div categ_link col-sm-12 col-md-3">
                <div class="div_categ_type">
                    <i class="fas fa-users faw-icon faw-orange"></i>
                </div>
                <div class="div_categ_name d-flex flex-column justify-content-center text-center grad-text">
                    Все кафе
                </div>
            </div>


            <div id="categ_news" class="sub_nav_div categ_link col-sm-12 col-md-3">
                <div class="div_categ_type">
                    <i class="fas fa-newspaper faw-icon"></i>
                </div>
                <div class="div_categ_name d-flex flex-column justify-content-center text-center">
                    Новости
                </div>
            </div>

            <div class="ml-auto text-right sub_nav_div categ_link col-sm-12 col-md-3 pt-3">
                <button id="btn_add_news" type="button" class="mt-2 py-2 px-4 btn-grad-green">
                    <i class="fas fa-plus mr-1"></i> Добавить новость
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="tab-content" id="myTabContent">

            <!--        Tab All Cafessss        -->

            <div id="tab_all_cafe" class="tab-pane fade show active" role="tabpanel" aria-labelledby="">
                <!--                <div class="row">-->
                <!---->
                <!--                    <div class="col">-->

                <div class="table-responsive mytable_responsive">
                    <table id="all_cafes_table" class="table table-borderless invisible">
                        <thead style="display: block">
                        <tr>
                            <th class="column-name" style="width: 91px;"></th>
                            <th class="column-name text-center"><a class="thead_link" href="" id="sort_cafe">Кафе</a>
                            </th>
                            <th class="column-adress text-center"><a class="thead_link" href=""
                                                                     id="sort_adress">Адрес</a></th>
                            <th class="column-dir text-center"><a class="thead_link" href=""
                                                                  id="sort_dir">Представитель</a>
                            </th>
                            <th class="column-phone text-center"><a class="thead_link" href=""
                                                                    id="sort_phone">Телефон</a>
                            </th>
                            <th class="column-email text-center"><a class="thead_link" href="" id="sort_email">Email</a>
                            </th>
                            <th class="column-status text-center"><a class="thead_link" href=""
                                                                     id="sort_status">Статус</a></th>

                        </tr>
                        </thead>

                        <tbody id="allcafes_tbody" class="py-2 shadow-sm">


                        <!--                                <tr class="cafe_row">-->
                        <!--                                    <td class="text-center p-0">-->
                        <!--                                        <div class="p-2 text-center column-logo">-->
                        <!--                                            <img class="table_logo" src="http://shoko-vs.ru/images/logo1.png" alt="">-->
                        <!--                                        </div>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-name text-center">-->
                        <!--                                        <p class="p-2" data-toggle="tooltip" data-placement="top" title="">-->
                        <!--                                            Шоколадница</p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-adress text-center">-->
                        <!--                                        <p class="p-2" data-toggle="tooltip" data-placement="top" title="">ул Есенина д-->
                        <!--                                            15</p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-dir text-center">-->
                        <!--                                        <p class="p-2" data-toggle="tooltip" data-placement="top" title="">Иванов Иван-->
                        <!--                                            Иванович</p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-phone text-center">-->
                        <!--                                        <p class="p-2"><a href="tel:+7(999)7773333">+7(999)7773333</a></p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-email text-center">-->
                        <!--                                        <p class="p-2"><a href="mailto:+7(999)7773333">bios90@mail.ru</a></p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-status text-center">-->
                        <!--                                        <button href="" class="btn-status mx-auto" data-cafe-id="">Одобрен</button>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->
                        <!--                                <tr class="cafe_row">-->
                        <!--                                    <td class="text-center p-0">-->
                        <!--                                        <div class="p-2 text-center column-logo">-->
                        <!--                                            <img class="table_logo" src="http://shoko-vs.ru/images/logo1.png" alt="">-->
                        <!--                                        </div>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-name text-center">-->
                        <!--                                        <p class="p-2">Шоколадница</p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-adress text-center">-->
                        <!--                                        <p class="p-2">ул Есенина д 15</p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-dir text-center">-->
                        <!--                                        <p class="p-2">Иванов Иван Иванович</p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-phone text-center">-->
                        <!--                                        <p class="p-2"><a href="tel:+7(999)7773333">+7(999)7773333</a></p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-email text-center">-->
                        <!--                                        <p class="p-2"><a href="mailto:+7(999)7773333">bios90@mail.ru</a></p>-->
                        <!--                                    </td>-->
                        <!--                                    <td class="column-status text-center">-->
                        <!--                                        <button href="" class="btn-status mx-auto" data-cafe-id="">Одобрен</button>-->
                        <!--                                    </td>-->
                        <!--                                </tr>-->


                        </tbody>
                    </table>
                </div>

                <!--                    </div>-->
                <!---->
                <!--                </div>-->
            </div>


            <!--     Tab news       -->
            <div id="tab_news" class="tab-pane fade show" role="tabpanel" aria-labelledby="">


                <!--                <div class="shadow my_rounded8 bg-white mt-3">-->
                <!--                    <div class="row">-->
                <!--                        <div class="col-md-4">-->
                <!--                            <img class="news_img_show" src="https://truffle-assets.imgix.net/pxqrocxwsjcc_4mlylloieeiqmyecgk0qq8_rose%CC%81-champagne-cupcakes-landscape-no-graphic.jpg"/>-->
                <!--                        </div>-->
                <!---->
                <!--                        <div class="col-md-8">-->
                <!---->
                <!--                            <div class="p-4">-->
                <!--                                <h3 class="news_title_show text-center mt-4">Открытие нового кафе</h3>-->
                <!--                                <p class="news_time_show mt-4 mb-0">22.06.2019</p>-->
                <!--                                <p class="news_text_show">vehicula ipsum a arcu cursus vitae congue mauris rhoncus-->
                <!--                                    aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant morbi-->
                <!--                                    tristique senectus et netus et malesuada fames ac turpis egestas maecenas pharetra-->
                <!--                                    convallis posuere morbi leo urna molestie at elementum eu facilisis sed odio morbi-->
                <!--                                    quis commodo odio aenean sed adipiscing</p>-->
                <!---->
                <!--                                <button class="btn-edit-news d-block ml-auto" data-news-id=""><i-->
                <!--                                            class="fas fa-pencil-alt mr-1"></i> <span>Редактировать</span>-->
                <!--                                </button>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!---->
                <!---->
                <!--                <div class="shadow my_rounded8 bg-white mt-2">-->
                <!--                    <div class="row">-->
                <!---->
                <!--                        <div class="col">-->
                <!---->
                <!--                            <div class="p-4">-->
                <!--                                <h3 class="news_title_show text-center mt-4">Открытие нового кафе</h3>-->
                <!--                                <p class="news_time_show mt-4 mb-0">22.06.2019</p>-->
                <!--                                <p class="news_text_show">vehicula ipsum a arcu cursus vitae congue mauris rhoncus-->
                <!--                                    aenean vel elit scelerisque mauris pellentesque pulvinar pellentesque habitant morbi-->
                <!--                                    tristique senectus et netus et malesuada fames ac turpis egestas maecenas pharetra-->
                <!--                                    convallis posuere morbi leo urna molestie at elementum eu facilisis sed odio morbi-->
                <!--                                    quis commodo odio aenean sed adipiscing</p>-->
                <!---->
                <!--                                <button class="btn-edit-news d-block ml-auto" data-news-id=""><i-->
                <!--                                            class="fas fa-pencil-alt mr-1"></i> <span>Редактировать</span>-->
                <!--                                </button>-->
                <!--                            </div>-->
                <!--                        </div>-->
                <!--                    </div>-->
                <!--                </div>-->

            </div>
        </div>
    </div>

</section>


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
                <img class="socialicon" src="images/skype.png">
                <img class="socialicon" src="images/twitter.png">
                <img class="socialicon" src="images/vk.png">
                <img class="socialicon" src="images/gp.png">
                <img class="socialicon" src="images/fb.png">
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


<!--Region Modals -->

<div id="modal_add_news" class="modal fade" tabindex="-1" role="dialog"
     aria-hidden="false">
    <div id="modal_add_news_div" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/" method="post" id="form_add_news" enctype="multipart/form-data" data-news-id="">

                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-center modal_title">Добавить новость</h4>
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>

                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9">
                                <label class="my_modal_label m-0" for="title">Заглавие</label>
                                <input type="text" class="form-control my_input" id="inp_title" name="title">

                                <label class="my_modal_label m-0" for="text">Текст</label>
                                <textarea type="text" class="form-control my_input" id="inp_text" rows="4"
                                          name="text"></textarea>
                            </div>


                            <div class="col-md-3">
                                <label class="my_modal_label m-0 d-block" for="image">Изображение</label>

                                <div id="file_input_div_news" class="form-control">
                                    <p id="icon_upload" class="text-center">
                                        <i id="upd" class="fas fa-upload"></i>
                                        <img id="logo_news" class="invisible" src="" alt="">
                                    </p>
                                    <input type="file" class="form-control my_input" id="img_news"
                                           name="img_news">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">

                    <div class="container pb-4 pt-4">

                        <div id="btn_delete_div" class="row d-none">
                            <div class="col-sm-12 col-md-4 offset-md-4 pb-3">
                                <input id="btn_delete_news" type="button" class="mybtnred w-100 mt-0 mb-0" href=""
                                       value="Удалить">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 offset-md-4">
                                <input id="add_news_btn" type="submit" class="mybtn w-100 mt-0 mb-0" href=""
                                       value="Добавить">
                            </div>
                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>


<div id="modal_cafe_info" class="modal fade" tabindex="-1" role="dialog"
     aria-hidden="false">
    <div id="modal_cafe_info_div" class="modal-dialog modal-lg" role="document">

        <div id="cafe_modal" class="modal-content">


            <div class="modal-body my_rounded4">
                <div class="container">
                    <div class="row">


                        <div class="col-sm-12">
                            <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                            <h4 id="cafe_title" class="text-center mt-4 mb-2"
                                data-cafe-id="">sdfasdf</h4>
                        </div>

                        <div class="col-sm-12 col-lg-3 text-center pl-3">


                            <img id="img_cafe_logo" class="m-auto d-block"
                                 src="" alt="">
                            <img id="img_cafe_rating" class="mt-2 mb-3" src="images/rating.png" alt="">
                            <br/>
                            <p class="p_left_text pl-3 text-left d-inline-block w-50 mb-2">Всего заказов:</p>
                            <p class="d-inline-block w-25 text-center mb-2">1140</p>
                            <br/>
                            <p class="p_left_text pl-3 text-left d-inline-block w-50 mb-2">Отзывов:</p>
                            <p class="d-inline-block w-25 text-center mb-2">160</p>
                            <br/>
                            <p class="p_left_text pl-3 text-left d-inline-block w-50 mb-2">Всего продуктов:</p>
                            <p class="d-inline-block w-25 text-center mb-2">22</p>

                        </div>


                        <div id="col_cafe_info" class="col-sm-12 col-lg-9 pt-3 mynowrap">
                            <p class="text_left text-sm-center text-lg-left  d-inline-block w-25 mynowrap">Адрес:</p>
                            <p class="text_middle text-center d-inline-block w-75 mynowrap">sdfsdf</p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Имя директора:</p>
                            <p class="text_middle text-center d-inline-block w-75">sdafsadf</p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Телефон:</p>
                            <p class="text_middle text-center d-inline-block w-75">sdfsadf</p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Часы работы:</p>
                            <p class="text_middle text-center d-inline-block w-75">
                                asfsdafsdf
                            </p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w- w-25">ИНН:</p>
                            <p class="text_middle text-center d-inline-block w-75">sdfsdaf</p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Название ООО или
                                ИП:</p>
                            <p class="text_middle text-center d-inline-block w-75">sadfsdf</p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Юридический адрес:</p>
                            <p class="text_middle text-center d-inline-block w-75">sdfsadf</p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Код ОКПО:</p>
                            <p class="text_middle text-center d-inline-block w-75">sadfsdf</p>
                            <br/>
                            <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Фактический адрес:</p>
                            <p class="text_middle text-center d-inline-block w-75">asfsadf</p>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal-footer">

                <div class="container pb-4 pt-4">

                    <div id="btn_delete_div" class="row">
                        <div class="col-sm-12 col-md-4 offset-md-4">
                            <input id="btn_delete_news" type="button" class="mybtnred w-100 mt-0 mb-0" href=""
                                   value="Приостановить" data-cafe-id="">
                        </div>
                    </div>

                    <div id="btn_accept_div" class="row">
                        <div class="col-sm-12 col-md-4 offset-md-4">
                            <input id="btn_accept_div" type="button" class="btn-grad-green w-100 mt-0 mb-0 px-4 py-2 shadow" href=""
                                   value="Одобрить" data-cafe-id="">
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


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

<script src="js/adminpanel/tabs_listener.js?t=5613132424"></script>
<script src="js/adminpanel/cafes_tab.js?t=5613132424"></script>
<script src="js/adminpanel/news_tab.js?t=sdf"></script>
<script src="js/adminpanel/adminpanel.js?t=5613132424"></script>

</body>
</html>
