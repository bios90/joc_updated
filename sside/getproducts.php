<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once('db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_Cafe.php');
require_once('models/Model_Product.php');
require_once('models/Model_Add.php');
require_once('models/Model_Weight.php');
require_once('models/Model_Milk.php');

$errors = array();

if (!isset($_SESSION['cafe']))
{
    $errors[] = 'cafe';
} else
{
    $cafe = unserialize($_SESSION['cafe']);
}

if(!isset($_POST['cafe_id']))
{
    $errors[]='cafe_id';
}

if(!isset($_POST['categ']))
{
    $errors[]='categ';
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

$cafe_id = $_POST['cafe_id'];
$categ = $_POST['categ'];

///////////
//$cafe_id = 2;
//$categ = 2;
//////////

$allProductsOfCateg = array();


$sql = "SELECT * FROM `products` WHERE `cafe_id`=$cafe_id AND `categ`=$categ";
$result = mysqli_query($conn, $sql);
if (!$result)
{
    echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
    exit;
}

while($row=mysqli_fetch_array($result, MYSQLI_ASSOC))
{
    $product = new Model_Product();
    $product->setData($row);

    if($row['categ'] == 0 || $row['categ'] == 1)
    {
        if($weights = getProductWeights($product))
        {
            $product->listOfWeights = $weights;
        }

        if($adds = getProductAdds($product))
        {
            $product->listOfAdds = $adds;
        }

        if($milks = getProductMilks($product))
        {
            $product->listOfMilks = $milks;
        }
    }

    $allProductsOfCateg[] = $product;
}

$allProductsOfCateg = json_encode($allProductsOfCateg,JSON_UNESCAPED_UNICODE);
echo $allProductsOfCateg;


?>