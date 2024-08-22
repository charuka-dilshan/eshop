<?php

include "connection.php";
session_start();

if(isset($_SESSION["u"])){
    if (isset($_GET["id"])) {
        
        $user_email = $_SESSION["u"]["email"];
        $pid = $_GET["id"];
        $pqty = $_GET["qty"];

        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `cart_user_email` = '".$user_email."' AND `cart_product_id` = '".$pid."'");
        $cart_num = $cart_rs->num_rows;

        if ($cart_num == 1) {
            
            $cart_data = $cart_rs->fetch_assoc();
            $current_qty = $cart_data["cart_qty"];
            $new_qty = (int)$current_qty + 1;

            if($pqty >= $new_qty){
                Database::iud("UPDATE `cart` SET `cart_qty` = '".$new_qty."' WHERE `cart_user_email` = '".$user_email."' AND `cart_product_id` = '".$pid."'");
                echo ("cart updated");
            }else{
                echo ("invalid quantity");
            }

        }else{
            Database::iud("INSERT INTO `cart`(`cart_qty` , `cart_user_email` , `cart_product_id`) VALUES ( '1' , '".$user_email."' , '".$pid."')");
            echo "Product added to the cart";
        }

    }else{
        echo("Something went wrong!");
    }

}else{
    echo("please login to your account");
}




?>