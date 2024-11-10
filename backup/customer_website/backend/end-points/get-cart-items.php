<?php
session_start();
include('../class.php');
$db = new global_class();
if (isset($_SESSION['acc_id'])) {
    if (isset($_GET['requestType'])) {
        if ($_GET['requestType'] == 'getAllCartItems') {
            $getCartItems = $db->getCartItems($_SESSION['acc_id']);

           
            
            $total = 0;
            if ($getCartItems->num_rows > 0) {
                while ($cartItem = $getCartItems->fetch_assoc()) {
                    $checkProductQty = $db->checkProductQty($cartItem['prod_id']);
                    $checkQtyResult = $checkProductQty->fetch_assoc();
                    $currentStock = $checkQtyResult['total_stock'];

                    $itemAmount = $cartItem['qty'] * $cartItem['prod_currprice'];
                    $total += $itemAmount;

                    $productName = $cartItem['prod_name'];
                    $productName .= ($cartItem['prod_mg'] > 0) ? ' ' . $cartItem['prod_mg'] . 'mg' : '';
                    $productName .= ($cartItem['prod_g'] > 0) ? ' ' . $cartItem['prod_g'] . 'g' : '';
                    $productName .= ($cartItem['prod_ml'] > 0) ? ' ' . $cartItem['prod_ml'] . 'ml' : '';

                    // Caculate Vat
                    $getMaintenance = $db->getMaintenance();
                    $maintenance = $getMaintenance->fetch_assoc();
                    $taxRate = $maintenance['system_tax'];
                    $vatPerItem = $itemAmount * $taxRate;

                    // Get Shipping Fee
                    $getUserAddressInfo = $db->getUserShippingFee($_SESSION['acc_id']);
                    if ($getUserAddressInfo->num_rows > 0) {
                        $addressInfo = $getUserAddressInfo->fetch_assoc();
                        $shippingFee = $addressInfo['sf'];
                    } else {
                        $shippingFee = 'Invalid';
                    }
                    
                    if($shippingFee == ''){
                        $shippingFee = 'Invalid';
                    }
?>
<!-- Lightbox2 CSS -->
<link href="
https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css
" rel="stylesheet">

<!-- Lightbox2 JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox.min.js"></script>



 <div class="container mt-3 mb-3">
    <div class="row">
        

        <!-- Image Banner -->
        <div class="col-md-3 mb-3">
            <img id="main-image" src="../upload_prodImg/<?= $cartItem['prod_image'] ?>" class="img-fluid rounded-3" alt="Product Image">
            
            <!-- Image Gallery -->
          <div class="mt-3 overflow-auto">
        <div class="d-flex">

        <?php 
$getCartItemsPhotos = $db->getCartItemsPhotos($_SESSION['acc_id'],$cartItem['prod_id']);

if ($getCartItemsPhotos->num_rows > 0){ 
    while ($CartItemsPhotos = $getCartItemsPhotos->fetch_assoc()) { ?>
    <div class="p-2">
        <a href="../product_photos/<?= htmlspecialchars($CartItemsPhotos['PROD_PHOTOS']) ?>" data-lightbox="cart-images" data-title="<?=$CartItemsPhotos['prod_name']?>">
            <img src="../product_photos/<?= htmlspecialchars($CartItemsPhotos['PROD_PHOTOS']) ?>" 
                 class="img-fluid img-thumbnail thumbnail fixed-size-img" 
                 alt="Product Image">
        </a>
    </div>
    <?php } 
} ?>


        
        </div>
    </div>

     </div>

        
        

        <!-- Item Details -->
        <div class="col-md-9">
            <div class="item-details border p-3 rounded-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="form-check-input me-2 cartSelect" data-id="<?= $cartItem['prod_id'] ?>" data-image="<?= $cartItem['prod_image'] ?>" data-name="<?= $productName ?>" data-price="<?= $cartItem['prod_currprice'] ?>" data-unittype="<?= $cartItem['unit_type'] ?>" data-amount="<?= $itemAmount ?>" data-stock="<?= $currentStock ?>" data-inputqty="<?= $cartItem['qty'] ?>" data-itemvat="<?= $vatPerItem ?>" style="width: 30px; height: 30px;">
                        
                        <h4 class="fw-bold me-2"><?= $productName ?></h4>
                    </div>
                    
                    <button class="btn btn-danger btn-sm d-flex align-items-center btnDeleteCartItem" data-id="<?= $cartItem['cart_id'] ?>">
                        <i class="bi bi-trash3-fill"></i>
                    </button>
                </div>

                <div class="mb-3">
                    <label for="product-description" class="form-label">Description</label>
                    <textarea id="product-description" class="form-control" style="height: 150px" readonly><?= $cartItem['prod_description'] ?></textarea>
                </div>
                <p class="text-success mb-1 h5">₱ <?= $cartItem['prod_currprice'] ?></p>
                <p class="mt-0 <?= ($currentStock > 0) ? '' : 'text-danger' ?> mb-2">
                    <?= ($currentStock > 0) ? $currentStock . ' ' . $cartItem['unit_type'] . ' Available' : 'Out of Stock' ?>
                </p>
                <hr>
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-outline-secondary btn-sm me-2 minusCartQty" data-id="<?= $cartItem['cart_id'] ?>"><i class="bi bi-dash"></i></button>
                    <input type="number" class="form-control text-center mx-2 inputChangeCartItemQty" data-id="<?= $cartItem['cart_id'] ?>" value="<?= $cartItem['qty'] ?>" style="max-width: 70px;">
                    <button class="btn btn-outline-secondary btn-sm ms-2 addCartQty" data-id="<?= $cartItem['cart_id'] ?>"><i class="bi bi-plus"></i></button>
                </div>
                <hr>
                <p class="mb-2">Amount: <span class="text-success fw-bold">₱ <?= number_format($itemAmount, 2) ?></span></p>
                
            </div>
        </div>
    </div>
    <hr>
</div>


                <?php
                }
            } else {
                ?>
                <center class=" p-5 m-5 text-danger">
                    <h5>
                        Cart is Empty
                    </h5>
                </center>
            <?php
            }
            ?>
            <div class="cart-computation-container p-3">
                <p>Total: <span class="text-success">₱ <span id="totalSelectedItems">0</span></span></p>
                <button class="btn text-light" id="btnCheckOut" style="background-color: crimson;" data-sf="<?= $shippingFee ?>"><i class="bi bi-bag-check-fill"></i> Check Out</button>
            </div>
<?php
        }
    }
}



