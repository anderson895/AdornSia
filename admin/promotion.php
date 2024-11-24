<?php 
include "components/header.php";
?>
<div class="flex justify-between items-center bg-white p-6 mb-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-semibold text-gray-800">Marketing Promotions</h2>
    <div class="flex items-center gap-4">
        <!-- Add Promo Button -->
        <button id="addPromoBtn" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md shadow-md">
            + Add Promo
        </button>
        <!-- Profile Icon -->
        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-xl font-bold text-white">
            <?php
            echo substr(ucfirst($_SESSION['admin_username']), 0, 1);
            ?>
        </div>
    </div>
</div>

<!-- Card for Table -->
<div class="bg-white rounded-lg shadow-lg p-8">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6">Promo List</h3>
    
    <div class="legend mb-4 text-sm text-gray-600">
        <ul>
            <li><span class="text-green-600 text-xl">&#8226;</span> Active Promotions</li>
            <li><span class="text-red-600 text-xl">&#8226;</span> Expired Promotions</li>
        </ul>
    </div>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="table-auto w-full text-sm text-left text-gray-600 dark:text-gray-300">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Promo</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Rate</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Expiration</th>
                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/promotional_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal for Adding Promo -->
<div id="addPromoModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New Promo</h3>
        <form id="addPromoForm">
            <div class="mb-4">
                <label for="promoName" class="block text-sm font-medium text-gray-700">Promo Name</label>
                <input type="text" id="promoName" name="promo_name" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="promoDescription" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea id="promoDescription" name="promo_description" class="w-full p-2 border rounded-md" required></textarea>
            </div>
            <div class="mb-4">
                <label for="promoRate" class="block text-sm font-medium text-gray-700">Rate (%)</label>
                <input type="text" id="promoRate" name="promo_rate" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="promoExpiration" class="block text-sm font-medium text-gray-700">Expiration Date</label>
                <input type="date" id="promoExpiration" name="promo_expiration" class="w-full p-2 border rounded-md" required>
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md">Add Promo</button>
            </div>
        </form>
    </div>
</div>



<!-- Modal -->
<div id="promoModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center" style="display:none;">
    <div class="bg-white p-6 rounded-lg w-96">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Update Promo</h2>
        
        <!-- Promo Update Form -->
        <form id="promoUpdateForm">

            <div class="mb-4">
                <label for="promo_id" class="block text-gray-700">Promo Id</label>
                <input type="text" id="promo_id" name="promo_id" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="promo_name" class="block text-gray-700">Promo Name</label>
                <input type="text" id="promo_name" name="promo_name" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="promo_description" class="block text-gray-700">Description</label>
                <input type="text" id="promo_description" name="promo_description" class="mt-1 p-2 w-full border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <label for="promo_rate" class="block text-gray-700">Promo Rate (%)</label>
                <input type="text" id="promo_rate" name="promo_rate" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="promo_expiration" class="block text-gray-700">Expiration Date</label>
                <input type="date" id="promo_expiration" name="promo_expiration" class="mt-1 p-2 w-full border border-gray-300 rounded-md" required>
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-between mt-4">
                <button type="button" class="closeModal bg-gray-500 text-white py-2 px-4 rounded-md">Close</button>
                <button type="submit" id="savePromo" class="bg-blue-500 text-white py-2 px-4 rounded-md">Save</button>
            </div>
        </form>
    </div>
</div>



<?php include "components/footer.php";?>
