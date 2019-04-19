<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/db.php');
include('helpers/global_helper.php');
include('models/Model_Cafe.php');
include('models/Model_Product.php');
include('models/Model_Add.php');
include('models/Model_Weight.php');
include('models/Model_Milk.php');



$hasErrors = false;
$errors = array();
$cafe;

if (!isset($_SESSION['cafe']))
{
    $errors[] = 'cafe';
}
else
{
    $cafe = unserialize($_SESSION['cafe']);
}


if (!postHaveValue("name"))
{
    $errors[] = "name";
}

if (!postHaveValue("price") || !getIntegerFromString($_POST['price']))
{
    $errors[] = "price";
}

if (!postHaveValue("categ"))
{
    $errors[] = "categ";
}

if (!postHaveValue("description"))
{
    $errors[] = "description";
}

if (!checkForValidImgFile('img_product'))
{
    $errors[]='img_product';
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}



$product_images_url = $_SERVER['DOCUMENT_ROOT'] . '/images/products/';
$img_name;
if(!$img_name = moveAndCreateProductImage('img_product',$product_images_url))
{
    echo json_encode([0 => "image save failed"]);
    exit;
}



$name = getPostValue('name');
$categ = getPostValue('categ');
$description = getPostValue('description');
$price = getPostValue('price');
$price = getIntegerFromString($price);


//
$categ = 2;
//


$cafe_id = $cafe->id;

$sql = "INSERT INTO `products`(`cafe_id`, `categ`, `name`, `img_name`, `description`,`price`) 
VALUES ('$cafe_id',$categ,'$name','$img_name','$description',$price)";

$result = mysqli_query($conn, $sql);
if (!$result)
{
    echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
    exit;
}

echo json_encode([0=>"success"]);
exit;