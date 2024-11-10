</div>
</main>


<style>
 .product-image {
      max-height: 300px; /* Adjust as needed */
      object-fit: contain;
    }

    .product-photos-container {
      max-height: 150px; /* Adjust based on how much space you want for the scrollable row */
      padding-bottom: 10px; /* Space for the bottom padding */
    }

    .product-photo-sm {
      width: 100px; /* Adjust the size of each thumbnail */
      height: auto;
      margin-right: 10px; /* Space between images */
      cursor: pointer;
    }

    .product-photo-sm:hover {
      opacity: 0.8; /* Slight hover effect */
    }
  
  
    .scrollable-div {
      max-height: 300px; /* Set the maximum height for the scrollable div */
      overflow-y: auto; /* Enable vertical scrollbar if needed */
      border: 1px solid #ddd; /* Add a border for styling */
      border-radius:10px;
      padding: 10px; /* Add padding for better appearance */
    }
  

    #loader {
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999; /* Make sure it's above other content */
}

.spinner {
    border: 4px solid rgba(0,0,0,0.1);
    border-left-color: #000;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

</style>


 <!-- View Product Modal -->
  <div class="modal fade" id="viewProductModal" tabindex="-1" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="rate_prod_id">
          <!-- Main Product Image -->
          <div class="text-center mb-3">
            <img src="" id="viewProductPicture" class="product-image img-fluid" alt="Product Image">
          </div>

           <!-- Scrollable Product Photos -->
           <div class="product-photos-container overflow-auto">
            <div id="productPhotos-modal-sm-img-container" class="d-flex flex-nowrap">
              <!-- Photos will be inserted here -->
            </div>
          </div>

          <!-- Product Description -->
          <div class="mb-3">
            <label for="viewProductDescription" class="form-label">Product Description</label>
            <textarea id="viewProductDescription" class="form-control" readonly></textarea>
          </div>




          <!-- Start reviews -->
            <div class="container mt-5 mb-4">
                <h4>Reviews</h4>
                <div class="scrollable-div">
                <div id="reviews-container" style="display:none; "></div>
            <script>
         $(document).on("click", ".btnViewProduct", function (e) {
                    e.preventDefault();
                    var rate_prod_id = $(this).data('id');

                    console.log('click');

                    $.ajax({
                        url: 'backend/end-points/fetch_reviews.php',
                        method: 'POST',
                        data: { rate_prod_id: rate_prod_id },
                        success: function (data) {
                            console.log(data);
                            displayReviews(data);
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching reviews:', status, error);
                        }
                    });
                });

                function displayReviews(reviews) {
                var reviewsContainer = $('#reviews-container');
                var scrollableDiv = $('.scrollable-div');

                // Check if reviews array is empty
                if (reviews.length === 0) {
                    reviewsContainer.empty(); // Clear any existing content
                    reviewsContainer.append('<p>No reviews available.</p>'); // Display no review message
                    reviewsContainer.show(); // Show the container with the message
                    scrollableDiv.css('border', 'none'); // Remove border from .scrollable-div
                    return;
                }

                // Clear existing content
                reviewsContainer.empty();

                // Append new reviews
                $.each(reviews, function (index, review) {
                    reviewsContainer.append(`
                        <div class="review">
                            <h4>${review.acc_username}</h4>
                            <p>Rate: ${generateStarButtons(review.r_rate)}</p>
                            <p>Comment: ${review.r_feedback}</p>
                        </div>
                    `);
                });

                    // Show container and set border
                    reviewsContainer.show();
                    scrollableDiv.css('border', '1px solid #ccc'); // Set border for .scrollable-div
            }




                function generateStarButtons(starCount) {
                    let buttons = '';
                    for (let i = 1; i <= 5; i++) {
                        const activeClass = i <= starCount ? 'text-warning' : 'text-secondary';
                        buttons += `<button style="width:20px;" type="button" class="btn ${activeClass} " data-id="${i}"><i class="bi bi-star"></i></button>`;
                    }
                    return buttons;
                
            };
            </script>
                <!-- Add more reviews as needed -->
                </div>
            </div>

  <!-- End reviews -->




          <!-- Available Stock -->
          <div id="viewProductStocks" class="text-center mb-2"></div>

          <!-- Product Price -->
          <div id="viewProductPrice" class="text-center mb-3" style="font-size: 1.25rem;"></div>

         
        </div>
        <div class="modal-footer">
          <button class="btn text-light" style="height: 40px; background-color: crimson;" id="btnViewProdAddToCart" data-prodid="">
            <i class="bi bi-cart-plus-fill"></i> Add To Cart
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- End of View Product Modal -->




<!-- Delete Cart Item Modal -->
<div class="modal" tabindex="-1" role="dialog" id="deleteCartItemModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCartItemTitle">Delete Item</h5>
                <button type="button" id="closeViewProductModal" class="btn-close btnCloseModal"
                    data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container p-2">
                <h6 class="container mt-3 mb-4" id="deleteCartItemQDisplay">
                    Are you sure you want to delete this product in your cart?
                </h6>
                <hr>
                <div class="d-flex justify-content-end align-items-end p-1">
                    <button class="btn text-light" style="height: 40px; background-color: crimson;"
                        id="btnDeleteCartItem" data-prodid=""><i class="bi bi-trash3-fill"></i> Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Delete Cart Item Modal -->





<!-- Check Out Modal -->
<div class="modal PlaceOrderModal" tabindex="-1" role="dialog" id="PlaceOrderModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="PlaceOrderModalTitle"><i class="bi bi-bag-check-fill"></i> Check Out</h5>
                <button type="button" id="closeViewProductModal" class="btn-close btnCloseModal"
                    data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container p-2">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody id="placeOrderItemsContainer">

                    </tbody>
                </table>




                <div class="select-payment-type-container payment_type_container">
                    <div class="input-container-label-top">
                        <label for="checkOutPaymentTypesSelect">Payment Type</label>
                        <select class="form-control" id="checkOutPaymentTypesSelect">

                        </select>
                    </div>
                    <div class="payment-image-container d-flex flex-column align-items-center mt-3">
                        <h5 id="paymentNumberContainer" class="m-3" style="color: crimson;"></h5>
                        <img src="" id="paymentImgContainer">
                        <div class="upload-payment-container">

                            <div class="container card p-2">
                                <span id="popTerms" class="text-danger" style="font-size: 12px">Please ensure that the
                                    proof of payment you submit is accurate and valid. Incorrect or falsified proof of
                                    payment may result in delays or rejection of your transaction.</span>
                                <div class="container d-flex">
                                    <input type="checkbox" class="form-check" id="pofTermsAgree">
                                    <label for="pofAgree" class="m-2 mt-0 mb-0">I Agree</label>
                                </div>
                            </div>
                            <h6 class="text-success mt-2">Please Upload Proof of Payment.</h6>
                            <input type="file" name="pof" id="paymentTypeImgInput" accept="image/*"
                                class="form-control ">
                            <img id="imagePreview" src="#" alt="Image Preview">
                        </div>
                    </div>
                </div>
    
                <div class="d-flex flex-column align-items-end p-1">

            <div class="container">
                <!-- Delivery Address Section -->
                <div class="checkout-computation-container mb-4 p-3 border rounded shadow-sm">
                    <h6 class="mb-3">Delivery Address</h6>
                    <p class="mb-3" ><?= $fullAddress ?></p>
                    <button class="btn btn-sm btn-secondary btnEditAddress">Update Address</button>
                </div>

                <!-- Checkout Computation Section -->
                <div class="checkout-computation-container mb-4 p-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>₱ <span id="checkOutSubtotal"></span></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>VAT (Included):</span>
                        <span>-</span>
                        <span hidden>₱ <span id="checkOutVat"></span></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Shipping:</span>
                        <span><span id="checkOutShipping"></span></span>
                    </div>
                    <div class="d-flex justify-content-between fw-bold mt-2">
                        <span>Total:</span>
                        <span>₱ <span id="checkOutTotal"></span></span>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center" >
                    <div class="spinner-border spinner" role="status" style="display:none;">
                        <span class="sr-only"></span>
                    </div>
                </div>

              
                <!-- Place Order Button -->
                <button class="btn btn-danger text-light w-100 mt-2" style="height: 40px;" id="btnPlaceOrder" data-prodid="">
                    <i class="bi bi-bag-check-fill"></i> Place Order
                </button>
                

            </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Check Out Modal -->

<!-- Edit Profile Modal -->
<div class="modal" tabindex="-1" role="dialog" id="editProfileModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">Edit Profile</h5>
                <button type="button" id="closeEditProductModal" class="btn-close btnCloseModal"
                    data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container p-2">
                <form id="frmEditProfile">
                    <div class="container p-3">
                        <input type="hidden" name="requestType" value="EditUser">
                        <div class="input-container-label-top mt-3">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="editFName" id="editFName">
                        </div>
                        <div class="input-container-label-top mt-3">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="editLName" id="editLName">
                        </div>
                        <div class="input-container-label-top mt-3">
                            <label>Birthday</label>
                            <input type="date" class="form-control" name="editBday" id="editBday">
                        </div>
                        <div class="input-container-label-top mt-3">
                            <label>Username</label>
                            <input type="text" class="form-control" name="editUsername" id="editUsername">
                        </div>
                        <div class="input-container-label-top mt-3">
                            <label>Email</label>
                            <input type="text" class="form-control" name="editEmail" id="editEmail">
                        </div>
                        <div class="input-container-label-top mt-3">
                            <label>Contact #</label>
                            <input type="number" class="form-control" name="editContact" id="editContact">
                        </div>
                        <div class="mt-3">
                            <button type="reset" class="btnCloseModal btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Edit Profile Modal -->


<!-- View Edit Address Modal -->
<div class="modal editAddressModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Address</h5>
                <button type="button" id="closeEditAddressModal" class="btn-close btnCloseModal"
                    data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="container p-2" id="frmEditAddress">
                <input type="hidden" id="editAddressAccCode" value="<?= $accCode ?>">
                <input type="hidden" id="userFullName" value="<?= $customerFullname ?>">
                <input type="hidden" id="userEmail" value="<?= $customerEmail ?>">
                <input type="hidden" id="userPhone" value="<?= $customerPhone ?>">

                <div class="input-container-label-top mt-3">
                    <label>Region</label>
                    <select class="form-control" id="regionDropDown" required>
                    </select>
                </div>
                <div class="input-container-label-top mt-3">
                    <label>Province</label>
                    <select class="form-control" id="provinceDropDown" required>
                    </select>
                </div>
                <div class="input-container-label-top mt-3">
                    <label>Municipality</label>
                    <select class="form-control" id="cityDropDown" required>
                    </select>
                </div>
                <div class="input-container-label-top mt-3">
                    <label>Barangay</label>
                    <select class="form-control" id="barangayDropDown" required>
                    </select>
                </div>
                <div class="input-container-label-top mt-3">
                    <label>Street</label>
                    <input type="text" class="form-control" id="streetName" required>
                </div>
                <div class="mt-3">
                    <button type="reset" class="btnCloseModal btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Edit Address Modal -->



<!-- View Edit Profile Img Modal -->
<div class="modal" tabindex="-1" role="dialog" id="editProfileImgModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile Images</h5>
                <button type="button" id="closeEditProfileImgModal" class="btn-close btnCloseModal"
                    data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="profileImgFRM">
                    <label for="profileAttachementImg">Attach Images</label>

                    <input type="file" class="form-control" id="profileAttachementImg" name="profileAttachementImg" accept=".png, .jpg, .jpeg, .webp">

                   

                    <button type="reset" class="mt-3 btnCloseModal btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="mt-3 btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>

                    <div id="loader" style="display: none;">
                        <div class="spinner"></div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Profile Img Modal -->


<!-- View Edit user Password Modal -->
<div class="modal" tabindex="-1" role="dialog" id="editPassModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Password</h5>
                <button type="button" id="closeEditProfileImgModal" class="btn-close btnCloseModal"
                    data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="userPasswordFRM">
                    <!-- Floating label for Current Password -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="currpass" id="currpass" placeholder="Enter Current Password">
                        <label for="currpass">Current Password</label>
                    </div>

                    <!-- Floating label for New Password -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="newpass" id="newpass" placeholder="Enter New Password">
                        <label for="newpass">New Password</label>
                    </div>

                    <!-- Floating label for Confirm New Password -->
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" name="confpass" id="confpass" placeholder="Confirm New Password">
                        <label for="confpass">Confirm New Password</label>
                    </div>

                    <button type="reset" class="mt-3 btnCloseModal btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="mt-3 btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>

                    <div id="loader" style="display: none;">
                        <div class="spinner"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of user Password Modal -->

<!-- Start user Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cancelModalLabel">Cancel Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        
        <select name="CancelReason" id="cancelReason" class="form-select">
          <option value="" disabled selected>Select a reason</option>
          <option value="Changed my mind">Changed my mind</option>
          <option value="Delivery is too slow">Delivery is too slow</option>
          <option value="Found a better price">Found a better price</option>
          <option value="other">Other</option>
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="btnCancelOrder"  class="btn btn-danger">Confirm</button>
      </div>
    </div>
  </div>
</div>
<!-- End user Modal -->






<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>



<script src="javascript/app.js"></script>
</body>

</html>