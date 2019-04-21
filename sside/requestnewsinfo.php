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



if(!postHaveValue('news_id'))
{
    echo 'error';
    exit;
}

$id =  getPostValue('news_id');

$news = getNewsById($id);

echo json_encode($news,JSON_UNESCAPED_UNICODE);