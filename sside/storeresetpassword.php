<?php
session_start();
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/db.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/helpers/global_helper.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/helpers/db_helper.php');

$errors = array();
if(!postHaveValue("cafe_id"))
{
   $errors[] = 'cafe_id';
}

if(!postHaveValue("key"))
{
   $errors[] = 'key';
}

if(!postHaveValue("pass"))
{
   $errors[] = 'pass';
}
else
{
    if(!postHaveValue("pass2"))
    {
        $errors[] = 'pass';
    }

    $pass = getPostValue('pass');
    $pass2 = getPostValue('pass2');

    if($pass != $pass2)
    {
        $errors[] = 'pass';
    }

    if(strlen($pass) < 8)
    {
        $errors[] = 'pass';
    }
}



if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

    
$pass = getPostValue('pass');
$pass = hash('sha256', $pass);
$cafe_id = getPostValue('cafe_id');
$key = getPostValue('key');
    
$sql = "SELECT * FROM `forgot_pass` WHERE `resetkey`='$key' AND `cafe_id`='$cafe_id' AND time > DATE_SUB(NOW(), INTERVAL 1 DAY) AND status='0'";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    $errors[] = "err on forgot_pass reset"; 
    exit;
}

$count = mysqli_num_rows($result);
if($count !== 1)
{
    $errors[] = "err on forgot_pass num"; 
    exit;
}


if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}




//Run Query: Update users password in the users table
$sql = "UPDATE `cafe` SET `password`='$pass' WHERE `id`='$cafe_id'";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    $errors[] = "err on pass set"; 
    exit;
}

if (count($errors) > 0)
{
    array_unshift($errors, 'failed');
    echo json_encode($errors);
    exit;
}

//set the key status to "used" in the forgotpassword table to prevent the key from being used twice
$sql = "UPDATE `forgot_pass` SET status='1' WHERE resetkey='$key' AND `cafe_id`='$cafe_id'";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    $errors[] = "err last sql"; 
    array_unshift($errors, 'failed');
    echo json_encode($errors);
}
else
{
    array_unshift($errors, 'success');
    echo json_encode($errors); 
}
?>