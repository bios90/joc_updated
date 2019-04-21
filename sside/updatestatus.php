<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once('db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_Cafe.php');

$id;
if(!postHaveValue('cafe_id'))
{
    echo 'error';
    exit;
}

$id = getPostValue('cafe_id');

if(changeStatus($id))
{
    echo 'success';
}
else
    {
        echo 'error';
    }

