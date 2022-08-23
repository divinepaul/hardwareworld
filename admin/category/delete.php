<?php
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 
check_auth_redirect_if_not();
check_role_or_redirect("staff","admin");
include("../../partials/dashboard_header.php"); 

if(!isset($_GET['id'])){
    redirect('/admin/category/');
}
if(empty($_GET['id'])){
    redirect('/admin/category/');
}
if(!is_numeric($_GET['id'])){
    redirect('/admin/category/');
}

$id = $_GET['id'];

$stmt = $db->prepare("SELECT * FROM tbl_category WHERE category_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
if($user['status'] == 1){
    $stmt = $db->prepare("UPDATE tbl_category SET status=0 WHERE category_id=?");
} else {
    $stmt = $db->prepare("UPDATE tbl_category SET status=1 WHERE category_id=?");
}
$stmt->bind_param("i",$id);
$stmt->execute();
redirect($_SERVER['HTTP_REFERER']);
?>

