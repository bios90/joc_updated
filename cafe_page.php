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
    <link href="css/style.css?t=52342324234312323423" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">


</head>
<body class="cafe_page">


<div class="modal fade" id="modal_cafe_edit" tabindex="-1" role="dialog" aria-labelledby="modal_reg_title"
     aria-hidden="true">
    <div id="my_modal_reg" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <form action="/" method="post" id="cafe_form_edit" enctype="multipart/form-data">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-center modal_title">Редактирование Кафе</h4>
                                <p class="text-center modal_subtitle">Редактирование данных вашего кафе</p>
                            </div>
                        </div>
                    </div>

                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>


                <div class="modal-body">
                    <div class="container">

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
                                <input type="text" class="form-control my_input" id="reg_cafe_name" name="name"
                                       value="<?= $cafe->name ?>">
                                <!--<small class="form-text ">Пароль для входа в личный кабинет</small>-->
                            </div>
                            <div id="err_div_name_cafe_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_ooo">Название ООО или ИП</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="reg_cafe_ooo" name="ooo"
                                       value="<?= $cafe->ooo ?>">
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
                                       name="adress_ur" value="<?= $cafe->adress_ur ?>">
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
                                <input type="text" class="form-control my_input" id="reg_cafe_okpo" name="okpo"
                                       value="<?= $cafe->okpo ?>">
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
                                       name="adress_fact" value="<?= $cafe->adress_fact ?>">
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
                                <input type="text" class="form-control my_input" id="reg_cafe_dirfio" name="dirfio"
                                       value="<?= $cafe->dirfio ?>">
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
                                <input type="text" class="form-control my_input" id="reg_cafe_phone" name="phone"
                                       value="<?= $cafe->phone ?>">
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
                                           id="reg_cafe_hour_ot" name="hour_ot" value="<?= $cafe->hour_ot ?>">
                                    <input id="time2" type="text" class="form-control my_input  time_input"
                                           id="reg_cafe_minute_ot" name="minute_ot" value="<?= $cafe->minute_ot ?>">
                                </div>

                                <p id="middle_p"> - </p>

                                <div class="time_input_div" style="display: inline-block">
                                    <input id="time3" type="text" class="form-control my_input  time_input"
                                           id="reg_cafe_hour_do" name="hour_do" value="<?= $cafe->hour_do ?>">
                                    <input id="time4" type="text" class="form-control my_input  time_input"
                                           id="reg_cafe_minute_do" name="minute_do" value="<?= $cafe->minute_do ?>">
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
                                       name="inn" value="<?= $cafe->inn ?>">
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
                                        <img id="logo_logo_cafe" class=""
                                             src="<?= "/images/cafelogos/" . $cafe->logo_name ?>" alt="">
                                    </p>
                                    <input type="file" class="form-control my_input" id="reg_cafe_logo"
                                           name="logo">
                                </div>

                                <small id="logo_small" class="form-text ">Логотип вашего кафе. Квадратные изображение
                                    Jpeg/Png до 5 мб.
                                </small>

                                <p id="current_logo_name"></p>

                            </div>
                            <div id="err_div_logo_cafe_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                    </div>
                </div>


                <div class="modal-footer">

                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 offset-md-2 pb-4 pt-4">
                                <input type="submit" class="mybtn w-100 mt-0 mb-0" href="" value="Сохранить">
                            </div>
                        </div>
                    </div>

                </div>


            </form>
        </div>
    </div>
</div>


