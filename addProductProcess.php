<?php

session_start();
include "connection.php";

$email = $_SESSION["u"]["email"];
$category = $_POST["ca"];
$brand = $_POST["b"];
$model = $_POST["m"];
$title = $_POST["t"];
$condition = $_POST["co"];
$clr = $_POST["clr"];
$qty = $_POST["qty"];
$cost = $_POST["cost"];
$dwc = $_POST["dwc"];
$doc = $_POST["doc"];
$desc = $_POST["d"];
$model = $_POST["m"];

//HW = Field validation

$mhb_rs = Database::search("SELECT * FROM  `model_has_brand` WHERE `model_model_id` = '".$model."' AND `brand_brand_id` = '".$brand."' ");

$mhb_id;

if($mhb_rs->num_rows > 0){
     
    $mhb_data = $mhb_rs->fetch_assoc();
    $mhb_id = $mhb_data["model_has_brand_id"];
     
}else{
    Database::iud("INSERT INTO `model_has_brand`(`model_model_id` , `brand_brand_id`) VALUES ('".$model."' , '".$brand."') ");
    $mhb_id = Database::$connection->insert_id;
}

$d = new DateTime();
$tz= new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

$status = 1;

Database::iud("INSERT INTO `product`(`title` , `price` , `qty` , `description` , `datetime_added` , `delivery_fee_colombo` , `delivery_fee_other` , `model_has_brand_model_has_brand_id` , `condition_condition_id` , `category_cat_id` , `status_status_id` , `color_color_id` , `user_email`) 
VALUES ('".$title."' , '".$cost."' , '".$qty."' , '".$desc."' , '".$date."' , '".$dwc."' , '".$doc."' , '".$mhb_id."' , '".$condition."' , '".$category."' , '".$status."' , '".$clr."' , '".$email."')");

$product_id = Database::$connection->insert_id;
$length = sizeof($_FILES);

if($length<=3 && $length>0){

    $allowed_image_extenctions = array("image/jpeg" , "image/png" , "image/svg+xml");

    for($x = 0 ; $x < $length; $x++){
        if(isset($_FILES["image".$x])){
            $image_file = $_FILES["image".$x];
            $file_extenction = $image_file["type"];

            if(in_array($file_extenction ,$allowed_image_extenctions)){

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

                echo $product_id . $file_name;

                Database::iud("INSERT INTO `product_image`(`img_path`,`product_id`) VALUES ('".$file_name."' , '".$product_id."')");

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