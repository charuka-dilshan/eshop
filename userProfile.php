<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Profile | eShop</title>

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php
            include "header.php";
            include "connection.php";

            if (isset($_SESSION["u"])) {

                $email = $_SESSION["u"]["email"];

                $details_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON user.gender_gender_id = gender.gender_id WHERE `email` = '" . $email . "'");
                $address_rs = Database::search("SELECT * FROM `user_has_address` INNER JOIN `city` ON 
                user_has_address.city_city_id = city.city_id INNER JOIN `district` ON
                city.district_district_id = district.district_id INNER JOIN `province` ON
                district.province_province_id = province.province_id WHERE `user_email` = '" . $email . "' ");

                $image_rs = Database::search("SELECT * FROM `profile_img` WHERE `user_email` = '" . $email . "'");

                $image_data = $image_rs->fetch_assoc();
                $details_data = $details_rs->fetch_assoc();
                $address_data = $address_rs->fetch_assoc();


            ?>
                <div class="col-12 bg-primary">
                    <div class="row">

                        <div class="col-12 bg-body rounded mt-4 mb-4">
                            <div class="row g-2">

                                <div class="col-md-3 border-end">
                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">

                                        <?php

                                        if (empty($image_data["img_path"])) {
                                        ?>
                                            <img src="resources/new_user.svg" class="rounded mt-5" style="width: 150px;" id="img"/>
                                        <?php
                                        } else {
                                        ?>
                                            <img src="<?php echo $image_data["img_path"]; ?>" class="rounded mt-5" style="width: 150px;" id="img"/>
                                        <?php
                                        }

                                        ?>


                                        <span class="fw-bold"><?php echo $details_data["fname"] . " " . $details_data["lname"] ?></span>
                                        <span class="fw-bold text-black-50"><?php echo $details_data["email"] ?></span>

                                        <input type="file" class="d-none" id="profileimage" />
                                        <label for="profileimage" class="btn btn-primary mt-5" onclick="changeProfileImg();">Update Profile Image</label>

                                    </div>
                                </div>

                                <div class="col-md-5 border-end">
                                    <div class="p-3 py-5">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="fw-bold">Profile Settings</h4>
                                        </div>

                                        <div class="row mt-4">

                                            <div class="col-6">
                                                <label class="form-label">First Name</label>
                                                <input type="text" class="form-control" value="<?php echo $details_data["fname"] ?>" id="fname"/>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" class="form-control" value="<?php echo $details_data["lname"] ?>" id="lname"/>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Mobile</label>
                                                <input type="text" class="form-control" value="<?php echo $details_data["mobile"] ?>" id="mobile"/>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" value="abcdef" id="pw" readonly />
                                                    <span class="input-group-text bg-primary" id="basic-addon2" onclick="showPassword3();">
                                                        <i class="bi bi-eye-slash-fill text-white" id="pwi"></i>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $details_data["email"] ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Registered Date</label>
                                                <input type="text" class="form-control" readonly value="<?php echo $details_data["joined_date"] ?>" />
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Address Line 01</label>

                                                <?php

                                                if (!isset($address_data["line1"])) {
                                                ?>
                                                    <input type="text" class="form-control" placeholder="Type address line 01" id="line1"/>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" class="form-control" value="<?php echo $address_data["line1"] ?>" id="line1"/>
                                                <?php
                                                }

                                                ?>

                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Address Line 02</label>
                                                <?php
                                                if (!isset($address_data["line2"])) {
                                                ?>
                                                    <input type="text" class="form-control" placeholder="Type address line 02" id="line2"/>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" class="form-control" value="<?php echo $address_data["line2"] ?>" id="line2"/>
                                                <?php
                                                }

                                                ?>
                                            </div>

                                            <?php

                                            $province_rs = Database::search("SELECT * FROM `province`");
                                            $district_rs = Database::search("SELECT * FROM `district`");
                                            $city_rs = Database::search("SELECT * FROM `city`");

                                            ?>

                                            <div class="col-6">
                                                <label class="form-label">Province</label>
                                                <select class="form-select" onchange="selectDistrict();" id="province">
                                                    <option value="0">Select Province</option>
                                                    <?php

                                                    for ($x = 0; $x < $province_rs->num_rows; $x++) {
                                                        $province_data = $province_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $province_data["province_id"] ?> 
                                                        <?php

                                                        if (!empty($address_data["province_id"])) {
                                                            if ($province_data["province_id"] == $address_data["province_id"]) {
                                                        ?>
                                                                selected
                                                                <?php
                                                            }
                                                        }

                                                                ?>"><?php echo $province_data["province_name"] ?></option>
                                                    <?php
                                                    }

                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label">District</label>
                                                <select class="form-select" id="district">
                                                    <option value="0">Select District</option>
                                                    <?php

                                                    for ($x = 0; $x < $district_rs->num_rows; $x++) {
                                                        $district_data = $district_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $district_data["district_id"] ?>" <?php

                                                                                                                    if (!empty($address_data["district_id"])) {
                                                                                                                        if ($district_data["district_id"] == $address_data["district_id"]) {
                                                                                                                    ?> selected <?php
                                                                                                                            }
                                                                                                                        }

                                                                                                                                ?>><?php echo $district_data["district_name"] ?></option>
                                                    <?php
                                                    }

                                                    ?>

                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label">City</label>
                                                <select class="form-select" id="city">
                                                    <option value="0">Select City</option>
                                                    <?php

                                                    for ($x = 0; $x < $city_rs->num_rows; $x++) {
                                                        $city_data = $city_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo $city_data["city_id"] ?>" <?php

                                                                                                            if (!empty($address_data["city_id"])) {
                                                                                                                if ($city_data["city_id"] == $address_data["city_id"]) {
                                                                                                            ?> selected <?php
                                                                                                                    }
                                                                                                                }

                                                                                                                        ?>>
                                                            <?php echo $city_data["city_name"] ?>
                                                        </option>
                                                    <?php
                                                    }

                                                    ?>

                                                </select>
                                            </div>

                                            <div class="col-6">
                                                <label class="form-label">Postal Code</label>

                                                <?php

                                                if (empty($address_data["postal_code"])) {
                                                ?>
                                                    <input type="text" class="form-control" placeholder="Enter Your Postal Code" id="pcode"/>
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" class="form-control" value="<?php echo $address_data["postal_code"] ?>" id="pcode"/>
                                                <?php
                                                }

                                                ?>

                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Gender</label>
                                                <input type="text" class="form-control" value="Male" readonly />
                                            </div>

                                            <div class="col-12 d-grid mt-2">
                                                <button class="btn btn-primary" onclick="updateProfile();">Update My Profile</button>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
                                    <div class="row">
                                        <span class="fw-bold text-black-50 mt-5">Display ads</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            <?php
            }else{
                echo ("Longin to your account!");
            }

            ?>



            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/script.js"></script>
</body>

</html>