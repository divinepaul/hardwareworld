<?php
    $Title = 'Products | HardwareWorld'; 
    include("../../config/all_config.php"); 
    include("../../lib/all_lib.php"); 
    include("../../partials/header.php"); 

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
    WHERE tbl_product.status = 1");

if(!empty($_GET['q'])){
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
        WHERE (product_name LIKE '%".$db->real_escape_string($_GET['q'])."%'
        OR brand_name LIKE '%".$db->real_escape_string($_GET['q'])."%'
        OR subcategory_name LIKE '%".$db->real_escape_string($_GET['q'])."%')
        AND tbl_product.status = 1 
    ");
}
$stmt->execute();
$products = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>
<link rel="stylesheet" href="/static/css/products.css"> 
<div class="products-container">
<form method="GET" autocomplete="off">
<div class="filter-container">
    <div class="search-container">
    <?php
        if(!empty($_GET['q'])){
            echo "<input name=\"q\" class=\"searchbar-input\" type=\"text\" placeholder=\"Search for a product\" value=\"{$_GET['q']}\">";
        } else {
            echo "<input name=\"q\" class=\"searchbar-input\" type=\"text\" placeholder=\"Search for a product\"   >";
        }
    ?>
        <input type="submit" value="Search">
    </div>
</div>
<?php
if(!$products) {
    echo "<p> No product found </p>";
}
foreach ($products as $product) {
    echo "<div class=\"product-container\">";
    echo '<img class="product-image" src="data:image/jpeg;base64,'.base64_encode($product['product_image']).'"/>';
    echo '<div class="product-details">';
        echo "<a target=\"_blank\" href=\"/site/products/view.php?id=${product['product_id']}\">";
        echo "<h1>${product['product_name']}</h1>";
        echo "</a>";
        echo "<p class=\"product-details-subtext\">${product['subcategory_name']}</p>";
        echo "<p class=\"product-details-subtext\">${product['brand_name']}</p><br>";
        $stock = getProductStock($product['product_id']);
        if($stock){
            $price = number_format(getProductPrice($product['product_id']));
            echo "<p class=\"product-price\">₹ ${price}</p>";
            if($stock < 20){
                echo "<p class=\"product-stock-text-warning\">Only {$stock} left in stock!</p>";
            } else {
                echo "<p class=\"product-stock-text\">In Stock</p>";
            }
        } else {
            echo "<p class=\"product-stock-text-warning\">Out of stock</p>";
        }

    echo '</div>';
echo '</div></a>';
}
?>

</div>
