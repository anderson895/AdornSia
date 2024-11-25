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

<button class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">
    <span class="material-icons mr-2">person_add</span>
    Add User
</button>

<!-- Card for Table -->
<div class="bg-white rounded-lg shadow-lg p-6">

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

<?php include "components/footer.php";?>
