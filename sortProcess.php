<?php

session_start();
include "connection.php";

$email = $_SESSION["u"]["email"];

$search = $_POST["s"];
$time = $_POST["t"];
$condition = $_POST["c"];
$qty = $_POST["q"];

$query = "SELECT * FROM `product` WHERE `user_email` = '" . $email . "'";

if (!empty($search)) {
    $query .= " AND `title` LIKE '%" . $search . "%' ";
}

if ($condition != 0) {
    $query .= " AND `condition_condition_id` = '" . $condition . "'";
}

if ($time != 0) {
    if ($time == "1") {
        $query .= " ORDER BY `datetime_added` DESC";
    } elseif ($time == "2") {
        $query .= " ORDER BY `datetime_added` ASC";
    }
}

if ($time != 0 && $qty != 0) {
    if ($qty == "1") {
        $query .= " , `qty` DESC";
    } elseif ($qty == "2") {
        $query .= " , `qty` ASC";
    }
} elseif ($time == 0 && $qty != 0) {
    if ($qty == "1") {
        $query .= " ORDER BY `qty` DESC";
    } elseif ($qty == "2") {
        $query .= " ORDER BY `qty` ASC";
    }
}

?>

<div class="offset-1 col-10 text-center">
    <div class="row justify-content-center">

        <?php

        if (isset($_POST["page"])) {
            $pageno = $_POST["page"];
        } else {
            $pageno = 1;
        }
        $product_rs = Database::search($query);
        $product_num = $product_rs->num_rows;

        $results_per_page = 3;
        $number_of_pages = ceil($product_num / $results_per_page);

        $page_results = ($pageno - 1) * $results_per_page;
        $selected_rs = Database::search($query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "");
        $s = $query . " LIMIT " . $results_per_page . " OFFSET " . $page_results . "";
        $selected_num = $selected_rs->num_rows;
        for ($x = 0; $x < $selected_num; $x++) {
            $selected_data = $selected_rs->fetch_assoc();
        ?>
            <!-- card -->
            <div class="card mb-3 mt-3 col-12 col-lg-6">
                <div class="row">
                    <div class="col-md-4 mt-4">
                        <?php

                        $productimg_rs = Database::search("SELECT * FROM `product_image` WHERE `product_id` = '" . $selected_data["id"] . "'");
                        $productimg_data = $productimg_rs->fetch_assoc();

                        if ($productimg_rs->num_rows > 0) {
                        ?>
                            <img src="<?php echo $productimg_data["img_path"]; ?>" class="img-fluid rounded-start" />
                        <?php
                        } else {
                        ?>
                            <img src="resources/mobile_images/iphone12.jpg" class="img-fluid rounded-start" style="height:120px ;" />
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo $selected_data["title"] ?></h5>
                            <span class="card-text fw-bold text-primary">Rs. <?php echo $selected_data["price"] ?>
                                .00</span><br />
                            <span class="card-text fw-bold text-success"><?php echo $selected_data["qty"] ?> Items left</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="toggel  <?php echo $selected_data["id"] ?>" onchange="changeStatus(<?php echo $selected_data['id'] ?>)" <?php if ($selected_data["status_status_id"] == 2) {
                                                                                                                                                                                                            ?>checked<?php
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                        ?> />
                                <label class="form-check-label fw-bold text-info" for="toggel<?php echo $selected_data["id"] ?>">
                                    <?php

                                    if ($selected_data["status_status_id"] == 2) {
                                    ?>Make Your Product Deactive<?php
                                                            } else {
                                                                ?>Make Your Product Active<?php
                                                                                        }

                                                                                            ?>
                                </label>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="row g-1">
                                        <div class="col-12 d-grid">
                                            <button class="btn btn-success fw-bold">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- card -->
        <?php
        }

        ?>
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
                    onclick="sort1(<?php echo ($pageno - 1); ?>)"
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
                        <a class="page-link" onclick="sort1(<?php echo ($x); ?>)">
                            <?php echo $x; ?>
                        </a>
                    </li <?php
                        } else {
                            ?> <li class="page-item">
                    <a class="page-link" onclick="sort1(<?php echo ($x); ?>)">
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
                    onclick="sort1(<?php echo ($pageno + 1); ?>)"
                    <?php
                    }
                    ?> aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>