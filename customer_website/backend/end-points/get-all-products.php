<?php
session_start();
include('../class.php');
$db = new global_class();







if (isset($_SESSION['acc_id'])) {
    if (isset($_GET['requestType'])) {
        if ($_GET['requestType'] == 'getAllProducts') {



            $getProducts = $db->getAllProducts($_GET['search'], $_GET['category']);

            if ($getProducts->num_rows > 0) {
                while ($product = $getProducts->fetch_assoc()) {
                    $outOfStock = true;
                    $productQty = 0;
                    $checkProductQty = $db->checkProductQty($product['prod_id']);
                    if ($checkProductQty->num_rows > 0) {
                        $productQty = $checkProductQty->fetch_assoc();
                        if ($productQty['total_stock'] > 0) {
                            $productQty = $productQty['total_stock'];
                            $outOfStock = false;
                        } else {
                            $outOfStock = true;
                        }
                    }


                    if (isset($product['prod_id'])) {
                        $prod_id = $product['prod_id'];
                        $response = $db->getAverageRating($prod_id);
                        // echo json_encode($response);


                     
                        

                        

                    } else {
                        echo json_encode(["error" => "Product ID is missing"]);
                    }
                    

?>


                   <button class="m-2 p-0 product-container btnViewProduct" 
                    data-id="<?= $product['prod_id'] ?>" 
                    data-name="<?= $product['prod_name'] ?>" 
                    data-mg="<?= $product['prod_mg'] ?>" 
                    data-g="<?= $product['prod_g'] ?>" 
                    data-ml="<?= $product['prod_ml'] ?>" 
                    data-unitType="<?= $product['unit_type'] ?>" 
                    data-category="<?= $product['prod_category_id'] ?>" 
                    data-description="<?= $product['prod_description'] ?>" 
                    data-image="<?= $product['prod_image'] ?>" 
                    data-price="<?= $product['prod_currprice'] ?>" 
                    data-stock="<?= $productQty ?>">
                    <?= ($outOfStock) ? '<span class="txt-out-of-stock text-danger">Out of stock.</span>' : '' ?>
                    <img class="product-image" src="../upload_prodImg/<?= $product['prod_image'] ?>">
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


                        <p class="product-name"><?= $product['prod_name'] ?></p>

                        

                        <span class="product-price text-success">PHP <?= $product['prod_currprice'] ?></span>
                    </div>
                </button>









                
                <?php
                }
            } else {
                ?>
                <center class="pt-5 pb-5 mt-5 mb-5">No Product Found.</center>

                
<?php
            }
        }
    }
}
