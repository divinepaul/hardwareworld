<?php
$Title = 'Dashboard | Add Vendors'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
include("../../partials/dashboard_header.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
?>

<h1> Add Customer </h1>
<br>


<?php

$name_input = new Input("customer_fname");
$name_input->type = "text";
$name_input->mysqli_type = "s";
$name_input->label = "First Name";
$name_input->minLength = 2;
$name_input->maxLength = 30;

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
$phone_input->minLength = 8;
$phone_input->maxLength = 10;

$email_input = new Input("email");
$email_input->type = "email";
$email_input->mysqli_type = "s";
$email_input->label = "Email";
$email_input->minLength = 5;
$email_input->maxLength = 50;


$form = new Form(
    $name_input,
    $house_name_input,
    $street_input,
    $city_input,
    $state_input,
    $pincode_input,
    $phone_input,
    $email_input,
);

$form->submit_button_text = "Register";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($form->validate()){
            redirect('/admin/customers/');
    }
}

echo "<form method=\"{$form->method}\">";

echo '<div class="form-row">';
    echo "<div>";
    $fname_input->render();
    echo "</div>";
    echo "<div>";
    $lname_input->render();
    echo "</div>";
echo "</div>";

echo '<div class="form-row">';
    echo "<div>";
    $email_input->render();
    echo "</div>";
    echo "<div>";
    $phone_input->render();
    echo "</div>";
echo "</div>";

echo '<div class="form-row">';
    echo "<div>";
    $password_input->render();
    echo "</div>";
    echo "<div>";
    $confirm_input->render();
    echo "</div>";
echo "</div>";

echo "<br><br><label> Adresss </label><br>";

echo '<div class="form-row">';
    echo "<div>";
    $house_name_input->render();
    echo "</div>";
    echo "<div>";
    $street_input->render();
    echo "</div>";
echo "</div>";


echo '<div class="form-row">';
    echo "<div>";
    $city_input->render();
    echo "</div>";
    echo "<div>";
    $state_input->render();
    echo "</div>";
echo "</div>";
$pincode_input->render();
global $csrf_token;
echo "<input type=\"hidden\" name=\"csrf_token\" value=\"{$csrf_token}\" />";
echo "<input type=\"submit\" value=\"{$form->submit_button_text}\" />";
echo "</form>";
echo "<br>";

?>

</div>


