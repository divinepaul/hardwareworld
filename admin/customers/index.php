<?php
$Title = 'Dashboard | Customers'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
include("../../partials/dashboard_header.php"); 

$stmt = $db->prepare("SELECT * FROM tbl_customer INNER JOIN tbl_login ON tbl_customer.email = tbl_login.email");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>

<div class="admin-heading">
    <h1> Customer Details </h1>
    <div>
    <a class="link-button" href="/admin/customers/add.php"><i class="fa-solid fa-add"></i>Add Customer</a>
    </div>
</div>

<br>

<div style="overflow-x:auto;">
<table>
<tr>
    <th>id</td>
    <th>Email</th>
    <th>Name</th>
    <th>Phone</th>
    <th>House Name</th>
    <th>City</th>
    <th>District</th>
    <th>Pincode</th>
    <th>Date added</th>
    <th>status</th>
    <th>Actions</th>
</tr>

<?php
foreach ($users as $user) {
    echo "<tr>";
    echo "<td>{$user['customer_id']}</td>";
    echo "<td>{$user['email']}</td>";
    echo "<td>{$user['customer_name']}</td>";
    echo "<td>{$user['customer_phone']}</td>";
    echo "<td>{$user['customer_house_name']}</td>";
    echo "<td>{$user['customer_city']}</td>";
    echo "<td>{$user['customer_district']}</td>";
    echo "<td>{$user['customer_pincode']}</td>";
    echo "<td>{$user['date_added']}</td>";
    echo "<td>{$user['status']}</td>";
    echo "<td class=\"action-td\">
            <a class=\"icon-button\" href=\"/admin/customers/edit.php?id={$user['customer_id']}\"><i class=\"fa-solid fa-pen\"></i></a>
            <a class=\"icon-button\" style=\"background: red\" href=\"/admin/users/delete.php?id={$user['email']}\"><i class=\"fa-solid fa-trash\"></i></a>
         </td>";
    echo "</tr>";
}
?>

</table>
</div>
