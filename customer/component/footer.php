<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


<!-- Modal -->
<div style="display:none;" id="addressModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center">
  <div class="bg-white rounded-lg shadow-lg p-6 w-full sm:w-96 max-w-sm">
    <h2 class="text-xl font-semibold text-center mb-6">Add Address</h2>
    <div class="mb-4">
      <h4 class="text-center text-gray-600" id="AddressName"></h4>
    </div>

    <div class="loadingSpinner" style="display:none;">
        <div class=" absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
          <div class="w-10 h-10 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
        </div>
     </div>

    <label for="searchBarangay_add" class="block text-sm text-gray-700 mb-2">Search Barangay..</label>
    <input id="searchBarangay_add" type="text" class="w-full p-3 border border-gray-300 rounded-lg mb-4 text-sm" placeholder="Enter Barangay name">
    
    <form>
      <div id="barangaySuggestions_add" class="suggestions-row ml-4"></div>
      <textarea style="display:none;" disabled id="complete_address_add" class="w-full p-1 border border-gray-300 rounded-lg mb-4 h-20" cols="30" rows="2"></textarea>
    
      <label for="StreetName" class="block text-sm text-gray-700 mb-2">Street Name</label>
      <input type="text" name="StreetName" id="StreetName" class="w-full p-3 border border-gray-300 rounded-lg mb-4 text-sm" placeholder="Enter street name">
      
      <input hidden type="text" value="" id="complete_Address_code">

      <div class="flex justify-end space-x-4 mt-4">
        <button type="button" class="closeModal bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg text-sm transition-colors">Cancel</button>
        <button type="submit" id="btnSaveAddress" class="ml-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg text-sm transition-colors">Save</button>
      </div>
    </form>
  </div>
</div>







<!-- Modal Structure -->
<div id="checkoutModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50" style="display:none;">
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-md w-full">
    <h2 class="text-xl font-semibold mb-4">Confirm Checkout</h2>
    <p class="mb-6">Are you sure you want to proceed with checkout?</p>

    <!-- Payment Method Section -->
    <div class="mb-6">
    <label for="paymentMethod" class="block text-sm font-medium text-gray-700">Select Payment Method</label>
    <select id="paymentMethod" name="paymentMethod" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        <option value="cod" data-ename="cod">Cash on Delivery</option>
        <?php 
            $getAllEwallet = $db->getAllEwallet(); 
            foreach ($getAllEwallet as $mop):
                echo '<option value="'.$mop['e_id'].'" data-img="'.$mop['e_img'].'" data-ename="'.$mop['e_wallet_name'].'">';
                echo $mop['e_wallet_name'];
                echo '</option>';
            endforeach; 
        ?>
    </select>
</div>


    <!-- Payment Method Instructions -->
    <div id="paymentDetails" class="hidden">
    <!-- QR Code Image (for Gcash and Bank Transfer) -->
    <div id="qrCode" class="mb-4 hidden">
        <label class="block text-sm font-medium text-gray-700">Scan QR Code for Payment</label>
        <img src="" alt="QR Code" class="w-40 h-40 mt-2 mx-auto" />
    </div>

    <!-- Proof of Payment Upload Section -->
    <div id="proofOfPaymentSection" class="mt-4">
        <label for="proofOfPayment" class="block text-sm font-medium text-gray-700">Upload Proof of Payment</label>
        <input type="file" id="proofOfPayment" name="proofOfPayment" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm" accept="image/*" />

    </div>
    </div>

    <!-- Modal Footer -->
    <div class="flex justify-end mt-6">
      <button class="closeModal mr-4 px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Cancel</button>
      <button id="btnConfirmCheckout" class=" px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Confirm</button>
    </div>
  </div>
</div>



<script src="js/app.js"></script>
<script src="js/searchAddressApiForAdd.js"></script>

</body>
</html>