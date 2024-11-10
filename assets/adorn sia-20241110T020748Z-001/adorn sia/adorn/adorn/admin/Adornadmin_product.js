function openModal() {
    document.getElementById('add_product_modal').style.display = 'block';
    console.log('Modal opened');
}

function closeModal() {
    document.getElementById('add_product_modal').style.display = 'none';
    console.log('Modal closed');
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    var modal = document.getElementById('add_product_modal');
    if (event.target === modal) {
        closeModal();
    }
};

function toggleCategoryForm() {
    const form = document.getElementById("categoryForm");
    form.style.display = form.style.display === "none" ? "block" : "none";
}

function openModal() {
    document.getElementById('edit_product_modal').style.display = 'block';
    console.log('Modal opened');
}

function closeModal() {
    document.getElementById('edit_product_modal').style.display = 'none';
    console.log('Modal closed');
}

// Close modal when clicking outside of it
window.onclick = function(event) {
    var modal = document.getElementById('edit_product_modal');
    if (event.target === modal) {
        closeModal();
    }
};

const body = document.querySelector('body'),
    sidebar = body.querySelector('nav'),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch"),
    modeText = body.querySelector(".mode-text");


toggle.addEventListener("click", () => {
    sidebar.classList.toggle("close");

    const button = document.getElementById('delete-btn')
    button.addEventListener("click",)
})

function openEditModal(productId, productImage, productName, productCategory, productPrice) {
    document.getElementById('edit_product_id').value = productId;
    document.getElementById('edit_product_image').value = ''; // Reset file input
    document.getElementById('edit_product_name').value = productName;
    document.getElementById('edit_product_category_name').value = productCategory;
    document.getElementById('edit_product_price').value = productPrice;

    document.getElementById('edit_product_modal').style.display = 'block';
}

// Function to close the modal
function closeEditModal() {
    document.getElementById('edit_product_modal').style.display = 'none';
}

//DELETE BUTTON

function editProduct(productId) {
    // Open a modal or update the form fields
    // You'll need to add the modal HTML and update the form fields here
  }
  
  function confirmDelete(productId) {
    if (confirm('Are you sure you want to delete this product?')) {
      // Make a DELETE request to the server
      fetch(`inventory.php?delete_product_id=${productId}`, {
        method: 'DELETE',
      })
        .then((response) => {
          if (response.ok) {
            // Refresh the page or update the product list
            window.location.reload();
          } else {
            console.error('Error deleting product');
          }
        })
        .catch((error) => console.error('Error deleting product:', error));
    }
  }


