<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Watchlist | eShop</title>

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php

            include "header.php";

            include "connection.php";

            if (isset($_SESSION["u"])) {

                $watchlist_rs = Database::search("SELECT * FROM `watchlist` INNER JOIN `product` ON
                watchlist.product_id = product.id INNER JOIN `color` ON
                color.color_id = product.color_color_id INNER JOIN `condition` ON
                product.condition_condition_id = condition.condition_id INNER JOIN `user` ON
                watchlist.user_email = user.email WHERE 
                watchlist.user_email = '" . $_SESSION["u"]["email"] . "'");

                $watchlist_num = $watchlist_rs->num_rows;


            ?>

            <div class="col-12">
                <div class="row">
                    <div class="col-12 border border-1 border-primary rounded mb-2">
                        <div class="row">

                            <div class="col-12">
                                <label class="form-label fs-1 fw-bolder">Watchlist &hearts;</label>
                            </div>

                            <div class="col-12 col-lg-6">
                                <hr />
                            </div>

                            <div class="col-12">
                                <div class="row">
                                    <div class="offset-lg-2 col-12 col-lg-6 mb-3">
                                        <input type="text" class="form-control" placeholder="Search in Watchlist..." />
                                    </div>
                                    <div class="col-12 col-lg-2 mb-3 d-grid">
                                        <button class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr />
                            </div>

                            <div class="col-11 col-lg-2 border-0 border-end border-1 border-dark">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Watchlist</li>
                                    </ol>
                                </nav>
                                <nav class="nav nav-pills flex-column">
                                    <a class="nav-link active" aria-current="page" href="#">My Watchlist</a>
                                    <a class="nav-link" href="cart.php  ">My Cart</a>
                                    <a class="nav-link" href="#">Recents</a>
                                </nav>
                            </div>

                            <?php

                            if ($watchlist_num == 0) {
                            ?>
                                <!-- empty view -->
                                <div class="col-12 col-lg-9">
                                    <div class="row">
                                        <div class="col-12 emptyView"></div>
                                        <div class="col-12 text-center">
                                            <label class="form-label fs-1 fw-bold">You have no items in your Watchlist
                                                yet.</label>
                                        </div>
                                        <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3">
                                            <a href="home.php" class="btn btn-warning fs-3 fw-bold">Start Shopping</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- empty view -->
                            <?php
                            } else {
                            ?>
                                <!-- have products -->
                                <div class="col-12 col-lg-9">
                                    <div class="row">

                                        <?php

                                        for ($x = 0; $x < $watchlist_num; $x++) {
                                            $watchlist_data = $watchlist_rs->fetch_assoc();
                                            $list_id = $watchlist_data["w_id"]
                                        ?>
                                            <div class="card mb-3 mx-0 mx-lg-2 col-12">
                                                <div class="row g-0">
                                                    <div class="col-md-4">

                                                        <img src="resource/mobile_images/iphone12.jpg"
                                                            class="img-fluid rounded-start" style="height: 200px;" />
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="card-body">

                                                            <h5 class="card-title fs-2 fw-bold text-primary"> <?php echo ($watchlist_data["title"]);?>
                                                            </h5>

                                                            <span class="fs-5 fw-bold text-black-50">Colour : Black</span>
                                                            &nbsp;&nbsp; | &nbsp;&nbsp;

                                                            <span class="fs-5 fw-bold text-black-50">Condition : Used</span>
                                                            <br />
                                                            <span class="fs-5 fw-bold text-black-50">Price :</span>&nbsp;&nbsp;
                                                            <span class="fs-5 fw-bold text-black">Rs. 150000 .00</span>
                                                            <br />
                                                            <span class="fs-5 fw-bold text-black-50">Quantity
                                                                :</span>&nbsp;&nbsp;
                                                            <span class="fs-5 fw-bold text-black">10 Items available</span>
                                                            <br />
                                                            <span class="fs-5 fw-bold text-black-50">Seller :</span>
                                                            <br />
                                                            <span class="fs-5 fw-bold text-black">Lahiru</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-5">
                                                        <div class="card-body d-lg-grid">
                                                            <a href="#" class="btn btn-outline-success mb-2">Buy Now</a>
                                                            <a href="#" class="btn btn-outline-warning mb-2">Add to Cart</a>
                                                            <a href="#" class="btn btn-outline-danger" onclick="removeFromWatchlist(<?php echo $list_id ; ?>)">Remove</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }

                                        ?>


                                    </div>
                                </div>
                                <!-- have products -->
                            <?php
                            }

                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            }else{
                echo ("Longin to your account to use watchlist!");
            }
            ?>

            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/script.js"></script>
</body>

</html>