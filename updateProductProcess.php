<?php

include "connection.php";

$title = $_POST["t"];
$qty = $_POST["q"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$desc = $_POST["d"];
$pid = $_POST["id"];

Database::iud("UPDATE `product` SET `title` = '".$title."' , `qty` = '".$qty."' , 
`description` = '".$desc."' , `delivery_fee_colombo` = '".$dwc."' , `delivery_fee_other` = '".$doc."' WHERE `id` = '".$pid."' ");

echo ("product has been updated!");

$length = sizeof($_FILES);

if($length<=3 && $length>0){

    $allowed_image_extenctions = array("image/jpeg" , "image/png" , "image/svg+xml");

    $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id`= '".$pid."'");
    $img_num = $img_rs->num_rows;

    for($a = 0 ; $a < $img_num ; $a++){
        $img_data = $img_rs->fetch_assoc();

        unlink($img_data["img_path"]);
        Database::iud("DELETE FROM `product_img` WHERE `product_id` = '".$pid."'");
    }

    for($x = 0 ; $x < $length; $x++){
        if(isset($_FILES["image".$x])){
            $image_file = $_FILES["image".$x];
            $file_extenction = $image_file["type"];

            if(in_array($file_extention ,$allowed_image_extenctions)){

                $new_image_extenction;

                if($file_extenction = "image/jpeg"){
                    $new_image_extenction = ".jpeg";
                }elseif($file_extenction = "image/png"){
                    $new_image_extenction = ".png";
                }elseif($file_extenction = "image/svg+xml"){
                    $new_image_extenction = ".svg";
                }

                $file_name = "resources//product_images//".$title.$x.uniqid().$new_image_extenction;
                move_uploaded_file($image_file["tmp_name"] , $file_name);

                Database::iud("INSERT INTO `product_img`(`img_path`,`product_id`) VALUES ('".$file_name."' , '".$product_id."')");

            }else{
                echo("Inavlide image type!");
            }
        }
    }

    echo("success");

}else{
    echo("invalid image count.");
}


?>