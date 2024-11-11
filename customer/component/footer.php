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
        <button type="button" id="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg text-sm transition-colors">Cancel</button>
        <button type="submit" id="btnSaveAddress" class="ml-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-6 rounded-lg text-sm transition-colors">Save</button>
      </div>
    </form>
  </div>
</div>




<script src="js/app.js"></script>
<script src="js/searchAddressApiForAdd.js"></script>

</body>
</html>