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


$hasErrors = false;
$errors = array();
$cafe;

if (!isset($_SESSION['cafe']))
{
    $errors[] = 'cafe';
} else
{
    $cafe = unserialize($_SESSION['cafe']);
}


if (!postHaveValue("name"))
{
    $errors[] = "name";
}

if (!postHaveValue("categ"))
{
    $errors[] = "categ";
}

if (!postHaveValue("description"))
{
    $errors[] = "description";
}

if (!postHaveValue("weight0") || (!postHaveValue("weight_price0")))
{
    $errors[] = 'weight';
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


$cafe_id = $cafe->id;


$sql = "INSERT INTO `products`(`cafe_id`, `categ`, `name`, `img_name`, `description`) 
VALUES ('$cafe_id',$categ,'$name','$img_name','$description')";

$result = mysqli_query($conn, $sql);
if (!$result)
{
    echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
    exit;
}

$product_id = mysqli_insert_id($conn);

insertPostWeights($product_id);
insertPostAdds($product_id);
insertPostMilks($product_id);




echo json_encode([0=>"success"]);
exit;



