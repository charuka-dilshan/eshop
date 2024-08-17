<?php

include "connection.php";

$clr = $_GET["clr"];

$clr_rs = Database::search("SELECT * FROM `color` WHERE `clr_name` LIKE '%" . $clr . "%'");

if ($clr_rs->num_rows > 0) {
    echo ("This color already exists");
} else {

    Database::iud("INSERT INTO `color` (`clr_name`) VALUES('" . $clr . "')");

    echo ("success");


}

