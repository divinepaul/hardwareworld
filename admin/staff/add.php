<?php
$Title = 'Dashboard | Add Staff'; 
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
include("../../partials/dashboard_header.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
?>

<h1> Add Staff </h1>
<br>

<?php

$fname_input = new Input("staff_fname");
$fname_input->type = "text";
$fname_input->mysqli_type = "s";
$fname_input->label = "First Name";
$fname_input->minLength = 2;
$fname_input->maxLength = 15;

$lname_input = new Input("staff_lname");
$lname_input->type = "text";
$lname_input->mysqli_type = "s";
$lname_input->label = "Last Name";
$lname_input->minLength = 2;
$lname_input->maxLength = 15;


$house_name_input = new Input("staff_housename");
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

$city_input = new Input("staff_city");
$city_input->type = "text";
$city_input->label = "City";
$city_input->mysqli_type = "s";
$city_input->minLength = 5;


$state_input = new Input("staff_state");
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

$pincode_input = new Input("staff_pincode");
$pincode_input->type = "text";
$pincode_input->label = "Pincode";
$pincode_input->mysqli_type = "s";
$pincode_input->minLength = 3;
$pincode_input->maxLength = 6;

$salary_input = new Input("staff_salary");
$salary_input->type = "text";
$salary_input->label = "Salary";
$salary_input->mysqli_type = "i";
$salary_input->minLength = 4;

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

$phone_input = new Input("staff_phone");
$phone_input->type = "text";
$phone_input->label = "Phone";
$phone_input->mysqli_type = "s";
$phone_input->minLength = 8;
$phone_input->maxLength = 10;

$form= new Form(
    $lname_input,
    $fname_input,

    $house_name_input,
    $street_input,
    $city_input,
    $state_input,
    $pincode_input,

    $phone_input,
    $email_input,
    $password_input,
    $confirm_input,
    $salary_input
);

$form->submit_button_text = "Add Staff";

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
                $user_type = "staff";
                $user_status = 1; 
                $password = password_hash($password_input->value,PASSWORD_DEFAULT);
                $stmt->bind_param("sssi",$email_input->value,$password,$user_type,$user_status);
                $stmt->execute();
                $stmt->close();

                $CUSOMTER_INSERT_SQL = "
                    INSERT INTO tbl_staff (
                        email,
                        staff_fname,
                        staff_lname,
                        staff_house_name,
                        staff_street,
                        staff_city,
                        staff_state,
                        staff_pincode,
                        staff_phone,
                        staff_salary
                    ) VALUES (?,?,?,?,?,?,?,?,?,?)
                ";
                $stmt = $db->prepare($CUSOMTER_INSERT_SQL);
                $stmt->bind_param("ssssssssss",
                    $email_input->value,
                    $fname_input->value,
                    $lname_input->value,
                    $house_name_input->value,
                    $street_input->value,
                    $city_input->value,
                    $state_input->value,
                    $pincode_input->value,
                    $phone_input->value,
                    $salary_input->value,
                );
                $stmt->execute();
                $stmt->close();
                $db->commit();
            } catch (mysqli_sql_exception $exception) {
                echo $exception; 
                $db->rollback();
            }
            redirect('/admin/staff/');
        }
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

$salary_input->render();

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


