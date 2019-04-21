<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once('db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_News.php');

$hasErrors = false;
$errors = array();
$news;



if (!postHaveValue("title"))
{
    $errors[] = "title";
}

if (!postHaveValue("text"))
{
    $errors[] = "text";
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

$news = new Model_News();
$news->title = getPostValue('title');
$news->text = getPostValue('text');

if(fileUploaded('img_news'))
{
    $news_folder = $_SERVER['DOCUMENT_ROOT'] . '/images/news/';
    $image = moveAndCreateProductImage('img_news',$news_folder);
    $news->image = $image;
}

if(insertNews($news))
{
    echo json_encode([0=>"success"]);
}
else
    {
        array_unshift($errors, 'failed');
        echo json_encode($errors);
    }











