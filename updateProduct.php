<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Update Product | eShop</title>
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body>

    <div class="container-fluid">
        <div class="row gy-3">

            <?php
            include "header.php";
            include "connection.php";

            if (isset($_SESSION["u"])) {
                $pid = $_GET["id"];

                $product_rs = Database::search("SELECT * FROM `product` INNER JOIN `category` ON 
                product.category_cat_id = category.cat_id INNER JOIN `model_has_brand` ON
                product.model_has_brand_model_has_brand_id = model_has_brand.model_has_brand_id INNER JOIN `model` ON
                model_has_brand.model_model_id = model.model_id INNER JOIN `brand` ON
                model_has_brand.brand_brand_id = brand.brand_id INNER JOIN `color` ON
                product.color_clr_id = color.clr_id WHERE `id` = '" . $pid . "'
                ");

                $product_data = $product_rs->fetch_assoc();
            ?>
                <div class="col-12">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="h2 text-primary fw-bold">Update Product</h2>
                        </div>

                        <div class="col-12">
                            <div class="row">

                                <div class="col-12 col-lg-4 border-end border-success">
                                    <div class="row">

                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Product Category</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select text-center" disabled>
                                                <option><?php echo $product_data["cat_name"] ?></option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-4 border-end border-success">
                                    <div class="row">

                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Product Brand</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select text-center" disabled>
                                                <option><?php echo $product_data["brand_name"] ?></option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-4 border-end border-success">
                                    <div class="row">

                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Product Model</label>
                                        </div>

                                        <div class="col-12">
                                            <select class="form-select text-center" disabled>
                                                <option><?php echo $product_data["model_name"] ?></option>
                                            </select>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-success" />
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">
                                                Product Title
                                            </label>
                                        </div>
                                        <div class="offset-0 offset-lg-2 col-12 col-lg-8">
                                            <input type="text" class="form-control" value="<?php echo $product_data["title"] ?>" id="t"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-success" />
                                </div>

                                <div class="col-12">
                                    <div class="row">

                                        <div class="col-12 col-lg-4 border-end border-success">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold" style="font-size: 20px;">Product Condition</label>
                                                </div>

                                                <?php
                                                if ($product_data["condition_condition_id"] == 1) {
                                                ?>
                                                    <div class="col-12">
                                                        <div class="form-check form-check-inline mx-5">
                                                            <input class="form-check-input" type="radio" id="b" name="c" checked disabled />
                                                            <label class="form-check-label fw-bold" for="b">Brandnew</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="u" name="c" disabled />
                                                            <label class="form-check-label fw-bold" for="u">Used</label>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                    ?>
                                                    <div class="col-12">
                                                        <div class="form-check form-check-inline mx-5">
                                                            <input class="form-check-input" type="radio" id="b" name="c" disabled />
                                                            <label class="form-check-label fw-bold" for="b">Brandnew</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" id="u" name="c" checked disabled />
                                                            <label class="form-check-label fw-bold" for="u">Used</label>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 border-end border-success">
                                            <div class="row">

                                                <div class="col-12">
                                                    <label class="form-label fw-bold" style="font-size: 20px;">Product Colour</label>
                                                </div>

                                                <div class="col-12">
                                                    <select class="form-select" disabled>
                                                        <option><?php echo $product_data["clr_name"] ?></option>
                                                    </select>
                                                </div>

                                                <div class="col-12">
                                                    <div class="input-group mt-2 mb-2">
                                                        <input type="text" class="form-control" placeholder="Add new Colour" disabled />
                                                        <button class="btn btn-outline-primary" type="button" id="button-addon2" disabled>+ Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold" style="font-size: 20px;">Product Quantity</label>
                                                </div>
                                                <div class="col-12">
                                                    <input type="number" class="form-control" min="0" value="<?php echo $product_data["qty"] ?>" id="q" />
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-success" />
                                </div>

                                <div class="col-12">
                                    <div class="row">

                                        <div class="col-6 border-end border-success">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold" style="font-size: 20px;">Cost Per Item</label>
                                                </div>
                                                <div class="offset-0 offset-lg-2 col-12 col-lg-8">
                                                    <div class="input-group mb-2 mt-2">
                                                        <span class="input-group-text">Rs.</span>
                                                        <input type="text" class="form-control" disabled value="<?php echo $product_data["price"] ?>" />
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold" style="font-size: 20px;">Approved Payment Methods</label>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="offset-0 offset-lg-2 col-2 pm pm1"></div>
                                                        <div class="col-2 pm pm2"></div>
                                                        <div class="col-2 pm pm3"></div>
                                                        <div class="col-2 pm pm4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-success" />
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Delivery Cost</label>
                                        </div>
                                        <div class="col-12 col-lg-6 border-end border-success">
                                            <div class="row">
                                                <div class="col-12 offset-lg-1 col-lg-3">
                                                    <label class="form-label">Delivery cost Within Colombo</label>
                                                </div>
                                                <div class="col-12 col-lg-8">
                                                    <div class="input-group mb-2 mt-2">
                                                        <span class="input-group-text">Rs.</span>
                                                        <input type="text" class="form-control" value="<?php echo $product_data["delivery_fee_colombo"] ?>" id="dwc"/>
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-12 offset-lg-1 col-lg-3">
                                                    <label class="form-label">Delivery cost out of Colombo</label>
                                                </div>
                                                <div class="col-12 col-lg-8">
                                                    <div class="input-group mb-2 mt-2">
                                                        <span class="input-group-text">Rs.</span>
                                                        <input type="text" class="form-control" value="<?php echo $product_data["delivery_fee_other"] ?>" id="doc"/>
                                                        <span class="input-group-text">.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-success" />
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Product Description</label>
                                        </div>
                                        <div class="col-12">
                                            <textarea cols="30" rows="15" class="form-control" id="d"><?php echo $product_data["description"] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-success" />
                                </div>

                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold" style="font-size: 20px;">Add Product Images</label>
                                        </div>
                                        <div class="offset-lg-3 col-12 col-lg-6">

                                            <?php
                                            
                                            $img = array();

                                            $img[0] = "resources/addproductimg.svg";
                                            $img[1] = "resources/addproductimg.svg";
                                            $img[2] = "resources/addproductimg.svg";

                                            $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id` = '".$pid."'");
                                            $img_num = $img_rs->num_rows;

                                            for($x = 0 ; $x < $img_num ; $x++){
                                                $img_data = $img_rs->fetch_assoc();
                                                $img[$x] = $img_data["img_path"];

                                            }
                                            

                                            ?>

                                            <div class="row">
                                                <div class="col-4 border border-primary rounded">
                                                    <img src="<?php echo $img[0] ?>" class="img-fluid" style="width: 250px;" id="i0"/>
                                                </div>
                                                <div class="col-4 border border-primary rounded">
                                                    <img src="<?php echo $img[1] ?>" class="img-fluid" style="width: 250px;" id="i1"/>
                                                </div>
                                                <div class="col-4 border border-primary rounded">
                                                    <img src="<?php echo $img[2] ?>" class="img-fluid" style="width: 250px;" id="i2"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="offset-lg-3 col-12 col-lg-6 d-grid mt-3">
                                            <input type="file" class="d-none" id="imageuploader" multiple />
                                            <label for="imageuploader" class="col-12 btn btn-primary" onclick="changeProductImage();">Upload Images</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border-success" />
                                </div>

                                <div class="offset-lg-4 col-12 col-lg-4 d-grid mt-3 mb-3">
                                    <button class="btn btn-dark" onclick="updateProduct('<?php echo $product_data['id'] ?>');">Update Product</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            <?php
            
            } else {
                echo ("please login to your account");
            }

            ?>



            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>