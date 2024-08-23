<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice | eShop</title>

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resource/logo.svg" />
</head>

<body class="mt-2" style="background-color: #f7f7ff;">

    <div class="container-fluid">
        <div class="row">
            <?php include "header.php";

            include "connection.php";

            if (isset($_SESSION["u"])) {

                $mail = $_SESSION["u"]["email"];
                $oid = $_GET["id"];

                $invoice_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `user` ON
                invoice.user_email = user.email INNER JOIN `product` ON
                invoice.product_id = product.id WHERE `order_id` = '" . $oid . "' ");

                $invoice_data = $invoice_rs->fetch_assoc();

            ?>
                <div class="col-12">
                    <hr />
                </div>

                <div class="col-12 btn-toolbar justify-content-end">
                    <button class="btn btn-dark me-2" onclick="printInvoice();">
                        <i class="bi bi-printer-fill"></i>
                        Print
                    </button>
                    <button class="btn btn-danger me-2"><i class="bi bi-filetype-pdf"></i> Export as PDF</button>
                </div>

                <div class="col-12">
                    <hr />
                </div>

                <div class="col-12" id="page">
                    <div class="row">

                        <div class="col-6">
                            <div class="ms-5 invoiceHeaderImage"></div>
                        </div>

                        <div class="col-6">
                            <div class="row">
                                <div class="col-12 text-primary text-decoration-underline text-end">
                                    <h2>eShop</h2>
                                </div>
                                <div class="col-12 fw-bold text-end">
                                    <span>Maradana, Colombo 10, Sri Lanka.</span><br />
                                    <span>+94112 555448</span><br />
                                    <span>eshop@gmail.com</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-primary" />
                        </div>

                        <div class="col-12 mb-4">
                            <div class="row">
                                <?php

                                $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '" . $mail . "'");
                                $address_data = $address_rs->fetch_assoc();

                                ?>
                                <div class="col-6">
                                    <h5 class="fw-bold">INVOICE TO :</h5>
                                    <h2><?php echo ($invoice_data["fname"] . " " . $invoice_data["lname"]); ?></h2>
                                    <span><?php echo ($address_data["line1"] . ", " . $address_data["line2"]); ?></span><br />
                                    <span><?php echo $mail; ?></span>
                                </div>

                                <div class="col-6 text-end mt-4">
                                    <h1 class="text-primary">INVOICE <?php echo ($invoice_data["invoice_id"]); ?></h1>
                                    <span class="fw-bold">Data & Time of Invoice : </span>&nbsp;
                                    <span class="fw-bold"><?php echo ($invoice_data["date"]); ?></span>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <table class="table">
                                <thead>
                                    <tr class="border border-1 border-secondary">
                                        <th>#</th>
                                        <th>Order ID & Product</th>
                                        <th class="text-end">Unit Price</th>
                                        <th class="text-end">Quantity</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="height: 72px;">
                                        <td class="bg-primary text-white fs-3"><?php echo ($invoice_data["invoice_id"]); ?></td>
                                        <td>
                                            <span class="fw-bold text-primary text-decoration-underline p-2"><?php echo $oid; ?></span><br />
                                            <span class="fw-bold text-primary fs-3 p-2"><?php echo ($invoice_data["title"]); ?></span>
                                        </td>
                                        <td class="fw-bold fs-6 text-end pt-3 bg-secondary text-white">Rs. <?php echo ($invoice_data["price"]); ?> .00</td>
                                        <td class="fw-bold fs-6 text-end pt-3"><?php echo ($invoice_data["invoice_qty"]); ?></td>
                                        <td class="fw-bold fs-6 text-end pt-3 bg-secondary text-white">Rs. <?php echo ($invoice_data["invoice_qty"] * $invoice_data["price"]); ?> .00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <?php

                                    $city_rs = Database::search("SELECT * FROM `city` WHERE `city_id` = '" . $address_data["city_city_id"] . "'");
                                    $city_data = $city_rs->fetch_assoc();

                                    $delivery = 0;

                                    if ($city_data["district_district_id"] == 4) {
                                        $delivery = $invoice_data["delivery_fee_colombo"];
                                    } else {
                                        $delivery = $invoice_data["delivery_fee_other"];
                                    }

                                    $sub_total = $invoice_data["invoice_qty"] * $invoice_data["price"];

                                    ?>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold">SUBTOTAL</td>
                                        <td class="text-end">Rs. <?php echo $sub_total; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold border-primary">Delivery Fee</td>
                                        <td class="text-end border-primary">Rs. <?php echo $delivery; ?> .00</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="border-0"></td>
                                        <td class="fs-5 text-end fw-bold border-primary text-primary">GRAND TOTAL</td>
                                        <td class="fs-5 text-end fw-bold border-primary text-primary">Rs. <?php echo ($invoice_data["total"]); ?> .00</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="col-4 text-center" style="margin-top: -100px;">
                            <span class="fs-1 fw-bold text-success">Thank You !</span>
                        </div>

                        <div class="col-12 mt-3 mb-3 border-0 border-start border-5 border-primary rounded" style="background-color: #e7f2ff;">
                            <div class="row">
                                <div class="col-12 mt-3 mb-3">
                                    <label class="form-label fs-5 fw-bold">NOTICE : </label>
                                    <br />
                                    <label class="form-label fs-6">Purchased items can return befor 7 days of Delivery.</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr class="border border-1 border-primary" />
                        </div>

                        <div class="col-12 text-center mb-3">
                            <label class="form-label fs-5 text-black-50 fw-bold">
                                Invoice was created on a computer and is valid without the Signature and Seal.
                            </label>
                        </div>

                    </div>
                </div>
            <?php

            }

            ?>
            <?php include "footer.php"; ?>
        </div>
    </div>

    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/script.js"></script>
</body>

</html>