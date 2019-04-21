<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once('db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_Cafe.php');
require_once('models/Model_News.php');


$news = getAllNews();


ob_start();
?>

<?php foreach ($news as $newsone): ?>

    <?php if ($newsone->image != null): ?>
        <div class="shadow my_rounded8 bg-white mt-3">
            <div class="row">
                <div class="col-md-4">
                    <img class="news_img_show_users" src="/images/news/<?= $newsone->image ?>"/>
                </div>

                <div class="col-md-8">

                    <div class="p-4">
                        <h3 class="news_title_show text-center mt-4"><?= $newsone->title ?></h3>
                        <p class="news_time_show mt-4 mb-0"><?= timeStampToDate($newsone->date) ?></p>
                        <p class="news_text_show"><?= $newsone->text ?></p>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>

        <div class="shadow my_rounded8 bg-white mt-3">
            <div class="row">
                <div class="col">

                    <div class="p-4">
                        <h3 class="news_title_show text-center mt-4"><?= $newsone->title ?></h3>
                        <p class="news_time_show mt-4 mb-0"><?= timeStampToDate($newsone->date) ?></p>
                        <p class="news_text_show"><?= $newsone->text ?></p>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endforeach; ?>


<?php

$content = ob_get_clean();
echo $content;
?>
