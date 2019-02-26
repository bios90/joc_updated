<?php
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
include('db.php');

$hasErrors = false;
$errors = array();


if(empty($_POST["email"]))
{
    $errors[]="email";
}

if(empty($_POST["password"]) || strlen($_POST["password"]) < 8)
{
    $errors[]="password";
}


if(empty($_POST["name"]))
{
    $errors[]="name";
}

if(empty($_POST["ooo"]))
{
    $errors[]="ooo";
}

if(empty($_POST["adress_ur"]))
{
    $errors[]="adress_ur";
}

if(empty($_POST["okpo"]))
{
    $errors[]="okpo";
}

if(empty($_POST["adress_fact"]))
{
    $errors[]="adress_fact";
}

if(empty($_POST["dirfio"]))
{
    $errors[]="dirfio";
}

if(empty($_POST["phone"]))
{
    $errors[]="phone";
}

if(empty($_POST["hour_ot"]))
{
    $errors[]="hour_ot";
}
else
{
    $hour_ot = $_POST["hour_ot"];
    if(!(($hour_ot >= 0) && ($hour_ot <= 23)))
    {
        $errors[]="hour_ot";
    }
}

if(empty($_POST["minute_ot"]))
{
    $errors[]="minute_ot";
}
else
{
    $minute_ot = $_POST["minute_ot"];
    if(!(($minute_ot >= 0) && ($minute_ot <= 59)))
    {
        $errors[]="minute_ot";
    }
}

if(empty($_POST["hour_do"]))
{
    $errors[]="hour_do";
}
else
{
    $hour_do = $_POST["hour_do"];
    if(!(($hour_do >= 0) && ($hour_do <= 23)))
    {
        $errors[]="hour_do";
    }
}

if(empty($_POST["minute_do"]))
{
    $errors[]="minute_do";
}
else
    {
        $minute_do = $_POST["minute_do"];
        if(!(($minute_do >= 0) && ($minute_do <= 59)))
        {
            $errors[]="minute_do";
        }
    }

if(empty($_POST["inn"]))
{
    $errors[]="inn";
}

if(!isset($_POST["agree"]) || $_POST['agree'] != 'true')
{
    $errors[]="agree";
}


if(!isset($_FILES['logo']['tmp_name']) || $_FILES["logo"]["error"] > 0)
{
    $errors[]="logo";
    $errors[]="isset";
}
else
    {
        $file_name = $_FILES["logo"]["name"];
        $file_size = $_FILES['logo']['size'];
        $extansion = pathinfo($file_name, PATHINFO_EXTENSION);
        $tmp_name = $_FILES["logo"]["tmp_name"];

        if(($extansion != "jpg" && $extansion != "jpeg" && $extansion != "png") || $file_size > 1024 * 1024 * 1024 * 5 )
        {
            $errors[]="logo";
        }
    }

if(count($errors) > 0)
{
    array_unshift($errors , 'failed');
    echo json_encode($errors);
    exit;
}




$file_name = $_FILES["logo"]["name"];
$extansion = pathinfo($file_name, PATHINFO_EXTENSION);
$tmp_name = $_FILES["logo"]["tmp_name"];

$random = new PragmaRX\Random\Random();
$randName = $random->get();
$randName = $randName.".".$extansion;

$permanentDestination = "../images/cafelogos/".$randName;

if (!file_exists('../images/cafelogos/'))
{
    mkdir('../images/cafelogos/', 0777, true);
}

if(!move_uploaded_file($tmp_name,$permanentDestination))
{
    echo json_encode([0=>"image save failed"]);
    exit;
}



$email = $_POST["email"];
$password = $_POST["password"];
$name = $_POST["name"];
$ooo = $_POST["ooo"];
$adress_ur = $_POST["adress_ur"];
$okpo = $_POST["okpo"];
$adress_fact = $_POST["adress_fact"];
$dirfio = $_POST["dirfio"];
$phone = $_POST["phone"];
$hour_ot = $_POST["hour_ot"];
$minute_ot = $_POST["minute_ot"];
$hour_do = $_POST["hour_do"];
$minute_do = $_POST["minute_do"];
$inn = $_POST["inn"];

$email = mysqli_real_escape_string($conn, $email);
$password = mysqli_real_escape_string($conn, $password);
$name = mysqli_real_escape_string($conn, $name);
$ooo = mysqli_real_escape_string($conn, $ooo);
$adress_ur = mysqli_real_escape_string($conn, $adress_ur);
$okpo = mysqli_real_escape_string($conn, $okpo);
$adress_fact = mysqli_real_escape_string($conn, $adress_fact);
$dirfio = mysqli_real_escape_string($conn, $dirfio);
$phone = mysqli_real_escape_string($conn, $phone);
$hour_ot = mysqli_real_escape_string($conn, $hour_ot);
$minute_ot = mysqli_real_escape_string($conn, $minute_ot);
$hour_do = mysqli_real_escape_string($conn, $hour_do);
$minute_do = mysqli_real_escape_string($conn, $minute_do);
$inn = mysqli_real_escape_string($conn, $inn);

$password = hash('sha256', $password);


$sql = "INSERT INTO `cafe`( `email`, `password`, `name`, `ooo`, `adress_ur`, `adress_fact`, `dirfio`, `phone`, `inn`, `hour_ot`, `minute_ot`, `hour_do`, `minute_do`, `logo_name`, `status`) 
VALUES ('$email','$password','$name','$ooo','$adress_ur','$adress_fact','$dirfio','$phone','$inn',$hour_ot,$minute_ot,$hour_do,$minute_do,'$randName',0)";

$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo 'echo error on Database connect '.mysqli_error($result).'   **********   '.$sql;
    exit;
}


echo json_encode([0=>"success"]);
exit;