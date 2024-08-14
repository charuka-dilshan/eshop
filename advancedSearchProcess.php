<?php

include "connection.php";
session_start();

$text = $_POST["t"];
$category = $_POST["cat"];
$brand = $_POST["b"];
$model = $_POST["m"];
$color = $_POST["col"];
$condition = $_POST["con"];
$from = $_POST["pf"];
$to = $_POST["pt"];
$sort = $_POST["s"];

$query = "SELECT * FROM `product` ";
$status = 0;

if ($sort == 0) {

    if (!empty($text)) {
        $query .= "WHERE `title` LIKE '%" . $text . "%'";
        $status = 1;
    }

    if ($category != 0 && $status = 0) {
        $query .= "WHERE `category_cat_id` = '" . $category . "'";
        $status = 1;
    } elseif ($category != 0 && $status != 0) {
        $query .= " AND `category_cat_id` = '" . $category . "'";
    }

    $pid = 0;
    if ($brand != 0 && $model == 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE `brand_brand_id` = '" . $brand . "'");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id` = '" . $pid . "'";
            $status = 1;
        } elseif ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id` = '" . $pid . "'";
        }
    }

    if ($brand == 0 && $model != 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE `brand_brand_id` = '" . $model . "'");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id` = '" . $pid . "'";
            $status = 1;
        } elseif ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id` = '" . $pid . "'";
        }
    }

    if ($brand != 0 && $model != 0) {
        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE `brand_brand_id` = '" . $brand . "' AND `model_model_id` = '" . $model . "'");
        for ($y = 0; $y < $mhb_rs->num_rows; $y++) {
            $mhb_data = $mhb_rs->fetch_assoc();
            $pid = $mhb_data["model_has_brand_id"];
        }

        if ($status == 0) {
            $query .= "WHERE `model_has_brand_model_has_brand_id` = '" . $pid . "'";
            $status = 1;
        } elseif ($status != 0) {
            $query .= " AND `model_has_brand_model_has_brand_id` = '" . $pid . "'";
        }
    }

    if ($condition != 0 && $status == 0) {
        $query .= "WHERE `condition_condition_id` = '" . $condition . "'";
        $status = 1;
    } elseif ($condition != 0 && $status != 0) {
        $query .= "AND `condition_condition_id` = '" . $condition . "'";
    }

    if ($color != 0 && $status == 0) {
        $query .= "WHERE `condition_condition_id` = '" . $color . "'";
        $status = 1;
    } elseif ($color != 0 && $status != 0) {
        $query .= "AND `condition_condition_id` = '" . $color . "'";
    }

    if (!empty($from) && empty($to)) {
        if ($status == 0) {
            $query .= "WHERE `price` >= '" . $from . "'";
            $status = 1;
        } elseif ($status != 0) {
            $query .= " AND `price` >= '" . $from . "'";
        }
    }

    if (empty($from) && !empty($to)) {
        if ($status == 0) {
            $query .= "WHERE `price` <= '" . $to . "'";
            $status = 1;
        } elseif ($status != 0) {
            $query .= " AND `price` <= '" . $to . "'";
        }
    }

    if (!empty($from) && !empty($to)) {
        if ($status == 0) {
            $query .= "WHERE `price` BETWEEN '" . $from . "' AND '" . $to . "'";
            $status = 1;
        } elseif ($status != 0) {
            $query .= " AND `price` BETWEEN '" . $from . "' AND '" . $to . "'";
        }
    }
} elseif ($sort == 1) {
    if (!empty($text)) {
        $query .= "WHERE `title` LIKE '%" . $text . "%' ORDER BY `price` ASC";
        $status = 1;
    }
    // price low to high
} elseif ($sort == 2) {
    // price hig to low
} elseif ($sort == 3) {
    // qty low to high
} elseif ($sort == 4) {
    // qty high to low
}

$page = $_POST["page"];

$pageno;

if ("0" != $page) {
    $pageno = $page;
} else {
    $pageno = 1;
}

$product_rs = Database::search($query);
$product_num = $product_rs->num_rows;

$products_per_page = 3;
$number_of_pages = ceil($product_num / $products_per_page);

$page_results = ($pageno - 1) * $products_per_page;

$selected_rs = Database::search($query .= " LIMIT " . $products_per_page . " OFFSET " . $page_results);
$selected_num = $selected_rs->num_rows;

for ($x = 0; $x < $selected_num; $x++) {
    $selected_data = $selected_rs->fetch_assoc();
?>



    <div class="card col-6 col-lg-2 mt-2 mb-2" style="width: 18rem;">

        <?php

        $img_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id` = '" . $selected_data["id"] . "' ");
        $img_num = $img_rs->num_rows;
        $img_data = $img_rs->fetch_assoc();

        if ($img_num > 0) {
        ?>
            <img src="<?php echo ($img_data["img_path"]); ?>" class="card-img-top img-thumbnail mt-2" style="height: 180px;" />
        <?php

        } else {
        ?>
            <img src="resources/mobile_images/iphone12.jpg" class="card-img-top img-thumbnail mt-2" style="height: 180px;" />
        <?php
        }

        ?>

        <div class="card-body ms-0 m-0 text-center">
            <h5 class="card-title fw-bold fs-6"><?php echo $selected_data["title"] ?></h5>
            <span class="badge rounded-pill text-bg-info">New</span><br />
            <span class="card-text text-primary">Rs. <?php echo $selected_data["price"] ?> .00</span><br />

            <?php

            if ($selected_data["qty"] > 0) {
            ?>
                <span class="card-text text-warning fw-bold">In Stock</span><br />
                <span class="card-text text-success fw-bold"><?php echo $selected_data["qty"] ?> Items Available</span><br /><br />
                <a href='#' class="col-12 btn btn-success">Buy Now</a>
            <?php
            } else {
            ?>
                <span class="card-text text-danger fw-bold">In Stock</span><br />
                <span class="card-text text-danger fw-bold">00 Items Available</span><br /><br />
                <a href='#' class="col-12 btn btn-success disabled">Buy Now</a>
            <?php
            }

            ?>

            <button class="col-12 btn btn-dark mt-2">
                <i class="bi bi-cart-plus-fill text-white fs-5"></i>
            </button>

            <button class="col-12 btn btn-outline-light mt-2 border border-primary">
                <i class="bi bi-heart-fill text-danger fs-5"></i>
            </button>

        </div>
    </div>



