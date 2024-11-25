<?php 
include "components/header.php";
?>

<div class="flex justify-between items-center bg-white p-4 mb-6 rounded-md shadow-md">
    <h2 class="text-lg font-semibold text-gray-700">Admin</h2>
    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-lg font-bold text-white">
        <?php
        echo substr(ucfirst($_SESSION['admin_username']), 0, 1);
        ?>
    </div>
</div>



<!-- Card for Table -->
<div class="bg-white rounded-lg shadow-lg p-6">

<button id="adduserButton" class="bg-blue-500 text-white py-1 px-3 text-sm rounded-lg flex items-center hover:bg-blue-600 transition duration-300 mb-3">
    <span class="material-icons mr-2 text-base">person_add</span>
    Add New
</button>

    <!-- Table Wrapper for Responsiveness -->
    <div class="overflow-x-auto">
        <table id="userTable" class="display table-auto w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-2">ID</th>
                    <th class="p-2">Username</th>
                    <th class="p-2">Fullname</th>
                    <th class="p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include "backend/end-points/user_list.php"; ?>
            </tbody>
        </table>
    </div>
</div>













<!-- Modal for Adding Promo -->
<div id="addUserModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center" style="display:none;">
    <div class="bg-white rounded-lg shadow-lg w-96 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Add New User</h3>
        <form id="adduserForm">

            <div class="mb-4">
                <label for="admin_fullname" class="block text-sm font-medium text-gray-700">Fullname</label>
                <input type="text" id="admin_fullname" name="admin_fullname" class="w-full p-2 border rounded-md" required>
            </div>

            <div class="mb-4">
                <label for="admin_username" class="block text-sm font-medium text-gray-700">User Name</label>
                <input type="text" id="admin_username" name="admin_username" class="w-full p-2 border rounded-md" required>
            </div>
            
            <div class="mb-4">
                <label for="admin_password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="text" id="admin_password" name="admin_password" class="w-full p-2 border rounded-md" required>
            </div>


            <div class="flex justify-end gap-2">
                <button type="button" class="addUserModalClose bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-md">Cancel</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md">Add User</button>
            </div>
        </form>
    </div>
</div>


<?php include "components/footer.php";?>
