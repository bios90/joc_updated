<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/helpers/global_helper.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/helpers/db_helper.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Cafe.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Product.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Add.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Weight.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/models/Model_Milk.php');



$errors = array();

if (!isset($_SESSION['cafe']))
{
    $errors[] = 'cafe';
}
else
{
    $cafe = unserialize($_SESSION['cafe']);
}

if(!isset($_POST['product_id']))
{
    $errors[]='product_id';
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

$id = getPostValue('product_id');



$product = getProductById($id);

if($product->cafe_id != $cafe->id)
{
    echo 'failed';
}

if($product != null)
{
    echo json_encode($product);
    exit;
}

echo 'failed';

