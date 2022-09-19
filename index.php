<?php
$Title = 'Home | HardwareWorld'; 
include("./config/all_config.php"); 
include("./lib/all_lib.php"); 
include("./partials/header.php"); 

$stmt = $db->prepare("SELECT * FROM tbl_category ORDER BY status DESC");
$stmt->execute();
$categories = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

?>
<link rel="stylesheet" href="/static/css/home.css"> 
<div class="home-hero-section">
    <h1> HARD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WARE</h1>
    <h1 class="second-title">WORLD</h1>
    <img src="/static/img/hero.png">
    <br>
    <br>
    <br>
</div>

<?php

foreach ($categories as $category) {
    
    echo '<div class="category-container">';
        echo "<h1>{$category['category_name']}s</h1>";
    echo'</div>';

}
?>
<br>
<br>
