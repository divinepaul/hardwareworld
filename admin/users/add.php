<?php
$Title = 'Dashboard | Add Users'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
include("../../partials/dashboard_header.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
?>

<h1> Add User</h1>
<br>
<br>

<?php

$email_input = new Input("email");
$email_input->type = "email";
$email_input->mysqli_type = "s";
$email_input->label = "Email";
$email_input->minLength = 3;

$emal_input = new Input("textarea");
$emal_input->type = "textarea";
$emal_input->mysqli_type = "s";
$emal_input->label = "textarea";
$emal_input->minLength = 3;

$pass_input = new Input("password");
$pass_input->type = "password";
$pass_input->label = "Password";
$pass_input->mysqli_type = "s";
$pass_input->minLength = 8;

$usertype_input = new Input("type");
$usertype_input->type = "select";
$usertype_input->label = "User type";
$usertype_input->mysqli_type = "s";
$usertype_input->selectOptions = array(
    "admin" => "admin",
    "staff" => "staff",
    "courier" => "courier",
    "customer" => "customer", 
);

$userstatus_input = new Input("status");
$userstatus_input->type = "select";
$userstatus_input->label = "User Status";
$userstatus_input->mysqli_type = "i";
$userstatus_input->selectOptions = array(
    0 => "active", 
    1 => "inactive",
);

$form = new Form($email_input,$emal_input,$pass_input,$usertype_input,$userstatus_input);
$form->sql_table = "tbl_login";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($form->validate()) {
        $form->save();
        redirect("/admin/users/");
    } 
}

$form->render();

?>



