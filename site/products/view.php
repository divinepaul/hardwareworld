<?php
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
if(!isset($_GET['id'])){
    redirect('/site/products/');
}
if(empty($_GET['id'])){
    redirect('/site/products/');
}
if(!is_numeric($_GET['id'])){
    redirect('/site/products/');
}
$id = $_GET['id'];

$stmt = $db->prepare("SELECT 
    product_id,
    product_name,
    product_image,
    product_description,
    subcategory_name,
    brand_name,
    tbl_product.status as status,
    tbl_product.date_added as date_added
    FROM tbl_product 
    INNER JOIN tbl_subcategory
        ON tbl_product.subcategory_id = tbl_subcategory.subcategory_id
    INNER JOIN tbl_brand
        ON tbl_product.brand_id = tbl_brand.brand_id
    WHERE product_id = ? AND tbl_product.status = 1"
);

$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

if(!$product){
    redirect('/site/products/');
}

$Title = $product['product_name']; 

$stock = getProductStock($product['product_id']);
$price = getProductPrice($product['product_id']);
if($price){
    $priceFormatted = number_format($price); 
}

include("../../partials/header.php"); 
?>
<link rel="stylesheet" href="/static/css/product-view.css"> 


<div class=""></div>
<h1><?php echo $product['product_name']?></h1>
<p><?php echo $product['brand_name']?></p>
<p><?php echo $product['subcategory_name']?></p>
<?php echo '<img class="product-image" src="data:image/jpeg;base64,'.base64_encode($product['product_image']).'"/>';?>
<h2>About this item</h1>
<ul style="margin-left:20px">
<?php
    foreach (explode("\n",$product['product_description']) as $key => $value) {
        echo "<li style=\"display:list-item\">{$value}</li>";
    }
?>
</ul>
<?php
        if($stock){
            $price = number_format(getProductPrice($product['product_id']));
            echo "<p class=\"product-price\">₹ ${priceFormatted}</p>";
            if($stock < 20){
                echo "<p class=\"product-stock-text-warning\">Only {$stock} left in stock!</p>";
            } else {
                echo "<p class=\"product-stock-text\">In Stock</p>";
            }
        } else {
            echo "<p class=\"product-stock-text-warning\">Out of stock</p>";
        }
?>
