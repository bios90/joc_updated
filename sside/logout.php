<?php
if($_GET['logout'] == 1)
{
    echo "entered here";
    session_start();
    session_unset();
    session_destroy();
    setcookie("remember_me","" ,time() -3600,'/', NULL, 0);
    header("Location: /");
}
?>