<?php 

$fetch_all_refund = $db->fetch_all_refund();

if ($fetch_all_refund): ?>
    <?php foreach ($fetch_all_refund as $refund): ?>
        <tr>
            <td class="p-2"><?php echo $refund['order_code']; ?></td>
            <td class="p-2"><?php echo ucfirst($refund['prod_name']); ?></td>
            <td class="p-2"><?php echo ucfirst($refund['Fullname']); ?></td>
            <td class="p-2"><?php echo htmlspecialchars($refund['ref_reason']); ?></td>
            <td class="p-2">
                <?php 
                // Format the ref_date with both date and time
                $formatted_date = date("F j, Y g:i A", strtotime($refund['ref_date']));
                echo htmlspecialchars($formatted_date); 
                ?>
            </td>
            <td class="p-2"><?= $refund['ref_status']; ?></td>

            <?php 
            $status_classes = $refund['ref_status'] == "Pending" ? 
                ["bg-blue-500", "bg-red-500", $refund['ref_id'], ""] : 
                ["bg-blue-200", "bg-red-200", "", "pointer-events-none cursor-not-allowed"];

            echo '
            <td class="p-2">
                <button class="' . $status_classes[0] . ' text-white py-1 px-3 rounded-md togglerApproveRefund" 
                    data-new_status="Approve" 
                    data-ref_id="' . $status_classes[2] . '" ' . ($status_classes[3] ? 'disabled' : '') . '>Approve</button>
                <button class="' . $status_classes[1] . ' text-white py-1 px-3 rounded-md togglerApproveRefund" 
                    data-new_status="Canceled" 
                    data-ref_id="' . $status_classes[2] . '" ' . ($status_classes[3] ? 'disabled' : '') . '>Cancel</button>
            </td>';
            ?>



           
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No students found.</td>
    </tr>
<?php endif; ?>