<?php
}

?>

<div class="offset-2 offset-lg-3 col-8 col-lg-6 text-center mb-3">
    <nav aria-label="Page navigation example">
        <ul class="pagination pagination-lg justify-content-center">
            <li class="page-item">
                <a class="page-link"
                    <?php
                    if ($pageno <= 1) {
                        echo ("#");
                    } else {
                    ?>
                    onclick="advancedSearch(<?php echo ($pageno - 1); ?>)"
                    <?php
                    }
                    ?>
                    aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php

            for ($x = 1; $x <= $number_of_pages; $x++) {
                if ($pageno == $x) {
            ?>
                    <li class="page-item active">
                        <a class="page-link" onclick="advancedSearch(<?php echo ($x); ?>)">
                            <?php echo $x; ?>
                        </a>
                    </li <?php
                        } else {
                            ?> <li class="page-item">
                    <a class="page-link" onclick="advancedSearch(<?php echo ($x); ?>)">
                        <?php echo $x; ?>
                    </a>
                    </li>
            <?php
                        }
                    }

            ?>
            <li class="page-item">
                <a class="page-link"
                    <?php
                    if ($pageno >= $number_of_pages) {
                        echo ("#");
                    } else {
                    ?>
                    onclick="advancedSearch(<?php echo ($pageno + 1); ?>)"
                    <?php
                    }
                    ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>