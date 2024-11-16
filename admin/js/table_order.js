$(document).ready(function() {
    // Initialize functions when document is ready
   
    fetchOrders();
    AutoRefresh();
    bindTableFilter()
});

function AutoRefresh() {
    setInterval(function() {
        fetchOrders();
    }, 4000);
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
                <td class="px-4 py-2 text-sm text-gray-600">
                   <select 
                        class="UpdateOrderStatus w-full p-2 text-white bg-green-500 border border-blue-500 rounded-md shadow-sm appearance-none cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-300" 
                        data-orderId="${orderItem.order_id}" 
                        data-initial-status="${orderItem.order_status}">
                        <option value="Pending" ${orderItem.order_status == "Pending" ? "selected" : ""}>Pending</option>
                        <option value="Accept" ${orderItem.order_status == "Accept" ? "selected" : ""}>Accept</option>
                        <option value="Delivered" ${orderItem.order_status == "Delivered" ? "selected" : ""}>Delivered</option>
                        <option value="Canceled" ${orderItem.order_status == "Canceled" ? "selected" : ""}>Canceled</option>
                    </select>

                </td>



            </tr>
        `;
        tableBody.append(orderRow);
    });
}



