<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php');


function getFormattedInt($num)
{
    if ($num < 10)
    {
        return '0' . $num;
    }
    return $num;
}

function fileUploaded($field_name)
{
    if (isset($_FILES [$field_name]))
    {
        if ($_FILES [$field_name] ["error"] == UPLOAD_ERR_OK)
        {
            return true;
        } else
        {
            return false;
        }
    } else
    {
        return false;
    }
}

function postHaveValue($field_name)
{
    if (!isset($_POST[$field_name]))
    {
        return false;
    }

    if (strlen(trim($_POST[$field_name])) <= 0)
    {
        return false;
    }

    return true;
}

function isPassValidInEdit()
{
    if (strlen(trim($_POST['password'])) == 0)
    {
        return true;
    } else

        if (strlen(trim($_POST['password'])) < 8)
        {
            return false;
        }

    return true;
}

function isHourValid($field_name)
{
    if (strlen(trim($_POST[$field_name])) == 0)
    {
        return false;
    }

    $hour = $_POST[$field_name];
    if (!(($hour >= 0) && ($hour <= 23)))
    {
        return false;
    }

    return true;
}

function isMinuteValid($field_name)
{
    if (strlen(trim($_POST[$field_name])) == 0)
    {
        return false;
    }

    $min = $_POST[$field_name];
    if (!(($min >= 0) && ($min <= 59)))
    {
        return false;
    }

    return true;
}

function checkForValidImgFile($field_name)
{
    if (!fileUploaded($field_name))
    {
        return false;
    }

    $file_name = $_FILES[$field_name]["name"];
    $file_size = $_FILES[$field_name]['size'];
    $extansion = pathinfo($file_name, PATHINFO_EXTENSION);
    $tmp_name = $_FILES[$field_name]["tmp_name"];

    if (($extansion != "jpg" && $extansion != "jpeg" && $extansion != "png") || $file_size > 1024 * 1024 * 1024 * 5)
    {
        return false;
    }

    return true;
}

function moveAndCreateProductImage($field_name, $dir)
{
    $file_name = $_FILES[$field_name]["name"];
    $extansion = pathinfo($file_name, PATHINFO_EXTENSION);
    $tmp_name = $_FILES[$field_name]["tmp_name"];

    $random = new PragmaRX\Random\Random();
    $randName = $random->get();
    $randName = $randName . "." . $extansion;

    $permanentDestination = $dir . $randName;

    if (!file_exists($dir))
    {
        mkdir($dir, 0777, true);
    }

    if (!move_uploaded_file($tmp_name, $permanentDestination))
    {
        return false;
    }

    return $randName;
}

function getPostValue($field_name)
{
    global $conn;
    $value = $_POST[$field_name];
    $value = trim($value);
    $value = mysqli_real_escape_string($conn, $value);
    return $value;
}

function getIntegerFromString($str)
{
    $str = preg_replace('/[^0-9.]+/', '', $str);
    if (strlen($str) == 0)
    {
        return false;
    }

    $int = (int)$str;
    return $int;
}

function timeStampToDate($timestamp)
{   $timestamp = strtotime($timestamp);
    return gmdate("Y.m.d", $timestamp);
}