<div id="modal_add_desert" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal_add_desert_title"
     aria-hidden="true" data-product-id="">
    <div id="modal_add_desert_div" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/" method="post" id="form_add_desert" enctype="multipart/form-data">

                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-center modal_title">Добавление десерта</h4>
                                <p class="text-center modal_subtitle">Добавьте новый продукт в меню
                                    приложения. Сразу после добавлния продукт станет доступен для заказа.</p>
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>

                <div class="modal-body">
                    <div id="add_desert_inputs_container" class="container">

                        <div id="name_row_desert" class="row input_row mt-4">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="name">Название</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="name_desert" name="name">
                            </div>

                            <div id="err_div_name_desert" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>

                        <div id="price_row_desert" class="row input_row mt-4">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="price">Цена</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="price_desert" name="price">
                            </div>

                            <div id="err_div_price_desert" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div id="desc_row_desert" class="row input_row mt-4">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="desc">Описание</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <textarea rows="3" type="text" class="form-control my_input" id="description_desert"
                                          name="description"></textarea>
                            </div>

                            <div id="err_div_description_desert" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_inn">Изображение</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">

                                <div id="file_input_div_desert" class="form-control" style="float: left">
                                    <p id="icon_upload_desert">
                                        <i id="upd_desert" class="fas fa-upload"></i>
                                        <img id="logo_logo_desert" class="invisible" src="" alt="">
                                    </p>
                                    <input type="file" class="form-control my_input" id="img_product_desert"
                                           name="img_product">
                                </div>

                                <small id="logo_small_desert" class="form-text ">Изображение продукта. Файлы изображение
                                    Jpeg/Png до 5 мб.
                                </small>

                                <p id="current_logo_name_desert">

                                </p>

                            </div>
                            <div id="err_div_logo_desert" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">

                    <div class="container">

                        <div class="row">

                            <div id="remove_desert_row" class="col-sm-12 col-md-4 offset-md-4 pb-0 pt-4 d-none">
                                <input id="btn_delete_desert" type="button" class="mybtnred w-100 mt-0 mb-0" href="" value="Удалить">
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 offset-md-4 pb-4 pt-4">
                                <input type="submit" class="mybtn w-100 mt-0 mb-0" href="" value="Добавить">
                            </div>
                        </div>
                    </div>

                </div>

            </form>

        </div>
    </div>
</div>


<div id="modal_add_drink" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal_add_drink_title"
     aria-hidden="true" data-product-id="">
    <div id="modal_add_drink_div" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/" method="post" id="form_add_drink" enctype="multipart/form-data">
                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-center modal_title">Добавление продукта</h4>
                                <p class="text-center modal_subtitle">Добавьте новый продукт в меню
                                    приложения. Сразу после добавлния продукт станет доступен для заказа.</p>
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>

                <div class="modal-body">
                    <div id="add_drink_inputs_container" class="container">

                        <div id="name_row" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="name">Название</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="name" name="name">
                            </div>

                            <div id="err_div_name" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div id="categ_row" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="categ">Категория</label>
                            </div>

                            <div id="input_categ_col" class="col-sm-12 col-lg-6 text-center position-relative">
                                <select id="select_categ" class="custom-select mr-sm-2" name="categ">
                                    <option class="my_option" value="0">Горячие Напитки</option>
                                    <option class="my_option" value="1">Холодные Напитки</option>
                                </select>

                                <p id="par_arrow" class="d-inline-block position-absolute">▾</p>
                            </div>

                        </div>


                        <div id="desc_row" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="desc">Описание</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <textarea rows="3" type="text" class="form-control my_input" id="description"
                                          name="description"></textarea>
                            </div>

                            <div id="err_div_description" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_inn">Изображение</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">

                                <div id="file_input_div" class="form-control" style="float: left">
                                    <p id="icon_upload">
                                        <i id="upd" class="fas fa-upload"></i>
                                        <img id="logo_logo" class="invisible" src="" alt="">
                                    </p>
                                    <input type="file" class="form-control my_input" id="img_product"
                                           name="img_product">
                                </div>

                                <small id="logo_small" class="form-text ">Изображение продукта. Файлы изображение
                                    Jpeg/Png до 5 мб.
                                </small>

                                <p id="current_logo_name"></p>

                            </div>
                            <div id="err_div_logo" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div id="weight_row" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Объем</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_weights" class="d-inline-block w-100">

                                </div>

                                <div>
                                    <small class="third-small">Объем</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input id="inp_weight_weight" type="text" class="form-control my_input third"
                                           name="weight_weight">
                                    <input id="inp_weight_price" type="text"
                                           class="form-control my_input third third-center"
                                           name="weight_price">
                                    <button id="btn_add_weight" class="btn_add" type="button" id="inp_weight"
                                            name="name">
                                        Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_weight" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div id="add_row" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Добавки</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_adds" class="d-inline-block w-100">


                                </div>

                                <div>
                                    <small class="third-small">Название</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input type="text" class="form-control my_input third" id="inp_add_name"
                                           name="add_name">
                                    <input type="text" class="form-control my_input third third-center"
                                           id="inp_add_price" name="add_price">
                                    <button id="btn_add_add" class="btn_add" type="button" name="name"
                                    >Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_add" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <!--           ============================             -->


                        <div id="add_row" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Молоко</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_milks" class="d-inline-block w-100">

                                </div>

                                <div>
                                    <small class="third-small">Название</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input id="inp_milk_name" type="text" class="form-control my_input third"
                                           name="milk_name">
                                    <input id="inp_milk_price" name="add_price" type="text"
                                           class="form-control my_input third third-center">
                                    <button id="btn_add_milk" class="btn_add" type="button" name="name"
                                    >Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_milk" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                    </div>
                </div>


                <div class="modal-footer">

                    <div class="container">

                        <div class="row">

                            <div id="remove_drink_row" class="col-sm-12 col-md-4 offset-md-4 pb-0 pt-4 d-none">
                                <input id="btn_delete_drink" type="button" class="mybtnred w-100 mt-0 mb-0" href="" value="Удалить">
                            </div>

                        </div>


                        <div class="row">

                            <div class="col-sm-12 col-md-4 offset-md-4 pb-4 pt-4">
                                <input type="submit" class="mybtn w-100 mt-0 mb-0" href="" value="Добавить">
                            </div>

                        </div>


                    </div>

                </div>

            </form>
        </div>
    </div>
