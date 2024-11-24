<?php 

// Set the timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

$fetch_all_promotion = $db->fetch_all_promotion();

if ($fetch_all_promotion): ?>
    <!-- Legend for the guide -->
    <div class="legend">
        <p><strong>Legend:</strong></p>
        <ul>
            <li><span style="color: green;">&#8226;</span> Active Promotions</li>
            <li><span style="color: red;">&#8226;</span> Expired Promotions</li>
        </ul>
    </div>

    <!-- Table displaying the promotions -->
  
            <?php foreach ($fetch_all_promotion as $promotion): 
                // Get the current date in Asia/Manila timezone
                $current_date = date('Y-m-d'); // Current date in YYYY-MM-DD format
                $promo_expiration_date = $promotion['promo_expiration']; // Assuming the date format is 'Y-m-d'

                // Compare the dates to check if the promo has expired
                $is_expired = strtotime($promo_expiration_date) < strtotime($current_date); 
            ?>
                <tr>
                    <td class="p-2"><?= $promotion['promo_id']; ?></td>
                    <td class="p-2"><?= $promotion['promo_name']; ?></td>
                    <td class="p-2"><?= $promotion['promo_description']; ?></td>
                    <td class="p-2"><?= ($promotion['promo_rate'] * 100) / 2; ?>%</td>
                    <td class="p-2"><?= $promotion['promo_expiration']; ?></td>
                    <td class="p-2">
                        <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerUpdateUser" data-user_id="<?= $promotion['promo_id'] ?>">Update</button>
                        <button class="bg-red-500 text-white py-1 px-3 rounded-md" data-user_id="<?= $promotion['promo_id'] ?>">Remove</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        
<?php else: ?>
    <tr>
        <td colspan="5" class="p-2">No record found.</td>
    </tr>
<?php endif; ?>
