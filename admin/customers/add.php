<?php
$Title = 'Dashboard | Add Cutomer'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
include("../../partials/dashboard_header.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
?>

<h1> Add Customer </h1>
<br>

<?php

$name_input = new Input("customer_name");
$name_input->type = "text";
$name_input->mysqli_type = "s";
$name_input->label = "Full Name";
$name_input->minLength = 5;

$phone_input = new Input("customer_phone");
$phone_input->type = "text";
$phone_input->label = "Phone";
$phone_input->mysqli_type = "s";
$phone_input->minLength = 10;
$phone_input->maxLength = 10;

$house_name_input = new Input("customer_housename");
$house_name_input->type = "text";
$house_name_input->label = "House Name";
$house_name_input->mysqli_type = "s";
$house_name_input->minLength = 5;
$house_name_input->maxLength = 20;

$city_input = new Input("customer_city");
$city_input->type = "text";
$city_input->label = "City";
$city_input->mysqli_type = "s";
$city_input->minLength = 5;
$house_name_input->maxLength = 20;

$pincode_input = new Input("customer_pincode");
$pincode_input->type = "text";
$pincode_input->label = "Pincode";
$pincode_input->mysqli_type = "s";
$pincode_input->minLength = 6;
$pincode_input->maxLength = 6;

$district_input = new Input("customer_district");
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


$email_input = new Input("email");
$email_input->type = "email";
$email_input->mysqli_type = "s";
$email_input->label = "Email";
$email_input->minLength = 3;

$password_input = new Input("password");
$password_input->type = "password";
$password_input->label = "Password";
$password_input->mysqli_type = "s";
$password_input->minLength = 8;

$confirm_input = new Input("password2");
$confirm_input->type = "password";
$confirm_input->label = "Confirm Password";
$confirm_input->mysqli_type = "s";
$confirm_input->minLength = 8;

$form= new Form(
    $email_input,
    $password_input,
    $confirm_input,
    $name_input,
    $phone_input,
    $house_name_input,
    $city_input,
    $district_input,
    $pincode_input
);

$form->submit_button_text = "Add Customer";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($form->validate()){
        // fetch user from database
        $stmt = $db->prepare("SELECT * FROM tbl_login WHERE email = ?");
        $stmt->bind_param("s", $email_input->value);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if($user){

            array_push($email_input->errors,"There is already an account with this email.");

        } else if($password_input->value != $confirm_input->value){

            array_push($password_input->errors,"Passwords dont match!");
            array_push($confirm_input->errors,"Passwords dont match!");

        } else {

            $db->begin_transaction();
            try {
                // insert user to tbl_login
                $stmt = $db->prepare("INSERT INTO tbl_login (email,password,type,status) VALUES (?,?,?,?)");
                $user_type = "customer";
                $user_status = "active";
                $password = password_hash($password_input->value,PASSWORD_DEFAULT);
                $stmt->bind_param("ssss",$email_input->value,$password,$user_type,$user_status);
                $stmt->execute();
                $stmt->close();

                $CUSOMTER_INSERT_SQL = "
                    INSERT INTO tbl_customer (
                        email,customer_name,customer_district,customer_pincode,customer_city,customer_house_name,customer_phone 
                    ) VALUES (?,?,?,?,?,?,?)
                ";
                $stmt = $db->prepare($CUSOMTER_INSERT_SQL);
                $stmt->bind_param("sssssss",
                    $email_input->value,
                    $name_input->value,
                    $district_input->value,
                    $pincode_input->value,
                    $city_input->value,
                    $house_name_input->value,
                    $phone_input->value,
                );
                $stmt->execute();
                $stmt->close();

                $db->commit();

            } catch (mysqli_sql_exception $exception) {
                $db->rollback();
            }
            redirect('/admin/customers/');
        }
    }
}

echo "<form method=\"{$form->method}\">";

echo '<div class="form-row">';
    echo "<div>";
    $email_input->render();
    echo "</div>";
    echo "<div>";
    $name_input->render();
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

$phone_input->render();
echo "<br><br><label> Adresss </label><br>";

echo '<div class="form-row">';
    echo "<div>";
    $house_name_input->render();
    echo "</div>";
    echo "<div>";
    $city_input->render();
    echo "</div>";
echo "</div>";


echo '<div class="form-row">';
    echo "<div>";
    $pincode_input->render();
    echo "</div>";
    echo "<div>";
    $district_input->render();
    echo "</div>";
echo "</div>";

global $csrf_token;
echo "<input type=\"hidden\" name=\"csrf_token\" value=\"{$csrf_token}\" />";
echo "<input type=\"submit\" value=\"{$form->submit_button_text}\" />";
echo "</form>";
echo "<br>";

?>

</div>


