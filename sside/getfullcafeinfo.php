<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once('db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_Cafe.php');


$hasErrors = false;
$errors = array();

if (!postHaveValue("cafe_id"))
{
    $errors[] = "cafe_id";
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

$id = getPostValue('cafe_id');

$cafe = getCafeById($id);



ob_start();
?>


<div id="cafe_info_modal_body" class="modal-body my_rounded4" data-cafe-id="<?= $cafe->id ?>">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <i class="fas fa-times my_modal_close" data-dismiss="modal" aria-label="Close"></i>
                <h4 id="cafe_title" class="text-center mt-4 mb-2"
                    data-cafe-id="<?= $cafe->id ?>"><?= $cafe->name ?></h4>
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
                <p class="text_left text-sm-center text-lg-left  d-inline-block w-25 mynowrap">Статус</p>
                    <?php

                    if($cafe->status == 1)
                    {
                        echo '<p class="text_middle text_middle_green text-center d-inline-block w-75 mynowrap">Одобрен</p>';
                    }
                    else
                        {
                            echo '<p class="text_middle text_middle_red text-center d-inline-block w-75 mynowrap">На рассмотрении</p>';
                        }

                    ?>
                <br/>
                <p class="text_left text-sm-center text-lg-left  d-inline-block w-25 mynowrap">Адрес:</p>
                <p class="text_middle text-center d-inline-block w-75 mynowrap"><?= $cafe->adress_fact ?></p>
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
                <p class="text_left text-sm-center text-lg-left d-inline-block w-25">Название ООО или
                    ИП:</p>
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
        </div>
    </div>
</div>


<div class="modal-footer">

    <div class="container pb-4 pt-4">

        <?php if($cafe->status == 1) :?>
        <div id="btn_delete_div" class="row">
            <div class="col-sm-12 col-md-4 offset-md-4">
                <input id="btn_status_toggle" type="button" class="mybtnred w-100 mt-0 mb-0" href=""
                       value="Приостановить" data-cafe-id="">
            </div>
        </div>

        <?php else: ?>

        <div id="btn_accept_div" class="row">
            <div class="col-sm-12 col-md-4 offset-md-4">
                <input id="btn_status_toggle" type="button" class="btn-grad-green w-100 mt-0 mb-0 px-4 py-2 shadow" href=""
                       value="Одобрить" data-cafe-id="">
            </div>
        </div>

        <?php endif; ?>

    </div>

</div>

<?php

$content = ob_get_clean();
echo $content;
?>
