<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Advanced Search | eShop</title>

    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css" />

    <link rel="icon" href="resources/logo.svg" />

</head>

<body class="bg-info">

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 bg-body mb-2">
                <?php include "header.php"; ?>
            </div>

            <div class="col-12 bg-body mb-2">
                <div class="row">
                    <div class="offset-lg-4 col-12 col-lg-4">
                        <div class="row">
                            <div class="col-2">
                                <div class="mt-2 mb-2 logo" style="height: 80px;"></div>
                            </div>
                            <div class="col-10 text-center">
                                <P class="fs-1 text-black-50 fw-bold mt-3 pt-2">Advanced Search</P>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offset-lg-2 col-12 col-lg-8 mb-3 bg-body rounded">
                <div class="row">

                    <div class="offset-lg-1 col-12 col-lg-10">
                        <div class="row">
                            <div class="col-12 col-lg-10 mt-2 mb-1">
                                <input type="text" class="form-control" placeholder="Type keyword to search..."/>
                            </div>
                            <div class="col-12 col-lg-2 mt-2 mb-1 d-grid">
                                <button class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-12">
                                <hr class="border border-3 border-primary">
                            </div>
                        </div>
                    </div>

                    <div class="offset-lg-1 col-12 col-lg-10">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">

                                    <div class="col-12 col-lg-4 mb-3">
                                        <select class="form-select">
                                            <option value="0">Select Category</option>
                                                <option value="">ABC</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-4 mb-3">
                                        <select class="form-select">
                                            <option value="0">Select Brand</option>
                                            <option value="">def</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-4 mb-3">
                                        <select class="form-select">
                                            <option value="0">Select Model</option>
                                            <option value="">ghi</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <select class="form-select">
                                            <option value="0">Select Condition</option>
                                            <option value="">klm</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <select class="form-select">
                                            <option value="0">Select Colour</option>
                                            <option value="">wer</option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <input type="text" class="form-control" placeholder="Price From..."/>
                                    </div>

                                    <div class="col-12 col-lg-6 mb-3">
                                        <input type="text" class="form-control" placeholder="Price To..."/>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="offset-lg-2 col-12 col-lg-8 bg-body rounded mb-3">
                <div class="row">
                    <div class="offset-8 col-4 mt-2 mb-2">
                        <select class="form-select border border-top-0 border-start-0 border-end-0 border-2 border-dark">
                            <option value="0">SORT BY</option>
                            <option value="1">PRICE LOW TO HIGH</option>
                            <option value="2">PRICE HIGH TO LOW</option>
                            <option value="3">QUANTITY LOW TO HIGH</option>
                            <option value="4">QUANTITY HIGH TO LOW</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="offset-lg-2 col-12 col-lg-8 bg-body rounded mb-3">
                <div class="row">
                    <div class="offset-lg-1 col-12 col-lg-10 text-center">
                        <div class="row" id="view_area">
                            <div class="offset-5 col-2 mt-5">
                                <span class="fw-bold text-black-50"><i class="bi bi-search h1" style="font-size: 100px;"></i></span>
                            </div>
                            <div class="offset-3 col-6 mt-3 mb-5">
                                <span class="h1 text-black-50 fw-bold">No Items Searched Yet...</span>
                            </div>
                        </div>
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