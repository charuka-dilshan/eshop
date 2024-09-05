<?php

include("connection.php");
session_start();

if (isset($_SESSION["u"])) {

    $email = $_SESSION["u"]["email"];
    $pid = $_POST["i"];
    $type = $_POST["t"];
    $feedback = $_POST["f"];

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo"); 
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `feedback`(`feed_date` , `feed_type` , `feed_msg` , `feed_user_email` , `feed_product_id`) VALUES ('".$date."' , '".$type."' , '".$feedback."' , '".$email."' , '".$pid."')");

    echo "success";

}else{
    echo"Please loginto your account";
}

?>