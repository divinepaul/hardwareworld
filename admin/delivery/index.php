<?php
$Title = 'Dashboard | Customers'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("admin","staff","courier");
include("../../partials/dashboard_header.php"); 

$stmt = $db->prepare("SELECT 
        tbl_payment.order_id,
        tbl_customer.customer_id,
        tbl_customer.customer_fname,
        tbl_customer.customer_lname,
        tbl_customer.customer_house_name,
        tbl_customer.customer_street,
        tbl_customer.customer_city,
        tbl_customer.customer_state,
        tbl_customer.customer_pincode,
        tbl_customer.customer_phone,
        tbl_cart_master.cart_master_id,
        tbl_payment.date as date_added,
        tbl_courier.courier_id,
        tbl_courier.courier_name,
        tbl_courier.courier_building_name,
        tbl_courier.courier_street,
        tbl_courier.courier_city,
        tbl_courier.courier_state,
        tbl_courier.courier_pincode,
        tbl_courier.courier_phone,
        card_no,
        card_name,
        delivery_date
        FROM tbl_payment
        INNER JOIN tbl_order
            ON tbl_order.order_id = tbl_payment.order_id
        INNER JOIN tbl_cart_master
            ON tbl_order.cart_master_id = tbl_cart_master.cart_master_id
        INNER JOIN tbl_customer
            ON tbl_cart_master.customer_id = tbl_customer.customer_id
        INNER JOIN tbl_delivery
            ON tbl_payment.payment_id = tbl_delivery.payment_id
        INNER JOIN tbl_courier
            ON tbl_payment.courier_id = tbl_courier.courier_id
        INNER JOIN tbl_card
            ON tbl_payment.card_id = tbl_card.card_id
        WHERE 
            tbl_cart_master.status = 'payment-complete'
        ORDER BY date_added DESC
");

$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<div class="admin-heading">
    <h1> Delivery </h1>
    <div>
    <a class="link-button" style="background: #28bd37;" href="/admin/customers/add.php"><i class="fa-solid fa-add"></i>Add Customer</a>
    </div>
</div>

<br>

<div style="overflow-x:auto;">
<table>
<tr>
    <th>id</td>
    <th>Email</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Phone</th>
    <th>House Name</th>
    <th>Street</th>
    <th>City</th>
    <th>State</th>
    <th>Pincode</th>
    <th>Date added</th>
    <th>status</th>
    <th>Actions</th>
</tr>

<?php
foreach ($users as $user) {
    echo "<tr class=\"".($user['status'] == 1 ? "row-active":"row-inactive")."\">";
    echo "<td>{$user['customer_id']}</td>";
    echo "<td>{$user['email']}</td>";
    echo "<td>{$user['customer_fname']}</td>";
    echo "<td>{$user['customer_lname']}</td>";
    echo "<td>{$user['customer_phone']}</td>";
    echo "<td>{$user['customer_house_name']}</td>";
    echo "<td>{$user['customer_street']}</td>";
    echo "<td>{$user['customer_city']}</td>";
    echo "<td>{$user['customer_state']}</td>";
    echo "<td>{$user['customer_pincode']}</td>";
    echo "<td>{$user['date_added']}</td>";
    echo "<td>".($user['status'] == 1 ? "active":"inactive")."</td>";
    echo "<td class=\"action-td\">
            <a class=\"icon-button\" href=\"/admin/customers/edit.php?id={$user['customer_id']}\"><i class=\"fa-solid fa-pen\"></i></a>
            <a class=\"icon-button\" style=\"background: red\" href=\"/admin/users/delete.php?id={$user['email']}\"><i class=\"fa-solid fa-trash\"></i></a>
         </td>";
    echo "</tr>";
}
?>

</table>
</div>
