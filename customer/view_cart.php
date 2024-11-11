<?php
include "component/header.php";
include('backend/class.php');

$db = new global_class();
?>

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <h1 class="text-3xl font-extrabold mb-8 text-gray-900">My Cart (<span class="cartCount">2</span>)</h1>

    <!-- Main Content -->
    <div class="flex flex-col gap-8 lg:flex-row">

        <!-- Left Section: Product List -->
        <div class="w-full lg:w-2/3 space-y-8">
            <!-- Delivery Address -->
            <div class="p-6 border border-gray-300 rounded-xl bg-white shadow-lg hover:shadow-2xl transition-shadow duration-300">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <span class="material-icons text-red-500 mr-2">location_on</span> Delivery Address
                </h2>
                <?php $fetch_address = $db->getUserActiveAddress(); ?>
                <div class="mt-4">
                    <label for="addressSelect" class="block text-sm text-gray-600">Current Address</label>
                    <select id="addressSelect" class="mt-2 w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" disabled selected>Select an address</option>
                        <?php foreach ($fetch_address as $address): ?>
                            <option data-address_id="<?= $address['ad_id']; ?>" <?php if($address['ad_status'] == '1'){ echo "selected"; } ?> value="<?= $address['ad_complete_address']; ?>">
                                <?= $address['ad_complete_address']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button id="setAddressModal" class="mt-4 w-full bg-blue-500 text-white py-2 rounded-lg font-semibold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Address</button>
            </div>

            <!-- Product List -->
            <div class="p-6 bg-white rounded-xl shadow-lg space-y-6">
                <?php 
                $userId = $_SESSION['user_id'];
                $getCartlist = $db->getCartlist($userId);

                $subTotal = 0;
                $totalSavings = 0;
                ?>
                <?php include "backend/end-points/cart_list.php"; ?>
            </div>
        </div>

        <!-- Right Section: Order Summary -->
        <div class="w-full lg:w-1/3 space-y-8">
            <!-- Order Summary -->
            <div class="w-full bg-white rounded-lg shadow-xl p-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Order Summary</h3>
                <div class="flex justify-between text-sm text-gray-700 mb-2">
                    <p>Sub-total (<span id="total-items"><?= count($getCartlist) ?></span> items)</p>
                    <p>Php <span id="sub-total"><?= number_format($subTotal, 2) ?></span></p>
                </div>
                <div class="flex justify-between text-sm text-green-600 mb-2">
                    <p>Total Saving</p>
                    <p>- Php <span id="total-savings"><?= number_format($totalSavings, 2) ?></span></p>
                </div>
                <div class="border-t border-gray-200 mt-6 pt-4">
                    <div class="flex justify-between text-sm text-gray-700">
                        <p>Vat (12%)</p>
                        <p>Php <span id="vat"><?= number_format($subTotal * 0.12, 2) ?></span></p>
                    </div>
                </div>
                <div class="grandTotal border-t border-gray-200 mt-6 pt-4 flex justify-between text-lg font-bold text-gray-900">
                    <p>Total</p>
                    <p>Php <span id="total"><?= number_format($subTotal + ($subTotal * 0.12) - $totalSavings, 2) ?></span></p>
                </div>
                <button class="btnCheckOut w-full bg-red-500 text-white py-3 rounded-lg font-semibold hover:bg-red-600 mt-6 focus:outline-none focus:ring-2 focus:ring-red-500">Checkout</button>
            </div>
        </div>

    </div>
</div>

<?php include "component/footer.php"; ?>

<script src="js/cart.js"></script>
<script src="js/setAddress.js"></script>
