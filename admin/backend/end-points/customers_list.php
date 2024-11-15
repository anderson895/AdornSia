<?php 
include('backend/class.php');

$db = new global_class();

$fetch_all_students = $db->fetch_all_customers();




if ($fetch_all_students): ?>
            <?php foreach ($fetch_all_students as $student):
                
                $status = ($student['status'] > 1) ? "Verified" : "Not Verified";

                ?>
                <tr>
                    <td class="p-2"><?php echo htmlspecialchars($student['user_id']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($student['Fullname']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($student['Email']); ?></td>
                    <td class="p-2"><?php echo htmlspecialchars($student['Phone']); ?></td>
                    <td class="p-2"><?= $status ?></td>
                    <td class="p-2">
                        <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateUser" data-user_id=<?=$student['user_id']?>>View</button>
                        <button class="bg-red-500 text-white py-1 px-3 rounded-md">Disable</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="p-2">No students found.</td>
            </tr>
        <?php endif; ?>