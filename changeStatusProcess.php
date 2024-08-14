
<?php

session_start();
include "connection.php";

$id = $_GET["id"];

$product_rs = Database::search("SELECT * FROM `product` WHERE `id` = '".$id."'");

if($product_rs->num_rows == 1){
    $product_data = $product_rs->fetch_assoc();
    $status = $product_data["status_status_id"];

    if($status == 1){
        Database::iud("UPDATE `product` SET `status_status_id` = '2' WHERE `id` = '".$id."'");
        echo ("Deactivated");
    }else{
        Database::iud("UPDATE `product` SET `status_status_id` = '1' WHERE `id` = '".$id."'");
        echo ("Activated");
    }

}else{
    echo "Something went wrong.Please try again later";
}

?>