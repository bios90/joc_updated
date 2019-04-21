<?php
$conn = mysqli_connect("localhost","root","","joc");
if(mysqli_connect_error())
{
    die("Error: unable to Connect " . mysqli_connect_error() );
}
?>