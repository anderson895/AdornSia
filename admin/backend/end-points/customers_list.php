<?php 

$fetch_all_students = $db->fetch_all_customers();

if ($fetch_all_students): ?>
    <?php foreach ($fetch_all_students as $student):
        $status = ($student['status'] > 0) ? "Verified" : "Not Verified";
        $status_color = ($student['status'] > 0) ? "text-green-500" : "text-red-500";
        ?>
        <tr>
            <td class="p-2"><?php echo htmlspecialchars($student['user_id']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($student['Fullname']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($student['Email']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($student['Phone']); ?></td>
            <td class="p-2 <?= $status_color; ?>"><?php echo $status; ?></td>
           
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>
