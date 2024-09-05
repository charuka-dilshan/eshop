<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Messages | eShop</title>

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resources/logo.svg" />
</head>

<body style="background-color: #74EBD5;background-image: linear-gradient(90deg,#74EBD5 0%,#9FACE6 100%);">

    <div class="container-fluid">
        <div class="row">
            <?php 
            include "header.php";

            include "connection.php";

            $receiever = $_SESSION["u"]["email"];
            $sender = "";

            if (isset($_GET["id"])) {
                $sender = $_GET["id"];
                $msg_rs = Database::search("SELECT * FROM `chat` WHERE (`from` = '" . $receiever . "' AND `to` = '" . $sender . "') OR (`from` = '" . $sender . "' AND `to` = '" . $receiever . "') ");

                $msg_num = $msg_rs->num_rows;

                if ($msg_num == 0) {
            ?>
                    <div class="modal" tabindex="-1" id="chatModal<?php echo $sender; ?>">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Start a new chat</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-12">
                                        <label class="form-label">Rreceiver</label>
                                        <input type="email" class="form-controll" value="<?php echo $sender; ?>" id="r">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">Message</label>
                                        <textarea class="form-control" rows="10" id="m"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="sendMessage();">Send message</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        openChat('<?php echo $sender ?>');
                    </script>

            <?php
                } else {
                    for ($x = 0; $x < $msg_num; $x++) {
                        $msg_data = $msg_rs->fetch_assoc();
                    }
                }
            } else {
            }



            ?>

            <div class="col-12">
                <hr />
            </div>

            <div class="col-12 py-5 px-4">
                <div class="row overflow-hidden shadow rounded">
                    <div class="col-12 col-lg-5 px-0">
                        <div class="bg-white">
                            <div class="bg-light px-4 py-2">
                                <div class="col-12">
                                    <h5 class="mb-0 py-1">Recents</h5>
                                </div>
                                <div class="col-12">

                                    <?php

                                    $recents_rs = Database::search("SELECT DISTINCT * FROM `chat` WHERE 
                                    `from` = '" . $receiever . "' ORDER BY `chat_date_time` DESC");
                                    $recents_num = $recents_rs->num_rows;

                                    ?>

                                    <!--  -->
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Received</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Sent</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                            <div class="message_box" id="message_box">


                                                <?php
                                                for ($i = 0; $i < $recents_num; $i++) {
                                                    $recents_data = $recents_rs->fetch_assoc();

                                                    $from = $recents_data["from"];
                                                    $user_rs = Database::search("SELECT * FROM `user` WHERE `email` = '" . $from . "'");
                                                    $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $from . "'");
                                                    $user_data = $user_rs->fetch_assoc();
                                                    $image_data = $image_rs->fetch_assoc();

                                                ?>
                                                    <div class="list-group rounded-0" onclick="viewMsg('<?php echo $from; ?>');">
                                                        <a href="#" class="list-group-item list-group-item-action rounded-0
                                                        
                                                        <?php

                                                        if ($recents_data["chat_status"] == 1) {
                                                        ?> bg-primary  text-white
                                                        <?php
                                                        } elseif ($recents_data["chat_status"] == 2) {
                                                        ?> bg-body text-dark<?php
                                                        }

                                                        ?>
                                                        ">

                                                            <div class="media">


                                                                <?php

                                                                if (isset($image_data["img_path"])) {
                                                                ?>
                                                                    <img src="<?php echo $image_data["img_path"]; ?>" width="50px" class="rounded-circle">
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <img src="resources/new_user.svg" class="rounded-circle" width="50px" />
                                                                <?php
                                                                }

                                                                ?>

                                                                <div class="me-4">
                                                                    <div class="d-flex align-items-center justify-content-between mb-1 ">
                                                                        <h6 class="mb-0 fw-bold"><?php echo $user_data["fname"]; ?></h6>
                                                                        <small class="small fw-bold"><?php echo $recents_data["chat_date_time"]; ?></small>

                                                                    </div>
                                                                    <p class="mb-0"><?php echo $recents_data["content"]; ?></p>
                                                                </div>
                                                            </div>
                                                        </a>

                                                    </div>

                                                <?php

                                                }

                                                ?>



                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">

                                            <div class="message_box" id="message_box">

                                                <?php

                                                $sent_rs = Database::search("SELECT DISTINCT * FROM `chat` WHERE `from` = '" . $receiever . "' ORDER BY `chat_date_time` DESC");
                                                $sent_num = $sent_rs->num_rows;

                                                for ($x = 0; $x < $sent_num; $x++) {
                                                    $sent_data = $sent_rs->fetch_assoc();
                                                    $r = $sent_data["to"];

                                                    $user_rs2 = Database::search("SELECT * FROM `user` WHERE `email` = '" . $r . "'");
                                                    $img_rs2 = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $r . "'");

                                                    $user_data2 = $user_rs2->fetch_assoc();
                                                    $image_data2 = $img_rs2->fetch_assoc();

                                                ?>
                                                    <div class="list-group rounded-0" onclick="viewMsg('<?php echo $sender; ?>');">
                                                        <a href="#" class="list-group-item list-group-item-action text-black rounded-0 bg-secondary">
                                                            <div class="media">

                                                                <?php

                                                                if (isset($image_data2["img_path"])) {
                                                                ?>
                                                                    <img src="<?php echo $image_data2["img_path"]; ?>" width="50px" class="rounded-circle">
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <img src="resources/new_user.svg" class="rounded-circle" width="50px" />
                                                                <?php
                                                                }

                                                                ?>

                                                                <div class="me-4">
                                                                    <div class="d-flex align-items-center justify-content-between mb-1 ">
                                                                        <h6 class="mb-0 fw-bold"><?php echo $user_data2["fname"]; ?></h6>
                                                                        <small class="small fw-bold"><?php echo $sent_data["chat_date_time"]; ?></small>

                                                                    </div>
                                                                    <p class="mb-0"><?php echo $sent_data["content"]; ?></p>
                                                                </div>
                                                            </div>
                                                        </a>

                                                    </div>

                                                <?php

                                                }

                                                ?>

                                            </div>


                                        </div>
                                    </div>
                                    <!--  -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-7 px-0">
                        <div class="row px-4 py-5 text-white chat_box" id="chat_box">

                            <!-- view area -->





                        </div>
                        <!-- txt -->
                        <div class="col-12 px-2">
                            <div class="row">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control rounded border-0 py-3 bg-light" placeholder="Type a message ..." aria-describedby="send_btn" id="msg_txt" />
                                    <button class="btn btn-light fs-2" id="send_btn"><i class="bi bi-send-fill fs-1"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- txt -->
                    </div>

                </div>
            </div>

            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/script.js"></script>
</body>

</html>