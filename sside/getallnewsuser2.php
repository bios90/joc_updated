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
<div id="cards_div" class="card-columns" style="overflow: visible;">
    <?php foreach ($news as $newsone): ?>

        <?php if ($newsone->image != null): ?>


            <div class="card shadow-sm" style="overflow: visible;">
                <img class="card-img-top img-fluid mycard-img" src="/images/news/<?= $newsone->image ?>" alt="">
                <div class="card-body">
                    <h4 class="card-title news_title_show"><?= $newsone->title ?></h4>
                    <p class="news_time_show mt-2 mb-0"><?= timeStampToDate($newsone->date) ?></p>
                    <p class="card-text news_text_show text_show_card"><?= $newsone->text ?></p>
                </div>
            </div>

        <?php else: ?>


            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title news_title_show"><?= $newsone->title ?></h4>
                    <p class="news_time_show mt-2 mb-0"><?= timeStampToDate($newsone->date) ?></p>
                    <p class="card-text news_text_show text_show_card"><?= $newsone->text ?></p>
                </div>
            </div>

        <?php endif; ?>

    <?php endforeach; ?>
</div>

<?php

$content = ob_get_clean();
echo $content;
?>
