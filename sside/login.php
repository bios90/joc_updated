<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
include('db.php');

$hasErrors = false;
$errors = array();

if (empty($_POST["email"]) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
{
    $errors[] = "email";
}

if (empty($_POST["password"]))
{
    $errors[] = "password";
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
$password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);
$password = hash('sha256', $password);

$sql = "SELECT * FROM `cafe` WHERE `email`='$email' AND `password`='$password'";
$result = mysqli_query($conn, $sql);
if (!$result)
{
    echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
    exit;
}

$count = mysqli_num_rows($result);
if ($count !== 1)
{
    $errors[] = 'login';
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if($row['status'] == 0)
{
    $errors[] = 'status';
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

$id = $row['id'];
$_SESSION['id'] = $id;



if (empty($_POST['remember_me']))
{
    echo json_encode([0 => "success"]);
    exit;
}

$authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
$authentificator2 = openssl_random_pseudo_bytes(20);

$cookieValue = f1($authentificator1, $authentificator2);
setcookie("remember_me",$cookieValue,time() + 1296000,'/', NULL, 0);

$f2authentificator2 = f2($authentificator2);

$id = $_SESSION['id'];
$expiration = date('Y-m-d H:i:s', time() + 1296000);

$sql = "INSERT INTO `remember_me` (`authentificator1`, `f2authentificator2`, `cafe_id`, `expires`)
        VALUES ('$authentificator1', '$f2authentificator2', '$id', '$expiration')";
$result = mysqli_query($conn, $sql);


if(!$result)
{
    echo 'echo error on Database connect '.mysqli_error($result).'   **********   '.$sql;
    exit;
}

echo json_encode([0 => "success"]);
exit;

function f1($a, $b)
{
    $c = $a . "," . bin2hex($b);
    return $c;
}

function f2($a)
{
    $b = hash('sha256', $a);
    return $b;
}

