<?php
$Title = 'Sign In | Hardware World'; 
include("../config/all_config.php"); 
include("../lib/all_lib.php");
include("../partials/header.php"); 
?>

<div class="form-main">
<h1> Sign in </h1>
<br>

<?php
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

$form = new Form($email_input,$password_input);
$form->submit_button_text = "Login";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($form->validate()){
        // fetch user from database
        $stmt = $db->prepare("SELECT * FROM tbl_login WHERE email = ?");
        $stmt->bind_param("s", $email_input->value);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if(!$user){
            array_push($email_input->errors,"No such account exists!");
        } else 
        if(!password_verify($password_input->value,$user['password'])){
            array_push($password_input->errors,"Wrong Password!");
        } else {
            $_SESSION['user'] = $user;
            if($user['type'] == "admin") {
                redirect('/admin/customers');
            } else {
                redirect('/site/products');
            }
        }
    }
}
$form->render();
?>
</div>

