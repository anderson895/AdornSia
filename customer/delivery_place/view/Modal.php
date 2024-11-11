

<!-- Start Modal for edit -->
<div class="modal fade" id="editShipping" tabindex="-1" aria-labelledby="editShippingLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background-color: rgb(96, 0, 0);">
                <input type="hidden" value="<?= $db_acc_id ?>" id="acc_id">
                <h5 class="modal-title" id="editShippingLabel" style="color:#fafbfe;">Update Shipping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <h4 id="AddressName"></h4>
                </div>
                <hr>
                <h6>Shipping</h6>
                <div class="form-group mb-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter shipping details" id="shipping">
                        <input type="hidden" id="address_id">
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label for="riderSelect">Assign Rider</label>
                    <select id="riderSelect" class="form-control">
                        <option disabled selected value="">Select a rider</option>
                        <?php
                        $view_query = mysqli_query($connections, "SELECT * from account where acc_status='0' and acc_display_status='0' and (acc_type='deliveryStaff' OR acc_type='administrator')");
                        while ($row = mysqli_fetch_assoc($view_query)) {
                            $acc_id = $row["acc_id"];
                            $acc_fullname = $row["acc_fname"] . " " . $row["acc_lname"];
                            $acc_code = $row["acc_code"];
                        ?>
                            <option value='<?= $acc_id ?>'><?= $acc_fullname ?> (<?= $acc_code ?>)</option>
                        <?php } ?>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="savePlace" class="btn btn-submit">Save</button>
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal for edit -->






<!---Start Modal for addDelivery Address---->
<div class="modal fade" id="addDeliveryAddress" tabindex="-1" aria-labelledby="editShipping" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" style="background-color: rgb(96, 0, 0);">
        <input hidden type="text" value="<?=$db_acc_id?>" id='acc_id'>
        <h5 class="modal-title" style="color:#fafbfe;">Add new address</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <h4 class="text-center" id="AddressName"></h4>
        </div>

        
        <div class="form-group m-0 bg-light rounded">
                        <textarea style="display:none;" disabled id="complete_address_add" cols="30" rows="10"></textarea>
                        <div class="search-container">
                        <label for="riderSelect">Search Barangay</label>
                            <input required type="text" class="form-control" id="searchBarangay_add" placeholder="Search brgy.." name="searchBarangay_add">
                        </div>
                        <div id="barangaySuggestions_add" class="suggestions-row ml-4"></div>
                        <input hidden type="text" id="region_add">
                        <input hidden type="text" id="province_add">
                        <input hidden type="text" id="city_add">
                        <input hidden type="text" id="brgy_add" value="">
                     
        </div>

        

        <div class="row mt-4">
          <div class="form-group">
            <label for="Addshipping">Shipping fee</label>
            <input type="number" class="form-control " value="" id="Addshipping" placeholder="Enter shipping price">
          </div>
        </div>

        <div class="row">
          <div class="form-group">
            <label for="riderSelect">Assign Rider</label>
            <select id="riderSelect" class="form-control riderSelect">
              <option disabled value="">Select a rider</option>
              <?php
                    $view_query = mysqli_query($connections, "SELECT * from account where acc_status='0' and acc_display_status='0' and (acc_type='deliveryStaff' OR acc_type='administrator') ");

                    while ($row = mysqli_fetch_assoc($view_query)) {
                      $acc_id = $row["acc_id"];
                      $acc_fullname = $row["acc_fname"]." ".$row["acc_lname"];
                      $acc_code = $row["acc_code"];
                    ?>
                      <option value='<?= $acc_id ?>'><?= $acc_fullname ?> (<?=$acc_code?>) </option>
                    <?php } ?>
              <!-- Add more options as needed -->
            </select>
          </div>
        </div>


        <div class="row">
          <div class="form-group">
              <label for="">Active Status</label>
              <input type="checkbox" id="activeStatus" class="check" checked="">
              <label for="activeStatus" class="checktoggle"></label>
          </div>
        </div>
       

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-submit savePlaceTogler">Save</button>
        <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!---End Modal for edit---->



