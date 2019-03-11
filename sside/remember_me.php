<?php
//session_start();
include('helpers/db_helper.php');

//var_dump($_SESSION);
if(isset($_SESSION['id']) && !isset($_SESSION['cafe']))
{
    echo "entered checkk";
    $cafe = getCafeById($_SESSION['id'],$conn);
    $_SESSION['cafe']=serialize($cafe);
    return;
}


if(!isset($_SESSION['id']) && !empty($_COOKIE['remember_me']))
{
    echo('****  enetered if in rem me   *****');
    list($authentificator1, $authentificator2) = explode(',', $_COOKIE['remember_me']);
    $authentificator2 = hex2bin($authentificator2);
    $f2authentificator2 = hash('sha256', $authentificator2);

    $sql = "SELECT * FROM `remember_me` WHERE authentificator1 = '$authentificator1'";
    $result = mysqli_query($conn, $sql);
    if(!$result)
    {
        echo  "first sql error 1";
        exit;
    }

    $count = mysqli_num_rows($result);
    if($count !== 1)
    {
        echo "first sql error 2";
        exit;
    }

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if(!hash_equals($row['f2authentificator2'], $f2authentificator2))
    {
        echo "first sql error 3";
        exit;
    }

    $cafe_id = $row['cafe_id'];

    $authentificator1 = bin2hex(openssl_random_pseudo_bytes(10));
    $authentificator2 = openssl_random_pseudo_bytes(20);

    $cookieValue = f1($authentificator1, $authentificator2);
    setcookie("remember_me",$cookieValue,time() + 1296000,'/', NULL, 0);

    $f2authentificator2 = f2($authentificator2);

    $expiration = date('Y-m-d H:i:s', time() + 1296000);

    $sql = "INSERT INTO `remember_me` (`authentificator1`, `f2authentificator2`, `cafe_id`, `expires`)
        VALUES ('$authentificator1', '$f2authentificator2', '$cafe_id', '$expiration')";
    $result = mysqli_query($conn, $sql);

    if(!$result)
    {
        echo "first sql error 4";
        exit;
    }

    $cafe = getCafeById($cafe_id,$conn);

    $_SESSION['cafe']= serialize($cafe);
}

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