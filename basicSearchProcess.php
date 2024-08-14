<?php

include "connection.php";

$txt = $_POST["t"];
$select = $_POST["s"];
$page = $_POST["page"];


$query = "SELECT * FROM `product` ";

if (!empty($txt)) {
    $query .= "WHERE `title` LIKE '%" . $txt . "%'";
} elseif (empty($txt) && $select != 0) {
    $query .= "WHERE `category_cat_id` = '" . $select . "'";
} elseif (!empty($txt) && $select != 0) {
    $query .= "WHERE `title` LIKE '%" . $txt . "%' AND `category_cat_id` = '" . $select . "'";
}
?>

<div class="row">
    <div class="offset-lg-1 col-12 col-lg-10 text-center">
        <div class="row justify-content-center gap-2">
            <?php

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
        </div>
    </div>
</div>

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
                    onclick="basicSearch(<?php echo ($pageno - 1); ?>)"
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
                        <a class="page-link" onclick="basicSearch(<?php echo ($x); ?>)">
                            <?php echo $x; ?>
                        </a>
                    </li <?php
                        } else {
                            ?> <li class="page-item">
                    <a class="page-link" onclick="basicSearch(<?php echo ($x); ?>)">
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
                    onclick="basicSearch(<?php echo ($pageno + 1); ?>)"
                    <?php
                    }
                    ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>