</div>


<div id="modal_edit_drink" class="modal fade" tabindex="-1" role="dialog" aria-labelledby=""
     aria-hidden="true">
    <div id="modal_edit_drink_div" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">


            <form action="/" method="post" id="form_edit_drink" enctype="multipart/form-data" data-product-id="">

                <div class="modal-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="text-center modal_title">Редактирование продукта</h4>
                                <p class="text-center modal_subtitle">Измените параметры уже добавленного продукта.</p>
                            </div>
                        </div>
                    </div>
                    <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                </div>


                <div class="modal-body">
                    <div id="add_drink_inputs_container_edit" class="container">

                        <div id="name_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="name">Название</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <input type="text" class="form-control my_input" id="name_edit" name="name">
                            </div>

                            <div id="err_div_name_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div id="categ_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="categ">Категория</label>
                            </div>

                            <div id="input_categ_col_edit" class="col-sm-12 col-lg-6 text-center position-relative">
                                <select id="select_categ_edit" class="custom-select mr-sm-2" name="categ">
                                    <option class="my_option" value="0">Горячие Напитки</option>
                                    <option class="my_option" value="1">Холодные Напитки</option>
                                </select>

                                <p id="par_arrow_edit" class="d-inline-block position-absolute">▾</p>
                            </div>

                        </div>


                        <div id="desc_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="desc">Описание</label>
                            </div>

                            <div class="col-sm-12 col-lg-6 text-center">
                                <textarea rows="3" type="text" class="form-control my_input" id="description_edit"
                                          name="description"></textarea>
                            </div>

                            <div id="err_div_description_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon pt-2"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div class="row input_row">
                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="reg_cafe_inn">Изображение</label>
                            </div>
                            <div class="col-sm-12 col-lg-6 text-center">

                                <div id="file_input_div_edit" class="form-control" style="float: left">
                                    <p id="icon_upload_edit">
                                        <i id="upd_edit" class="fas fa-upload"></i>
                                        <img id="logo_logo_edit" class="invisible" src="" alt="">
                                    </p>
                                    <input type="file" class="form-control my_input" id="img_product_edit"
                                           name="img_product">
                                </div>

                                <small id="logo_small_edit" class="form-text ">Изображение продукта. Файлы изображение
                                    Jpeg/Png до 5 мб.
                                </small>

                                <p id="current_logo_name_edit"></p>

                            </div>
                            <div id="err_div_logo_edit" class="col-sm-12 col-lg-3 invisible err_div">
                                <i class="fas fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>
                        </div>


                        <div id="weight_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Объем</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_weights_edit" class="d-inline-block w-100">

                                </div>

                                <div>
                                    <small class="third-small">Объем</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input id="inp_weight_weight_edit" type="text" class="form-control my_input third"
                                           name="weight_weight">
                                    <input id="inp_weight_price_edit" type="text"
                                           class="form-control my_input third third-center"
                                           name="weight_price">
                                    <button id="btn_add_weight_edit" class="btn_add" type="button" id="inp_weight_edit"
                                            name="name">
                                        Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_weight_edit" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <div id="add_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Добавки</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_adds_edit" class="d-inline-block w-100">


                                </div>

                                <div>
                                    <small class="third-small">Название</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input type="text" class="form-control my_input third" id="inp_add_name_edit"
                                           name="add_name">
                                    <input type="text" class="form-control my_input third third-center"
                                           id="inp_add_price_edit" name="add_price">
                                    <button id="btn_add_add_edit" class="btn_add" type="button" name="name"
                                    >Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_add_edit" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                        <!--           ============================             -->


                        <div id="milk_row_edit" class="row input_row mt-4">

                            <div class="col-sm-12 col-lg-3 text-center">
                                <label class="my_modal_label" for="">Молоко</label>
                            </div>

                            <div class="col-sm-12 col-lg-6">
                                <div id="div_for_milks_edit" class="d-inline-block w-100">

                                </div>

                                <div>
                                    <small class="third-small">Название</small>
                                    <small class="third-small third-center">Цена</small>
                                    <small class="third-small"></small>
                                    <input id="inp_milk_name_edit" type="text" class="form-control my_input third"
                                           name="milk_name">
                                    <input id="inp_milk_price_edit" name="add_price" type="text"
                                           class="form-control my_input third third-center">
                                    <button id="btn_add_milk_edit" class="btn_add" type="button" name="name"
                                    >Добавить
                                    </button>
                                </div>
                            </div>


                            <div id="err_div_milk_edit" class="col-sm-12 col-lg-3 invisible err_div pt-2">
                                <i class="fas pt-2 fa-exclamation-circle error_icon"></i>
                                <p class="input_error"></p>
                            </div>

                        </div>


                    </div>
                </div>


                <div class="modal-footer">

                    <div class="container">
                        <div class="row">

                            <div class="col-sm-12 col-md-4 offset-md-4 pb-4 pt-4">
                                <input type="submit" class="mybtn w-100 mt-0 mb-0" href="" value="Добавить">
                            </div>

                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>

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
                                <a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i>Личный кабинет</a>


                                <?php if($cafe->is_admin == 1): ?>
                                    <a class="dropdown-item" href="/adminpanel.php"><i class="fas fa-tools"></i>Панель Администратора</a>
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


