<?php

include("connection.php");
session_start();

$receiver_email = $_SESSION["u"]["email"];
$sender = $_GET["e"];


$msg_rs = Database::search("SELECT * FROM `chat` WHERE (`from` = '" . $receiver_email . "' OR `FROM` = '" . $sender . "') AND (`to` = '" . $sender . "' OR `to` = '" . $receiver_email . "')");
$msg_num = $msg_rs->num_rows;


for ($i = 0; $i < $msg_num; $i++) {
    $msg_data = $msg_rs->fetch_assoc();
    if ($msg_data["from"] == $receiver_email) {

?>
        <!-- sent -->

        <div class="offset-3 col-9 media w-75 text-end fustify-content-end align-items-end">
            <div class="media-body">
                <div class="bg-primary rounded py-2 px-2 mb-3">
                    <p class="mb-0 fw-bold text-black-50"><?php echo $msg_data["content"] ?></p>
                </div>
                <p class="small fw-bold text-white-50 text-end"><?php echo $msg_data["chat_date_time"] ?></p>
            </div>
        </div>

        <!-- sent -->
    <?php

    } else if ($msg_data["to"] == $receiver_email) {

        $user_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email` = '" . $sender . "' ");
        $user_data = $user_rs->fetch_assoc();

    ?>

        <!-- receive -->
        <div class="media w-75">

            <?php
            
            if(isset($user_data["img_path"])){
                ?><img src="<?php echo $user_data["img_path"]?>" width="50px" class="rounded-circle"><?php
            }else{ 
                ?><img src="resources/new_user.svg" width="50px" class="rounded-circle"><?php
             }

            ?>
            

            <div class="media-body">
                <div class="bg-light rounded py-2 px-2 mb-3">
                    <p class="mb-0 fw-bold text-black-50"><?php echo $msg_data["content"] ?></p>
                </div>
                <p class="small fw-bold text-white-50 text-end"><?php echo $msg_data["chat_date_time"] ?></p>
            </div>

        </div>
        <!-- receive -->

<?php


    }
}
?>