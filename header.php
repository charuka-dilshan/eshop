<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />

</head>

<body>

    <div class="col-12">
        <div class="row mt-1 mb-1">

            <div class="offset-lg-1 col-12 col-lg-3 align-self-start mt-2">

                <?php

                session_start();
                if (isset($_SESSION["u"])) {
                $data = $_SESSION["u"];
                ?>
                    <span class="text-lg-start text-success"><b>Hi!, </b> <?php echo ($data["fname"]) ?></span> |
                    <span class="text-lg-start fw-bold signout" onclick="signOut();">Signout</span> |
                <?php
                } else {
                ?>
                    <a href="index.php" class="text-decoration-none fw-bold">Sign In or Register</a> |
                <?php
                }

                ?>

                <span class="text-lg-start fw-bold">Help and Contact</span>

            </div>

            <div class="col-12 col-lg-3 offset-lg-5 align-self-end" style="text-align: center;">
                <div class="row">

                    <div class="col-1 col-lg-3 mt-2">
                        <span class="text-start fw-bold">Sell</span>
                    </div>

                    <div class="col-12 col-lg-6 dropdown">
                        <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            My eShop
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="userProfile.php">My Profile</a></li>
                            <li><a class="dropdown-item" href="#">My Sellings</a></li>
                            <li><a class="dropdown-item" href="myProducts.php">My Products</a></li>
                            <li><a class="dropdown-item" href="watchlist.php">Watchlist</a></li>
                            <li><a class="dropdown-item" href="purchasingHistory.php">Purchase History</a></li>
                            <li><a class="dropdown-item" href="#">Messages</a></li>
                            <li><a class="dropdown-item" href="#">Contact Admin</a></li>
                        </ul>
                    </div>

                    <div class="col-1 col-lg-3 ms-5 ms-lg-0 mt-1 cart-icon"></div>

                    <!-- msg modal -->
                    <div class="modal" tabindex="-1" id="contactAdmin">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contact Admin</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body overflow-scroll">
                                    <!-- received -->
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="col-8 rounded bg-success">
                                                <div class="row">
                                                    <div class="col-12 pt-2">
                                                        <span class="text-white fw-bold fs-4">Hello there!!!</span>
                                                    </div>
                                                    <div class="col-12 text-end pb-2">
                                                        <span class="text-white fs-6">2022-11-9 00:00:00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- received -->
                                    <!-- sent -->
                                    <div class="col-12 mt-2">
                                        <div class="row">
                                            <div class="offset-4 col-8 rounded bg-primary">
                                                <div class="row">
                                                    <div class="col-12 pt-2">
                                                        <span class="text-white fw-bold fs-4">Hello there!!!</span>
                                                    </div>
                                                    <div class="col-12 text-end pb-2">
                                                        <span class="text-white fs-6">2022-11-9 00:00:00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- sent -->
                                </div>
                                <div class="modal-footer">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-9">
                                                <input type="text" class="form-control" id="msgtxt" />
                                            </div>
                                            <div class="col-3 d-grid">
                                                <button type="button" class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--  -->

                </div>
            </div>

        </div>
    </div>


    <script src="js/script.js"></script>
</body>

</html>