<section id="cafe_hero">


    <div class="container mb-4">

        <div class="row invisible position-absolute">
            <div class="col-xs-12">
                <ul id="ul_sub_links" class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="myCafeTabLabel" data-toggle="tab" href="#myCafeTab" role="tab"
                           aria-controls="myCafeTab" aria-selected="true" data-tab-num="0">Мое кафе</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="hotDrinksTabLabel" data-toggle="tab" href="#hotDrinksTab" role="tab"
                           aria-controls="hotDrinksTabs" aria-selected="false" data-tab-num="1">Горячие напитки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link sub_nav_link" id="coldDrinkTabLabel" data-toggle="tab" href="#coldDrinksTab"
                           role="tab"
                           aria-controls="coldDrinksTab" aria-selected="false" data-tab-num="2">Холодные напитки</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="desertTabLabel" data-toggle="tab" href="#desertsTab" role="tab"
                           aria-controls="desertsTab" aria-selected="false" data-tab-num="3">Десерты</a>
                    </li>
                </ul>
            </div>
        </div>

        <div id="row_categ_links" class="row">


            <div id="categ_my_cafe" class="sub_nav_div categ_link col-sm-12 col-md-3">
                <div class="div_categ_type">
                    <img class="icon-img" src="images/user_grad.png">
                </div>
                <div class="div_categ_name d-flex flex-column justify-content-center text-center grad-text">
                    Мое Кафе
                </div>
            </div>


            <div id="hot_drinks_cafe" class="sub_nav_div categ_link col-sm-12 col-md-3">
                <div class="div_categ_type">
                    <img class="icon-img" src="images/hot.png">
                </div>
                <div class="div_categ_name d-flex flex-column justify-content-center text-center">
                    Горячие Напитики
                </div>
            </div>


            <div id="cold_drinks_cafe" class="sub_nav_div categ_link col-sm-12 col-md-3">
                <div class="div_categ_type">
                    <img class="icon-img" src="images/cold.png">
                </div>
                <div class="div_categ_name d-flex flex-column justify-content-center text-center">
                    Холодные Напитки
                </div>
            </div>


            <div id="deserts_cafe" class="sub_nav_div categ_link col-sm-12 col-md-3">
                <div class="div_categ_type">
                    <img class="icon-img" src="images/desert.png">
                </div>
                <div class="div_categ_name d-flex flex-column justify-content-center text-center">
                    Десерты
                </div>
            </div>

            </ul>
        </div>
    </div>


    <div class="container">
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="myCafeTab" role="tabpanel" aria-labelledby="myCafeTabLabel">
                <div id="row_cafe" class="row">

                    <div class="col-sm-12">
                        <h4 id="cafe_title" class="text-center mt-4 mb-2"
                            data-cafe-id="<?= $cafe->id ?>"><?= $cafe->name ?></h4>
                    </div>

                    <div class="col-sm-12 col-lg-3 text-center pl-3">


                        <img id="img_cafe_logo" class="m-auto d-block"
                             src="<?= "/images/cafelogos/" . $cafe->logo_name ?>" alt="">
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


                    <div id="col_cafe_info" class="col-sm-12 col-lg-6 pt-3">
                        <p class="text_left text-sm-center text-lg-left  d-inline-block w-25">Адрес:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->adress_fact ?></p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Имя директора:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->dirfio ?></p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Телефон:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->phone ?></p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Часы работы:</p>
                        <p class="text_middle text-center d-inline-block w-75">
                            <?php
                            $hour_ot = getFormattedInt($cafe->hour_ot);
                            $minute_ot = getFormattedInt($cafe->minute_ot);
                            $hour_do = getFormattedInt($cafe->hour_do);
                            $minute_do = getFormattedInt($cafe->minute_do);
                            $stringOt = $hour_ot . " " . $minute_ot;
                            $stringDo = $hour_do . " " . $minute_do;

                            echo $stringOt . " - " . $stringDo;
                            ?>
                        </p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w- w-25">ИНН:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->inn ?></p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Название ООО или ИП:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->ooo ?></p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Юридический адрес:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->adress_ur ?></p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Код ОКПО:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->okpo ?></p>
                        <br/>
                        <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Фактический адрес:</p>
                        <p class="text_middle text-center d-inline-block w-75"><?= $cafe->adress_fact ?></p>
                    </div>


                    <div class="col-sm-12 offset-md-4 col-md-4 text-center mt-4 mb-4">
                        <input id="btn_cafe_edit" type="submit" class="mybtn mt-0 mb-0 btn-block" href=""
                               value="Редактировать">
                    </div>

                </div>
            </div>


            <div class="tab-pane fade show"
                 id="hotDrinksTab" role="tabpanel" aria-labelledby="hotDrinksTabLabel">

                <div id="row_for_hot_drinks" class="row">

                    <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                        <div id="card_add" class="border-gradient">
                            <div id="card_add_center" class="text-center">
                                <div id="add_circle" class="d-inline-block">
                                    <p id="circle_plus" class="grad-text">+</p>
                                </div>
                                <p class="text-center mt-3">Добавить Продукт</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>


            <div class="tab-pane fade show" id="coldDrinksTab" role="tabpanel" aria-labelledby="hotDrinksTabLabel">


                <div id="row_for_cold_drinks" class="row">
                    <div class="col-sm-12 col-md-4 col-lg-3 mb-sm-3">
                        <div id="card_add_cold" class="border-gradient">
                            <div id="card_add_center" class="text-center">
                                <div id="add_circle" class="d-inline-block">
                                    <p id="circle_plus" class="grad-text">+</p>
                                </div>
                                <p class="text-center mt-3">Добавить Продукт</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="tab-pane fade show"
                 id="desertsTab" role="tabpanel" aria-labelledby="desertsTabLabel">

                <div id="row_for_deserts" class="row">

                    <div class="col-sm-12 col-md-4 col-lg-3 mb-sm-3">
                        <div id="card_add_desert" class="border-gradient">
                            <div id="card_add_center" class="text-center">
                                <div id="add_circle" class="d-inline-block">
                                    <p id="circle_plus" class="grad-text">+</p>
                                </div>
                                <p class="text-center mt-3">Добавить Продукт</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</section>


<section id="section_tab_cafe">

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


<!-- ************ Foorer section **************** -->

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


<!-- ************END Footer SECTION**************** -->
<script src="js/cafe_page.js?t=5613132424"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>