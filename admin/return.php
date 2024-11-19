<?php 
session_start();
include "components/header.php";
?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Return List</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($_SESSION['admin_username']), 0, 1);
        ?>
    </div>
</div>

<!-- Card for Table -->
<div class="bg-white rounded-lg shadow-lg p-6">

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="display table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-2">Order Code</th>
                    <th class="p-2">Product</th>
                    <th class="p-2">Customer name</th>
                    <th class="p-2">Reason</th>
                    <th class="p-2">Refund Date</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/ReturnRefund_list.php"; ?> 
            </tbody>
        </table>
    </div>
</div>












<!-- Modal -->
<div id="RefundModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50" style="display:none;">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full sm:w-[600px] max-h-[90vh] overflow-y-auto flex flex-col animate__animated animate__fadeIn">



        <!-- Spinner -->
        <div class="spinner" style="display:none;">
            <div class="absolute inset-0 bg-white bg-opacity-75 flex items-center justify-center">
                <div class="w-12 h-12 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
            </div>
        </div>

        <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Approve Request<span id="stockinTarget"></span></h2>

        <!-- Modal Form for Adding Product -->
        <form id="frmRefund" class="flex flex-col items-center w-full">

            <input hidden type="text" id="ref_id" name="ref_id">
            <input hidden type="text" id="new_status" name="new_status">


            <div class="flex justify-center gap-4 mt-6 w-full">
                <button type="button" class="px-6 py-3 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-300 ease-in-out w-full sm:w-auto text-lg closeModal">Cancel</button>
                <button type="submit" class="px-6 py-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-300 ease-in-out w-full sm:w-auto text-lg">Confirm</button>
            </div>
        </form>
    </div>
</div>
<?php include "components/footer.php";?>
