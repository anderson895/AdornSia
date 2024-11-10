<?php 
include('backend/class.php');

$db = new global_class();

$fetch_all_product = $db->fetch_all_product();




if ($fetch_all_product): ?>
            <?php foreach ($fetch_all_product as $product):
                
                $status = ($product['prod_status'] > 1) ? "Active" : "Not Active";

                ?>
                <tr>
                    <td class="p-2"><?php echo $product['prod_code']; ?></td>
                    <td class="p-2"><?php echo $product['prod_image']; ?></td>
                    <td class="p-2"><?php echo $product['prod_name']; ?></td>
                    <td class="p-2"><?php echo $product['prod_currprice']; ?></td>
                    <td class="p-2"><?php echo $product['prod_description']; ?></td>
                    <td class="p-2"><?php echo $product['prod_currprice']; ?></td>
                    <td class="p-2"><?= $status ?></td>
                    <td class="p-2">
                        <div class="flex space-x-2 overflow-x-auto max-w-full whitespace-nowrap">
                            <button class="bg-blue-500 text-white py-1 px-3 rounded-md togglerViewUser" data-user_id=<?=$product['prod_id']?>>Update</button>
                            <button class="bg-red-500 text-white py-1 px-3 rounded-md">Disable</button>
                            <button class="bg-red-500 text-white py-1 px-3 rounded-md">Remove</button>
                        </div>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="p-2">No Record found.</td>
            </tr>
        <?php endif; ?>