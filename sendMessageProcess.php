<?php

include("connection.php");
session_start();

$email = $_SESSION["u"]["email"];
$to = $_POST["t"];
$m = $_POST["m"];
$d = new DateTime();
$d->setTimezone(new DateTimeZone("Asia/Colombo"));
$date = $d->format("Y-m-d H:i:s");

Database::iud("INSERT INTO `chat`(`content`, `chat_status` , `chat_date_time` , `from` , `to`) VALUES ('".$m."' , '1' , '".$date."' , '".$email."' , '".$to."')");

echo"success";