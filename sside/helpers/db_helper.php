<?php
error_reporting(-1);
ini_set('display_errors', 'On');
//require_once('../models/Model_Cafe.php');
require_once __DIR__ . '/../models/Model_Cafe.php';
require_once __DIR__ . '/../db.php';

function getCafeById($id,$conn)
{
    $sql = "SELECT * FROM `cafe` WHERE `id`=$id";
    $result = mysqli_query($conn, $sql);
    if (!$result)
    {
        return null;
    }

    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $cafe = new Model_Cafe();
    $cafe->setId($row['id']);
    $cafe->setEmail($row['email']);
    $cafe->setName($row['name']);
    $cafe->setOoo($row['ooo']);
    $cafe->setAdressUr($row['adress_ur']);
    $cafe->setAdressFact($row['adress_fact']);
    $cafe->setDirfio($row['dirfio']);
    $cafe->setPhone($row['phone']);
    $cafe->setInn($row['inn']);
    $cafe->setHourOt($row['hour_ot']);
    $cafe->setHourDo($row['hour_do']);
    $cafe->setMinuteOt($row['minute_ot']);
    $cafe->setMinuteDo($row['minute_do']);
    $cafe->setLogoName($row['logo_name']);
    $cafe->setStatus($row['status']);

    return $cafe;
}