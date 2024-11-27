<?php

$fetch_all_activity = $db->fetch_all_activity();

function formatDate($date) {
    return (new DateTime($date))->format('F j, Y \a\t g:i A');
}

if ($fetch_all_activity): ?>
    <?php foreach ($fetch_all_activity as $log): ?>
        <tr class="border-b">
            <td class="p-2"><?= htmlspecialchars($log['log_id']); ?></td>
            <td class="p-2"><?= htmlspecialchars($log['log_name']); ?></td>
            <td class="p-2"><?= htmlspecialchars($log['log_role']); ?></td>
            <td class="p-2"><?= formatDate($log['log_date']); ?></td>
            <td class="p-2"><?= htmlspecialchars($log['log_activity']); ?></td>
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2 text-center">No record found.</td>
    </tr>
<?php endif; ?>
