<?php
include('components/header.php');

?>
<h2><i class="bi bi-shop"></i> All Products</h2>
<div class="">
    <?php
    $getBestSellers = $db->getBestSellers();
    if ($getBestSellers->num_rows > 0) {
    ?>
        <div class="">
            <center class="mt-5">
                <h5 class="text-success">Best Sellers</h5>
            </center>
            <div class="container best-sellers-container d-flex justify-content-center">
                <?php
                while ($bestProduct = $getBestSellers->fetch_assoc()) {
                    $outOfStock = true;
                    $productQty = 0;
                    $checkProductQty = $db->checkProductQty($bestProduct['prod_id']);
                    if ($checkProductQty->num_rows > 0) {
                        $productQty = $checkProductQty->fetch_assoc();
                        if ($productQty['total_stock'] > 0) {
                            $productQty = $productQty['total_stock'];
                            $outOfStock = false;
                        } else {
                            $outOfStock = true;
                        }
                    }


                    if (isset($bestProduct['prod_id'])) {
                        $prod_id = $bestProduct['prod_id'];
                        $response = $db->getAverageRating($prod_id);
                        // echo json_encode($response);
                    } else {
                        echo json_encode(["error" => "Product ID is missing"]);
                    }
                    


                ?>
                    <button class="m-2 p-0 product-container btnViewProduct" data-id="<?= $bestProduct['prod_id'] ?>" data-name="<?= $bestProduct['prod_name'] ?>" data-mg="<?= $bestProduct['prod_mg'] ?>" data-g="<?= $bestProduct['prod_g'] ?>" data-ml="<?= $bestProduct['prod_ml'] ?>" data-unitType="<?= $bestProduct['unit_type'] ?>" data-category="<?= $bestProduct['prod_category_id'] ?>" data-description="<?= $bestProduct['prod_description'] ?>" data-image="<?= $bestProduct['prod_image'] ?>" data-price="<?= $bestProduct['prod_currprice'] ?>" data-stock="<?= $productQty ?>">
                        <?= ($outOfStock) ? '<span class="txt-out-of-stock text-danger">Out of stock.</span>' : '' ?>
                        <img class="product-image" src="../upload_prodImg/<?= $bestProduct['prod_image'] ?>">
                        <div class="p-1 product-contents-container">

                        <?php
                        $avgRating = $response['avg_rating']; // Assuming avg_rating is already fetched

                        echo '<div class="ratings">';
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($avgRating)) {
                                echo '<span id="star' . $i . '" class="text-warning">★</span>';
                            } else {
                                echo '<span id="star' . $i . '" class="text-muted">☆</span>';
                            }
                        }
                        echo '<span id="avg-rating">(' . $avgRating . ')</span>';
                        echo '</div>';
                        ?>

                            <p class="product-name">
                                <?= $bestProduct['prod_name'] ?>
                            </p>
                            <span class="product-price text-success">PHP <?= $bestProduct['prod_currprice'] ?></span>
                        </div>
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    }

    $getNewProducts = $db->getNewProducts();
    if ($getNewProducts->num_rows > 0) {
    ?>
        <div class="">
            <center class="">
                <h5 class="text-success">New Products</h5>
            </center>

            <div class="container best-sellers-container d-flex justify-content-center">
                <?php
                while ($newProduct = $getNewProducts->fetch_assoc()) {
                    $outOfStock = true;
                    $productQty = 0;
                    $checkProductQty = $db->checkProductQty($newProduct['prod_id']);
                    if ($checkProductQty->num_rows > 0) {
                        $productQty = $checkProductQty->fetch_assoc();
                        if ($productQty['total_stock'] > 0) {
                            $productQty = $productQty['total_stock'];
                            $outOfStock = false;
                        } else {
                            $outOfStock = true;
                        }
                    }


                    if (isset($newProduct['prod_id'])) {
                        $prod_id = $newProduct['prod_id'];
                        $response = $db->getAverageRating($prod_id);
                        // echo json_encode($response);
                    } else {
                        echo json_encode(["error" => "Product ID is missing"]);
                    }
                ?>
                    <button class="m-2 p-0 product-container btnViewProduct" id="btnViewProduct" data-id="<?= $newProduct['prod_id'] ?>" data-name="<?= $newProduct['prod_name'] ?>" data-mg="<?= $newProduct['prod_mg'] ?>" data-g="<?= $newProduct['prod_g'] ?>" data-ml="<?= $newProduct['prod_ml'] ?>" data-unitType="<?= $newProduct['unit_type'] ?>" data-category="<?= $newProduct['prod_category_id'] ?>" data-description="<?= $newProduct['prod_description'] ?>" data-image="<?= $newProduct['prod_image'] ?>" data-price="<?= $newProduct['prod_currprice'] ?>" data-stock="<?= $productQty ?>">
                        <?= ($outOfStock) ? '<span class="txt-out-of-stock text-danger">Out of stock.</span>' : '' ?>
                        <img class="product-image" src="../upload_prodImg/<?= $newProduct['prod_image'] ?>">
                        <div class="p-1 product-contents-container">

                        <?php
                        $avgRating = $response['avg_rating']; // Assuming avg_rating is already fetched
                        echo '<div class="ratings">';
                        for ($i = 1; $i <= 5; $i++) {
                            if ($i <= floor($avgRating)) {
                                echo '<span id="star' . $i . '" class="text-warning">★</span>';
                            } else {
                                echo '<span id="star' . $i . '" class="text-muted">☆</span>';
                            }
                        }
                        echo '<span id="avg-rating">(' . $avgRating . ')</span>';
                        echo '</div>';
                        ?>

                            <p class="product-name">
                                <?= $newProduct['prod_name'] ?>
                            </p>
                            <span class="product-price text-success">PHP <?= $newProduct['prod_currprice'] ?></span>
                        </div>
                    </button>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
    }
    ?>
</div>


<hr>
<?php
// $getProducts = $db->getAllProducts();
?>
<div class="container all-products-container">
    <div class="search-product-container d-flex justify-content-end pt-3 pb-3">
        <div class="input-container-label-top m-3 mt-0 mb-0">
            <label>Category</label>
            <select class="form-control select-product-category" id="productCategory">
                <option value="All">All</option>
                <?php
                $getCategories = $db->getCategories();
                while ($category = $getCategories->fetch_assoc()) {
                ?>
                    <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
        <div class="searchbar-container">
            <input type="search" class="form-control" placeholder="Search..." id="searchProduct">
            <button type="button" class="search-product-button btn btn-primary" id="btnSearchProduct">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-center mt-3" id="allProductsContainer">

    </div>
</div>
<?php
include('components/footer.php');
?>
<script>
    $('.nav-all-products').addClass('nav-active');


   


</script>


