<?php

require "connection.php";

$fname = $_POST["f"];
$lname = $_POST["l"];
$email = $_POST["e"];
$mobile = $_POST["m"];
$password = $_POST["p"];
$gender = $_POST["g"];

if (empty($fname)) {
    echo ("Please Enter Your First Name.");
} elseif (strlen($fname) > 50) {
    echo ("First Name Must Contain LOWER THAN 50 Characters.");
} elseif (empty($lname)) {
    echo ("Please Enter Your Last Name.");
} elseif (strlen($lname) > 50) {
    echo ("Last Name Must Contain LOWER THAN 50 Characters.");
} elseif (empty($email)) {
    echo ("Please Enter Your Email Address Name.");
} elseif (strlen($email) > 100) {
    echo ("Email Must Contain LOWER THAN 100 Characters.");
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo ("Invalid Email Address.");
} elseif (empty($password)) {
    echo ("Please Enter Your Password.");
} elseif (strlen($password) < 5 || strlen($password) > 20) {
    echo ("Password Must Contain Between 5 To 20 Characters.");
} elseif (empty($mobile)) {
    echo ("Please Enter Your Mobile");
} elseif (strlen($mobile) != 10) {
    echo ("Mobile Must Contain 10 Digits.");
} elseif (!preg_match("/07[0,1,2,4,5,6,7,8]{1}[0-9]{7}/", $mobile)) {
    echo ("Invalid Mobile Number.");
} else {

    $rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' OR `mobile` = '" . $mobile . "'");
    $num = $rs->num_rows;

    if ($num > 0) {
        echo ("User With The Same Email Address Or Mobile Number Already Exists.");
    } else {

        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user`(`fname` , `lname` , `email` , `mobile` , `password` , `gender_gender_id` , `joined_date` , `status_status_id`) VALUES ('" . $fname . "' , '" . $lname . "' , '" . $email . "' , '" . $mobile . "' , '" . $password . "' , '" . $gender . "' , '" . $date . "' , 1)");
        echo ("success");
    }
}
