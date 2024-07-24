<?php

session_start();
require "connection.php";

$email = $_SESSION["u"]["email"];

$fname = $_POST["f"];
$lname = $_POST["l"];
$mobile = $_POST["m"];
$line1 = $_POST["li1"];
$line2 = $_POST["li2"];
$city = $_POST["c"];
$pcode = $_POST["p"];

$user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."'");

if($user_rs->num_rows == 1){

    Database::iud("UPDATE `user` SET `fname` = '".$fname."' , `lname` = '".$lname."' , `mobile` = '".$mobile."' WHERE `email` = '".$email."' ");
    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$email."'");

    if($address_rs->num_rows == 1){
        Database::iud("UPDATE `user_has_address` SET `line1` = '".$line1."' , `line2` = '".$line2."' , `postal_code` = '".$pcode."' , `city_city_id` = '".$city."' WHERE `user_email` = '".$email."'");
    }else{
        Database::iud("INSERT INTO `user_has_address`(`user_email` , `city_city_id` , `line1` , `line2` , `postal_code`) VALUES ('".$email."' , '".$city."' , '".$line1."' , '".$line2."' , '".$pcode."')");
    }

    if(sizeof($_FILES) == 1){

        $image = $_FILES["i"];
        $image_extention = $image["type"];

        $allowed_image_extentions = array("image/jpeg" , "image/png" , "image/svg+xml");

        if(in_array($image_extention,$allowed_image_extentions)){
            $new_extenction;

            if($image_extention == "image/jpeg"){
                $new_extenction = ".jpeg";
            }elseif($image_extention == "image/png"){
                $new_extenction = ".png";
            }elseif($image_extention == "image/svg+xml"){
                $new_extenction = ".svg";
            }

            $file_name = "resources//profile_images//".$fname."_".uniqid().$new_extenction;
            move_uploaded_file($image["tmp_name"],$file_name);

            $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '".$email."'");

            if($image_rs->num_rows == 1){
                Database::iud("UPDATE `profile_img` SET `img_path` = '".$file_name."' WHERE `user_email` = '".$email."'");
                echo("updated");
            }else{
                Database::iud("INSERT INTO `profile_img`(`img_path`,`user_email`) VALUES ('".$file_name."' , '".$email."')");
                echo("saved");
            }

        }

    }elseif(sizeof($_FILES) == 0){
        echo("Please select a file.");
    }else{
        echo("You can only upload 1 file.");
    }

    // echo("success");

}else{
    echo("Invalid user.");
}

?>