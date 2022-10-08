<?php
include("../../config/all_config.php"); 
include("../../lib/all_lib.php"); 

if(!isset($_GET['id'])){
    redirect('/site/products/');
}
if(empty($_GET['id'])){
    redirect('/site/products/');
}
if(!is_numeric($_GET['id'])){
    redirect('/site/products/');
}

$id = $_GET['id'];

$stmt = $db->prepare("SELECT product_image FROM tbl_product WHERE product_id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$image = $stmt->get_result()->fetch_assoc()['product_image'];

$stmt->close();

$image_name = "img.jpg";

header("Content-Disposition: attachment; filename=\"{$image_name}\""); 
header("Content-type: image/jpg");
//header("Content-Transfer-Encoding: base64"); 
header("Content-Length: ".strlen($image));

echo $image;
ob_flush();
die();

?>
