<?php

include "connection.php";

$email = $_POST["e"];
$newpw = $_POST["np"];
$retypepw = $_POST["rp"];
$vcode = $_POST["v"];

if(!isset($newpw)){
    echo("Please enter a new password.");
}elseif (strlen($newpw)<5 || strlen($newpw)>20) {
    echo("New password must contain BETWEEN 5 to 20 Characters. ");
}elseif(!isset($retypepw)){
    echo("Please retype your new password.");
}elseif (strlen($retypepw)<5 || strlen($retypepw)>20) {
    echo("Retyped password must contain BETWEEN 5 to 20 Characters. ");
}elseif ($newpw != $retypepw ) {
    echo("The passwords do not match.");
}else{

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."' and `vcode` = '".$vcode."'");
    $user_num = $user_rs->num_rows;

    if($user_num == 1){
        Database::iud("UPDATE `user` SET `password` = '".$retypepw."' WHERE `email` = '".$email."' AND `vcode` = '".$vcode."' ");
        echo("success");
    }else{
        echo("Invalid Verification Code");
    }

}

?>