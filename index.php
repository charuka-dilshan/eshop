<?php

require "connection.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-shop</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="shortcut icon" href="resources/logo.svg" type="image/x-icon">
</head>

<body class="main-body">
    <div class="container-fluid vh-100 d-flex justify-content-center">
        <div class="row align-content-center">

            <!-- header -->
            <div class="col-12">
                <div class="row">
                    <div class="col-12 logo"></div>
                    <div class="col-12">
                        <p class="text-center title01">Hi, Welcome to eShop!</p>
                    </div>
                </div>
            </div>
            <!-- header -->

            <!-- content -->
            <div class="col-12 p-3">
                <div class="row">
                    <div class="col-6 d-none d-lg-block background"></div>

                    <!-- signUpBox -->
                    <div class="col-12 col-lg-6 d-none" id="signUpBox">
                        <div class="row g-2">

                            <div class="col-12">
                                <p class="title02">Create New Account</p>
                            </div>

                            <div class="col-12 d-none" id="msgdiv">
                                <div class="alert alert-danger" role="alert" id="msg"></div>
                            </div>

                            <div class="col-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" placeholder="Ex: Jhon" id="fname" />
                            </div>

                            <div class="col-6">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" placeholder="Ex: Doe" id="lname" />
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" placeholder="Ex: jhon@gmail.com" id="email" />
                            </div>

                            <div class="col-12">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" />
                            </div>

                            <div class="col-6">
                                <label class="form-label">Mobile</label>
                                <input type="text" class="form-control" placeholder="Ex: 0712345678" id="mobile" />
                            </div>

                            <div class="col-6">
                                <label class="form-label">Gender</label>
                                <select class="form-select" id="gender">
                                    <?php
                                    $rs = Database::search("SELECT * FROM `gender`");
                                    $num = $rs->num_rows;

                                    for ($x = 0; $x < $num; $x++) {
                                        $data = $rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo $data["gender_id"]; ?>"><?php echo $data["gender_name"]; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-primary" onclick="signUp();">Sign Up</button>
                            </div>

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-dark" onclick="changeView();">Already Have An Account? Sign In</button>
                            </div>
                        </div>
                    </div>
                    <!-- signUpBox -->

                    <!-- signInBox -->
                    <div class="col-12 col-lg-6" id="signInBox">
                        <div class="row g-2">
                            <div class="col-12">
                                <p class="title02">Sign In</p>
                            </div>

                            <div class="col-12 d-none" id="msgdiv1">
                                <div class="alert alert-danger" role="alert" id="msg1"></div>
                            </div>

                            <?php
                            $email = "";
                            $password = "";

                            if (isset($_COOKIE["email"])) {
                                $email = $_COOKIE["email"];
                            }

                            if (isset($_COOKIE["password"])) {
                                $password = $_COOKIE["password"];
                            }
                            ?>

                            <div class="col-12">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email2" value="<?php echo ($email); ?>">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" id="password2" value="<?php echo ($password) ?>">
                            </div>

                            <div class="col-6">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label fw-bold">Remember Me</label>
                                </div>
                            </div>

                            <div class="col-6 text-end">
                                <a onclick="forgotPassword();" class="link-primary fw-bold">Forgot Password</a>
                            </div>

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-primary" onclick="signIn();">Sign In</button>
                            </div>

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-danger" onclick="changeView();">New To eShop? Sign Up</button>
                            </div>

                            <div class="col-12 d-grid">
                                <button class="btn btn-success">Go To eShop Admins</button>
                            </div>
                        </div>
                    </div>
                    <!-- signInBox -->

                    <!-- modal -->
                    <div class="modal" tabindex="-1" id="fpmodal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Forgot Password</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">New Password</label>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control" id="np">
                                                <button class="btn btn-outline-secondary" type="button" id="npb" onclick="showPassword1();">Show</button>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Retype Password</label>
                                            <div class="input-group mb-3">
                                                <input type="password" class="form-control" id="rp">
                                                <button class="btn btn-outline-secondary" type="button" id="rpb" onclick="showPassword2();">Show</button>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Verification Code</label>
                                            <input type="text" class="form-control" id="vcode"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset Password </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- modal -->

                    <!-- footer -->
                    <div class="col-12 fixed-bottom">
                        <p class="text-center">&copy; 2024 eShop.lk | All Rights Reserved</p>
                        <p class="text-center fw-bold">Designed By : 2024 Rhino Batch</p>
                    </div>
                    <!-- footer -->

                </div>
            </div>
            <!-- content -->

        </div>
    </div>
    <script src="js/script.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>