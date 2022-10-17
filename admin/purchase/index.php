<?php
$Title = 'Dashboard | Purchases'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
include("../../partials/dashboard_header.php"); 

$stmt = $db->prepare("SELECT 
    purchase_master_id,
    tbl_purchase_master.vendor_id as vendor_id,
    vendor_name,
    vendor_email,
    staff_fname,
    staff_lname,
    tbl_staff.email as staff_email,
    tbl_purchase_master.staff_id as staff_id, 
    tbl_purchase_master.date_added as date_added,
    tbl_purchase_master.status as status 
    FROM tbl_purchase_master 
    INNER JOIN tbl_staff
        ON tbl_purchase_master.staff_id = tbl_staff.staff_id
    INNER JOIN tbl_vendor
        ON tbl_purchase_master.vendor_id = tbl_vendor.vendor_id
    ORDER BY tbl_purchase_master.status DESC,tbl_purchase_master.date_added");
$stmt->execute();
$purchases = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

foreach ($purchases as $i => $purchase) {

    $stmt = $db->prepare("SELECT 
        purchase_child_id,
        tbl_purchase_master.purchase_master_id as purchase_master_id,
        tbl_purchase_child.product_id as product_id,
        product_name,
        cost_price,
        selling_price,
        quantity
        FROM tbl_purchase_child 
        INNER JOIN tbl_purchase_master 
            ON tbl_purchase_child.purchase_master_id = tbl_purchase_master.purchase_master_id 
        INNER JOIN tbl_product
            ON tbl_product.product_id = tbl_purchase_child.product_id
        WHERE tbl_purchase_child.purchase_master_id = ?
        ");
    $stmt->bind_param("i",$purchase["purchase_master_id"]);
    $stmt->execute();
    $purchaseItems = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $purchases[$i]['purchase_items'] = $purchaseItems;
    $total_cost = 0; 
    foreach ($purchaseItems as $key => $item) {
        $total_cost += $item['cost_price'];
    }
    $purchases[$i]['total_cost'] = $total_cost;
}


?>

<div class="admin-heading">
    <h1> Purchase Details </h1>
    <div>
    <a class="link-button" style="background: #28bd37;" href="/admin/purchase/new.php"><i class="fa-solid fa-add"></i>New Purchase</a>
    </div>
</div>

<br>

<div style="overflow-x:auto;">
<table>
    <tr>
    <th>id</th>
    <th>Vendor</th>
    <th>Added By</th>
    <th>Total Cost</th>
    <th>Dated Added</th>
    <th>Status</th>
    <th colspan="5">Purchase Details</th>
    <th>Actions</th>
<?php
    foreach ($purchases as $i => $purchase) {
        echo "<tr class=\"".($purchase['status'] == 1 ? "row-active":"row-inactive")."\">";
        $productCount = count($purchase['purchase_items']);
        $productCount += 2;
        echo "<td rowspan=\"$productCount\">{$purchase['purchase_master_id']}</td>";
        echo "<td rowspan=\"$productCount\">{$purchase['vendor_name']}</td>";
        echo "<td rowspan=\"$productCount\">{$purchase['staff_email']}</td>";
        echo "<td rowspan=\"$productCount\">₹{$purchase['total_cost']}</td>";
        echo "<td rowspan=\"$productCount\">{$purchase['date_added']}</td>";
        echo "<td rowspan=\"$productCount\">".($purchase['status'] == 1 ? "active":"inactive")."</td>";
        echo "</tr>";
        echo "<tr class=\"".($purchase['status'] == 1 ? "row-active":"row-inactive")."\">";
            echo "<th>id</th>";
            echo "<th>Product</th>";
            echo "<th>Cost</th>";
            echo "<th>Price</th>";
            echo "<th>Quantity</th>";
            echo "<td rowspan=\"$productCount\" >";
                    if (!isPurchaseUsed($purchase['purchase_master_id'])) {
                        echo "<a class=\"icon-button\" href=\"/admin/purchase/edit.php?id={$purchase['purchase_master_id']}\"><i class=\"fa-solid fa-pen\"></i></a>";
                        echo "<br>";
                        echo "<br>";
                        echo "<a class=\"icon-button\" style=\"background: red\" href=\"/admin/purchase/delete.php?id={$purchase['purchase_master_id']}\"><i class=\"fa-solid fa-trash\"></i></a>";
                    }
            echo "</td>";
        echo "</tr>";
        foreach($purchase['purchase_items'] as $j => $purchaseItem){
            //$productName = (strlen($purchaseItem['product_name']) > 50) ? substr($purchaseItem['product_name'],0,25).'...' : $purchaseItem['product_name'];
            echo "<tr class=\"".($purchase['status'] == 1 ? "row-active":"row-inactive")."\">";
                echo "<td>{$purchaseItem['purchase_child_id']}</td>";
                echo "<td>{$purchaseItem['product_name']}</td>";
                echo "<td>₹{$purchaseItem['cost_price']}</td>";
                echo "<td>₹{$purchaseItem['selling_price']}</td>";
                echo "<td>{$purchaseItem['quantity']}</td>";
            echo "</tr>";
        }
        echo "<tr>";
        echo "</tr>";
    }
?>
</table>
</div>
