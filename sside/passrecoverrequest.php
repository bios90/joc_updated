<?php 
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
require_once('../vendor/autoload.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/sside/db.php');
require_once('helpers/global_helper.php');
require_once('helpers/db_helper.php');
require_once('models/Model_Cafe.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



if (!postHaveValue("email"))
{
    echo "error no email";
    exit;
}

$email = getPostValue('email');

$sql = "SELECT `email` FROM `cafe` WHERE `email`='$email'";
$result = mysqli_query($conn, $sql);
if (!$result)
{
    // echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
    echo "error sql";
    exit;
}

if(mysqli_num_rows($result) != 1)
{
    echo "error num";
    exit;
}

$sql = "SELECT * FROM `cafe` WHERE `email`='$email' LIMIT 1";
$result = mysqli_query($conn, $sql);
if (!$result)
{
    echo 'echo error on Database connect ' . mysqli_error($result) . '   **********   ' . $sql;
    exit;
}

$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$cafe = getCafeFromRow($row);

$key = bin2hex(openssl_random_pseudo_bytes(16));

$sql = "INSERT INTO forgot_pass (`cafe_id`, `resetkey`) VALUES ('".$cafe->id."','$key')";
$result = mysqli_query($conn, $sql);
if(!$result)
{
    echo "error in database ".mysqli_error($conn)."******".$sql;
    exit;
}


$mail = new PHPMailer();
try
{
    $mail->CharSet = 'UTF-8';

    $message = "Пройдите по ссылку снизу для изменения пароля:\n\n";
    $message .= "https://www.justordercompany.com/passrecovery.php?cafe_id=".$cafe->id."&key=$key";
    $message = mb_convert_encoding($message, 'UTF-8');
    $mail->isSMTP();                                      
    $mail->Host = 'smtp.jino.ru';  
    $mail->Username = 'passrecover@justordercompany.com';                 
    $mail->Password = '12411241';                           
    $mail->SMTPSecure = 'ssl';                            
    $mail->Port = 465; 
    $mail->SMTPAuth = true;  
    $mail->setFrom('passrecover@justordercompany.com', mb_convert_encoding("Сервис JOC",'UTF-8'));
    $mail->addAddress($email,$cafe->name);
        
        
    $mail->isHTML(false);
    $mail->Subject = mb_convert_encoding("Восстановление пароля",'UTF-8');
    $mail->Body = $message;

    if($mail->Send())
    {
        echo "success";
        exit;
    }
    else
    {
        echo "error on sending";
        exit;
    }
}
catch(Exception $e)
{
    echo "error on sending";
}

?>