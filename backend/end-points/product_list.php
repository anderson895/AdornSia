<?php 
$fetch_all_product = $db->fetch_all_product();


    foreach ($fetch_all_product as $product):
        $promo_rate_percentage = $product['promo_rate'] * 100; // Assuming promo_rate is a decimal (e.g., 0.20 for 20%)
        $discount_amount = $product['prod_currprice'] * $product['promo_rate']; // Calculate the discount amount
        $discounted_price = $product['prod_currprice'] - $discount_amount; 


?>

<!-- Product Card 1 -->
 <?php 
 if($product['prod_promo_id']){
    ?>
     

         <!-- Product Card 2 -->
         <div class="bg-white p-4 rounded shadow-lg" data-category-id=<?=$product['prod_category_id']?>>
          <img src="upload/<?=$product['prod_image']?>" alt="Product Image" class="w-full rounded mb-4">
          <h2 class="font-semibold text-lg"><?=$product['prod_name']?></h2>
          <p class="text-gray-600"><?=$product['prod_description']?></p>
          <p class="text-lg font-bold text-red-600">PHP <?=number_format($discounted_price, 2);?></p>
          <p class="text-sm text-gray-500 line-through">PHP<?=$product['prod_currprice']?></p>
          <p class="text-sm text-green-600"><?=$promo_rate_percentage?> off</p>
        </div>
    <?php
 }else{
 ?>
       
       <div class="bg-white p-4 rounded shadow-lg" data-category-id=<?=$product['prod_category_id']?>>
          <img src="upload/<?=$product['prod_image']?>" alt="Product Image" class="w-full rounded mb-4">
          <h2 class="font-semibold text-lg"><?=$product['prod_name']?></h2>
          <p class="text-gray-600"><?=$product['prod_description']?></p>
          <p class="text-lg font-bold text-gray-800">PHP <?=$product['prod_currprice']?></p>
        </div>
       

<?php 
 }
    endforeach; 
?>