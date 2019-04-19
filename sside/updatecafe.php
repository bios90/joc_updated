<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_Cafe.php');
require_once('models/Model_Product.php');
require_once('models/Model_Add.php');
require_once('models/Model_Weight.php');
require_once('models/Model_Milk.php');

$hasErrors = false;
$errors = array();



if(!isPassValidInEdit())
{
    $errors[]="password";
}


if(!postHaveValue("name"))
{
    $errors[]="name";
}

if(!postHaveValue('ooo'))
{
    $errors[]="ooo";
}

if(!postHaveValue("adress_ur"))
{
    $errors[]="adress_ur";
}

if(!postHaveValue("okpo"))
{
    $errors[]="okpo";
}

if(!postHaveValue("adress_fact"))
{
    $errors[]="adress_fact";
}

if(!postHaveValue("dirfio"))
{
    $errors[]="dirfio";
}

if(!postHaveValue("phone"))
{
    $errors[]="phone";
}

if(!isHourValid('hour_ot'))
{
    $errors[]="hour_ot";
}

if(!isMinuteValid('minute_ot'))
{
    $errors[]="minute_ot";
}

if(!isHourValid('hour_do'))
{
    $errors[]="hour_do";
}


if(!isMinuteValid('minute_do'))
{
    $errors[]="minute_do";
}


if(!postHaveValue("inn"))
{
    $errors[]="inn";
}

if(!postHaveValue("cafe_id"))
{
    $errors[]="cafe_id";
}




if(!isset($_FILES['logo']['tmp_name']) || $_FILES["logo"]["error"] > 0)
{
//    $errors[]="logo";
//    $errors[]="isset";
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


$cafe_id = mysqli_real_escape_string($conn, $_POST['cafe_id']);
$cafe = getCafeById($cafe_id,$conn);

$randName = $cafe->logo_name;

if(fileUploaded('logo') )
{
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
}





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




$sql = "UPDATE `cafe` SET `name`='$name',`ooo`='$ooo',`okpo`='$okpo',`adress_ur`='$adress_ur',`adress_fact`='$adress_fact',`dirfio`='$dirfio',`phone`='$phone',`inn`='$inn',`hour_ot`='$hour_ot',`minute_ot`='$minute_ot',`hour_do`='$hour_do',`minute_do`='$minute_do',`logo_name`='$randName',`status`=1 ";
if(!empty($_POST["password"]))
{
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $password = hash('sha256', $password);
    $sql.=", `password`='$password '";
}
$sql.=" WHERE `id`=$cafe_id";

$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo 'echo error on Database connect '.mysqli_error($result).'   **********   '.$sql;
    exit;
}


$cafe = getCafeById($cafe_id,$conn);
$_SESSION['cafe']= serialize($cafe);

if(!empty($_POST["password"]))
{
    echo json_encode([0=>"success",1=>"pass"]);
}
else
    {
        $cafe = getCafeById($cafe_id,$conn);
        $_SESSION['cafe']= serialize($cafe);
        echo json_encode([0=>"success",1=>"no_pass"]);
    }

exit;