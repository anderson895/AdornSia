<?php 
$fetch_all_product = $db->fetch_all_product();

if (!empty($fetch_all_product)) {  // Check if the array is not empty
    foreach ($fetch_all_product as $product):
        $status = ($product['prod_status'] > 0) ? "Active" : "Not Active";
        $image_path = !empty($product['prod_image']) ? "../upload/{$product['prod_image']}" : 'images/default.png';  // Assuming a default image if empty
?>
<tr>
    <td class="p-2"><?php echo $product['prod_code']; ?></td>
    <td class="p-2">
        <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($product['prod_name']); ?>" class="w-16 h-16 object-cover">
    </td>
    <td class="p-2"><?php echo $product['prod_name']; ?></td>
    <td class="p-2"><?php echo $product['product_stocks']; ?></td>
    <td class="p-2"><?php echo strlen($product['prod_description']) > 50 ? substr($product['prod_description'], 0, 50) . '...' : $product['prod_description']; ?></td>
    <td class="p-2"><?php echo $product['category_name']; ?></td>
    <td class="p-2"><?php echo number_format($product['prod_currprice'], 2); ?></td>
    <td class="p-2"><?php echo $status; ?></td>
    <td class="p-2">
        <div class="flex space-x-2 overflow-x-auto max-w-full whitespace-nowrap">
            <button class="bg-blue-500 text-white py-1 px-3 rounded-md 
            updateProductToggler"
            data-prod_id="<?=$product['prod_id']?>"
             data-prod_code="<?=$product['prod_code']?>"
             data-prod_name="<?=$product['prod_name']?>"
             data-prod_currprice="<?=$product['prod_currprice']?>"
             data-prod_category_id="<?=$product['prod_category_id']?>"
             data-prod_critical="<?=$product['prod_critical']?>"
             data-prod_description="<?=$product['prod_description']?>"  
             data-prod_promo_id="<?=$product['prod_promo_id']?>"
              
             
             >Update</button>
            <button class="bg-green-500 text-white py-1 px-3 rounded-md stockInToggler"
            data-product_stocks="<?=$product['product_stocks']?>"
            data-prod_id="<?=$product['prod_id']?>"
            data-prod_name="<?=$product['prod_name']?>"
            >Stockin</button>
            <!-- <button class="bg-gray-500 text-white py-1 px-3 rounded-md">Sizes</button> -->
            <button class="bg-red-500 text-white py-1 px-3 rounded-md removeProduct"
            data-prod_id="<?=$product['prod_id']?>"
            >Remove</button>
        </div>
    </td>
</tr>
<?php 
    endforeach; 
} else { ?>
    <tr>
        <td colspan="8" class="p-2 text-center">No Record found.</td>
    </tr>
<?php } ?>
