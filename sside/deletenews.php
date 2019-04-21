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

if (!postHaveValue("news_id"))
{
    $errors[] = "news_id";
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

deleteNews(getPostValue('news_id'));

echo json_encode([0=>"success"]);