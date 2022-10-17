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
include("../../partials/header.php"); 

$stock = getProductStock($product['product_id']);
$price = getProductPrice($product['product_id']);
if($price){
    $priceFormatted = number_format($price); 
}

function getCartMaster($customer_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM tbl_cart_master WHERE customer_id = ? AND status = 'in cart'");
    $stmt->bind_param("s", $customer_id);
    $stmt->execute();
    $cart_master = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $cart_master;
}

function getDeletedCartMaster($customer_id) {
    global $db;
    $stmt = $db->prepare("SELECT * FROM tbl_cart_master WHERE customer_id = ? AND status = 'deleted'");
    $stmt->bind_param("s", $customer_id);
    $stmt->execute();
    $cart_master = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $cart_master;
}

$quantity_input = new Input("quantity","Quantity",INF,INF,"number","i");
$quantity_input->value = 1;
$hidden_input   = new Input("hidden","hidden",INF,INF,"hidden");

$form = new Form(
    $quantity_input
);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    check_auth_redirect_if_not();
    if($form->validate()){
        if(!check_role("customer")){
            array_push($hidden_input->errors,"Admin/Staff/Courier users cannot add to cart");
        }
        else if($stock < 1){
            array_push($hidden_input->errors,"Out of stock");
        }
        else if(((int)$quantity_input->value) > $stock){
            array_push($hidden_input->errors,"Quantity cannot excced available stock of $stock");
        } else {
            $stmt = $db->prepare("SELECT * FROM tbl_customer WHERE email = ?");
            $stmt->bind_param("s", $_SESSION['user']['email']);
            $stmt->execute();
            $customer = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            $cart_master = getCartMaster($customer['customer_id']);
            $deleted_cart_master = getDeletedCartMaster($customer['customer_id']);
            $db->begin_transaction();
            try {
                if(!$deleted_cart_master){
                    $stmt = $db->prepare("INSERT INTO tbl_cart_master (customer_id,status) VALUES (?,?)");
                    $status = 'deleted';
                    $stmt->bind_param("is", $customer['customer_id'], $status);
                    $stmt->execute();
                    $stmt->close();
                }
                if(!$cart_master){
                    $stmt = $db->prepare("INSERT INTO tbl_cart_master (customer_id,status) VALUES (?,?)");
                    $status = 'in cart';
                    $stmt->bind_param("is", $customer['customer_id'], $status);
                    $stmt->execute();
                    $stmt->close();

                    $cart_master = getCartMaster($customer['customer_id']);
                }
                $stmt = $db->prepare("INSERT INTO tbl_cart_child
                    (cart_master_id,product_id,quantity) 
                    VALUES (?,?,?)");
                $status = 'in cart';
                $stmt->bind_param("iii", $cart_master['cart_master_id'],$product['product_id'],$quantity_input->value);
                $stmt->execute();
                $stmt->close();
                $db->commit();
                
                redirect("/site/cart/view.php");
            } catch (mysqli_sql_exception $exception) {
                echo $exception;
                $db->rollback();
            }
        }
    }
}


?>
<link rel="stylesheet" href="/static/css/product-view.css"> 

<div class="product-view-container">
    <div class="product-image-container">
        <?php echo '<img class="product-image" src="/site/products/image.php?id='.$product['product_id'].'" loading="lazy"/>';?>
    </div>
    <div class="product-details-container">
        <h1><?php echo $product['product_name']?></h1>
        <p>Brand: <?php echo $product['brand_name']?></p>
        <p><?php echo $product['subcategory_name']?></p>
        <hr>
        <?php
            if($stock){
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

        <div class="add-to-cart-container">
            <form method="POST">
            Quantity: <input type="number" name="quantity" min="1" max="<?php echo $stock ?>" value="<?php echo $quantity_input->value;?>" /><br> 
            <a class="link-button" style="background: #28bd37;" href="javascript:{}" onclick="document.querySelector('form').submit();"><i class="fa-solid fa-add"></i>Add to Cart</a>
            <?php $hidden_input->render();
                global $csrf_token;
                echo "<input type=\"hidden\" name=\"csrf_token\" value=\"{$csrf_token}\" />";
                foreach ($quantity_input->errors as $i => $error) {
                    echo "<p class=\"error\">{$error}</p>";
                }
            ?>
            </form>
        </div>

        <div class="product-details-list">
            <h2>About this item</h1>
            <ul>
            <?php
                foreach (explode("\n",$product['product_description']) as $key => $value) {
                    echo "<li>{$value}</li>";
                }
            ?>
            </ul>
        </div>
    </div>

</div>
