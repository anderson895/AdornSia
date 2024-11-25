<?php

$fetch_all_activity = $db->fetch_all_activity();

if ($fetch_all_activity): ?>
    <?php foreach ($fetch_all_activity as $log): 
        // Format the date and time (example: "Y-m-d H:i:s" for "2024-11-25 14:30:00")
        $formatted_date = (new DateTime($log['log_date']))->format('Y-m-d H:i:s');
        ?>
        <tr>
            <td class="p-2"><?= $log['log_id']; ?></td>
            <td class="p-2"><?= ucfirst($log['log_name']); ?></td>
            <td class="p-2"><?= $log['log_role']; ?></td>
            <td class="p-2"><?= $formatted_date; ?></td>
            <td class="p-2"><?= $log['log_activity']; ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>
