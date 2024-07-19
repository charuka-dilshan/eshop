<?php

require "connection.php";

$province_id = $_GET["id"];

$district_rs = Database::search("SELECT * FROM `district` WHERE `province_province_id` = '" . $province_id . "'");
$district_num = $district_rs->num_rows;

for ($x = 0; $x < $district_num; $x++) {
    $district_data = $district_rs->fetch_assoc();
?>
    <option value="0">Select District</option>
    <option value="<?php echo $district_data["district_id"] ?>"><?php echo $district_data["district_name"] ?></option>
<?php
}


?>