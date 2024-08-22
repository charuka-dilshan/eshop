<?php

include "connection.php";

if(isset($_GET["id"])){

    $list_id = $_GET["id"];

    $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `w_id` = '".$list_id."'");
    $watchlist_num = $watchlist_rs->num_rows;

    if ($watchlist_num == 1) {
        Database::iud("DELETE FROM `watchlist` WHERE `w_id` = '".$list_id."'");
        echo "deleted";
    }else{
        echo "Something went wrong try again later";
    }

}

?>