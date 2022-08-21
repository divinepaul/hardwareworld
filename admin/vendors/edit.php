<?php
$Title = 'Dashboard | Edit Login Details'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
include("../../partials/dashboard_header.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");

if(!isset($_GET['id'])){
    redirect('/admin/users/');
}
if(empty($_GET['id'])){
    redirect('/admin/users/');
}

$id = $_GET['id'];
?>
<h1> Edit Customer Details </h1>
<br>

<?php


$fname_input = new Input("customer_fname");
$fname_input->type = "text";
$fname_input->mysqli_type = "s";
$fname_input->label = "First Name";
$fname_input->minLength = 2;
$fname_input->maxLength = 15;

$lname_input = new Input("customer_lname");
$lname_input->type = "text";
$lname_input->mysqli_type = "s";
$lname_input->label = "Last Name";
$lname_input->minLength = 2;
$lname_input->maxLength = 15;


$house_name_input = new Input("customer_house_name");
$house_name_input->type = "text";
$house_name_input->label = "House Name";
$house_name_input->mysqli_type = "s";
$house_name_input->minLength = 5;
$house_name_input->maxLength = 20;

$street_input = new Input("customer_street");
$street_input->type = "text";
$street_input->label = "Street/Area";
$street_input->mysqli_type = "s";
$street_input->minLength = 5;
$street_input->maxLength = 20;

$city_input = new Input("customer_city");
$city_input->type = "text";
$city_input->label = "City";
$city_input->mysqli_type = "s";
$city_input->minLength = 5;
$city_input->maxLength = 20;

$state_input = new Input("customer_state");
$state_input->label = "State";
$state_input->type = "select";
$state_input->selectOptions = array(
    "Andhra Pradesh" => "Andhra Pradesh",
    "Arunachal Pradesh" => "Arunachal Pradesh",
    "Assam" => "Assam",
    "Bihar" => "Bihar",
    "Chandigarh (UT)" => "Chandigarh (UT)",
    "Chhattisgarh" => "Chhattisgarh",
    "Delhi (NCT)" => "Delhi (NCT)",
    "Goa" => "Goa",
    "Gujarat" => "Gujarat",
    "Haryana" => "Haryana",
    "Himachal Pradesh" => "Himachal Pradesh",
    "Jammu and Kashmir" => "Jammu and Kashmir",
    "Jharkhand" => "Jharkhand",
    "Karnataka" => "Karnataka",
    "Kerala" => "Kerala",
    "Lakshadweep (UT)" => "Lakshadweep (UT)",
    "Madhya Pradesh" => "Madhya Pradesh",
    "Maharashtra" => "Maharashtra",
    "Manipur" => "Manipur",
    "Meghalaya" => "Meghalaya",
    "Mizoram" => "Mizoram",
    "Nagaland" => "Nagaland",
    "Odisha" => "Odisha",
    "Puducherry (UT)" => "Puducherry (UT)",
    "Punjab" => "Punjab",
    "Rajasthan" => "Rajasthan",
    "Sikkim" => "Sikkim",
    "Tamil Nadu" => "Tamil Nadu",
    "Telangana" => "Telangana",
    "Tripura" => "Tripura",
    "Uttarakhand" => "Uttarakhand",
    "Uttar Pradesh" => "Uttar Pradesh",
    "West Bengal" => "West Bengal"
);
$state_input->mysqli_type = "s";

$pincode_input = new Input("customer_pincode");
$pincode_input->type = "text";
$pincode_input->label = "Pincode";
$pincode_input->mysqli_type = "s";
$pincode_input->minLength = 3;
$pincode_input->maxLength = 6;

$phone_input = new Input("customer_phone");
$phone_input->type = "text";
$phone_input->label = "Phone";
$phone_input->mysqli_type = "s";
$phone_input->minLength = 10;
$phone_input->maxLength = 10;

$form = new Form(
    $lname_input,
    $fname_input,
    $phone_input,
    $house_name_input,
    $street_input,
    $city_input,
    $state_input,
    $pincode_input,
);

$form->sql_table = "tbl_customer";
$form->sql_id = $id;
$form->sql_id_type = "i"; 
$form->sql_pk_name = "customer_id"; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($form->validate()) {
        $form->save();
        redirect("/admin/customers/");
    } 
}

$form->render();

?>
