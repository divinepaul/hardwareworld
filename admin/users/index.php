<?php
$Title = 'Dashboard | Users'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
include("../../partials/dashboard_header.php"); 

$stmt = $db->prepare("SELECT * FROM tbl_login");
$stmt->execute();
$users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>

<div class="admin-heading">
    <h1> Staff Details </h1>
    <div>
    <a class="link-button" href="/admin/users/add.php"><i class="fa-solid fa-add"></i>Add User</a>
    </div>
</div>

<br>
<div style="overflow-x:auto;">
<table>
<tr>
    <th>email</th>
    <th>password</th>
    <th>type</th>
    <th>status</th>
    <th>Actions</th>
</tr>

<?php
foreach ($users as $user) {
    echo "<tr>";
    echo "<td>{$user['email']}</td>";
    echo "<td>{$user['password']}</td>";
    echo "<td>{$user['type']}</td>";
    echo "<td>{$user['status']}</td>";
    echo "<td class=\"action-td\">
            <a class=\"icon-button\" href=\"/admin/users/edit.php?id={$user['email']}\"><i class=\"fa-solid fa-pen\"></i></a>
            <a class=\"icon-button\" style=\"background: red\" href=\"/admin/users/delete.php?id={$user['email']}\"><i class=\"fa-solid fa-trash\"></i></a>
         </td>";
    echo "</tr>";
}
?>

</table>
</div>
