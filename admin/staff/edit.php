<?php
$Title = 'Dashboard | Edit Login Details'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
include("../../partials/dashboard_header.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");

if(!isset($_GET['id'])){
    redirect('/admin/staff/');
}
if(empty($_GET['id'])){
    redirect('/admin/staff/');
}
if(!is_numeric($_GET['id'])){
    redirect('/admin/staff/');
}

$id = $_GET['id'];

?>

<h1> Edit Staff Details </h1>
<br>

<?php
$name_input = new Input("staff_name");
$name_input->type = "text";
$name_input->mysqli_type = "s";
$name_input->label = "Full Name";
$name_input->minLength = 5;

$phone_input = new Input("staff_phone");
$phone_input->type = "text";
$phone_input->label = "Phone";
$phone_input->mysqli_type = "s";
$phone_input->minLength = 10;
$phone_input->maxLength = 10;

$house_name_input = new Input("staff_house_name");
$house_name_input->type = "text";
$house_name_input->label = "House Name";
$house_name_input->mysqli_type = "s";
$house_name_input->minLength = 5;
$house_name_input->maxLength = 20;

$city_input = new Input("staff_city");
$city_input->type = "text";
$city_input->label = "City";
$city_input->mysqli_type = "s";
$city_input->minLength = 5;
$house_name_input->maxLength = 20;

$pincode_input = new Input("staff_pincode");
$pincode_input->type = "text";
$pincode_input->label = "Pincode";
$pincode_input->mysqli_type = "s";
$pincode_input->minLength = 6;
$pincode_input->maxLength = 6;

$district_input = new Input("staff_district");
$district_input->label = "District";
$district_input->type = "select";
$district_input->selectOptions = array(
    "Alappuzha" => "Alappuzha",
    "Ernakulam" => "Ernakulam",
    "Idukki" => "Idukki",
    "Kannur" => "Kannur",
    "Kasaragod" => "Kasaragod",
    "Kollam" => "Kollam",
    "Kottayam" => "Kottayam",
    "Kozhikode" => "Kozhikode",
    "Malappuram" => "Malappuram",
    "Palakkad" => "Palakkad",
    "Pathanamthitta" => "Pathanamthitta",
    "Thiruvanathapuram" => "Thiruvanathapuram",
    "Thrissur" => "Thrissur",
    "Wayanad" => "Wayanad",
);
$district_input->mysqli_type = "s";

$salary_input = new Input("staff_salary");
$salary_input->type = "text";
$salary_input->label = "Salary";
$salary_input->mysqli_type = "i";
$salary_input->minLength = 4;

$form = new Form(
    $name_input,
    $phone_input,
    $house_name_input,
    $city_input,
    $district_input,
    $pincode_input,
    $salary_input
);

$form->sql_table = "tbl_staff";
$form->sql_id = $id;
$form->sql_id_type = "i"; 
$form->sql_pk_name = "staff_id"; 


$form->render();

?>
