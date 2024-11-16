$(document).ready(function() {
    // Initialize functions when document is ready
   
    fetchOrders();
    AutoRefresh();
    bindTableFilter()
});

function AutoRefresh() {
    setInterval(function() {
        fetchOrders();
    }, 2000);
}



// Table filtering functionality
function bindTableFilter() {
    $('#searchInput').on('input', function() {
        const input = $(this).val().toLowerCase();
        const rows = $("#recordTable tbody tr");
        
        rows.each(function() {
            let rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.includes(input));
        });
    });
}



function fetchOrders() {
    $.ajax({
        type: "GET",
        url: 'backend/end-points/controller.php',
        data: { requestType: 'GetAllOrders' },
        dataType: 'json',
        success: function(response) {
            // console.log(response);
            if (response.status === 'success') {
                console.log(response.data);
                displayOrders(response.data);
            } else {
                console.log(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.log('AJAX error: ' + error);
        }
    });
}


function displayOrders(orders) {
    // Get the step from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const currentStep = urlParams.get('step') || 'Pending'; // Default to 'Pending' if no step is provided

    let tableBody = $('#recordTable tbody');
    tableBody.empty();

    // Filter orders based on the current step
    const filteredOrders = orders.filter(function(orderItem) {
        return orderItem.order_status === currentStep;
    });

    // Display the filtered orders
    filteredOrders.forEach(function(orderItem) { 
        var orderDate = new Date(orderItem.order_date);
        var formattedDate = orderDate.toLocaleString('en-US', { 
            month: 'long', 
            day: 'numeric', 
            year: 'numeric', 
            hour: 'numeric', 
            minute: 'numeric', 
            hour12: true 
        });

        let orderRow = `
            <tr class="border-t">
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.order_code}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.Fullname}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.order_date}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${formattedDate}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.subtotal}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.vat}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.total}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.delivery_address}</td>
                <td class="px-4 py-2 text-sm text-gray-600">${orderItem.order_status}</td>
                <td class="px-4 py-2 text-sm text-gray-600">
                    <button class="bg-green-600 hover:bg-gray-300 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-400">
                        Update
                    </button>
                </td>
            </tr>
        `;
        tableBody.append(orderRow);
    });
}


