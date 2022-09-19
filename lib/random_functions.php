<?php
function redirect($url){
    header("Location: {$url}");
    die();
}

function isSidebarItemActive($url) {
    if(strpos($_SERVER['REQUEST_URI'],$url) !== false){
        return "active";
    } else {
        return " ";
    }
}

function getProductStock($id) {
    global $db;
    $stmt = $db->prepare("SELECT 
        *
        FROM tbl_purchase_child
        INNER JOIN tbl_purchase_master
        ON tbl_purchase_child.purchase_master_id = tbl_purchase_master.purchase_master_id
        WHERE product_id = ?
        ORDER BY date_added"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $purchases = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    if(!$purchases){
        return 0;
    }

    $stmt = $db->prepare("SELECT 
        count(*) as total_purchase
        FROM tbl_payment 
        INNER JOIN tbl_order
            ON tbl_payment.order_id = tbl_order.order_id
        INNER JOIN tbl_cart_master
            ON tbl_order.cart_master_id = tbl_order.cart_master_id
        INNER JOIN tbl_cart_child
            ON tbl_cart_master.cart_master_id = tbl_cart_child.cart_master_id
        WHERE product_id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $totalOrdered = $stmt->get_result()->fetch_assoc()['total_purchase'];

    $currentPurchase;

    foreach ($purchases as $key => $purchase) {

        if($totalOrdered < $purchase['quantity']){
            $currentPurchase = $purchase;
            break;
        } else {
            $totalOrdered -= $purchase['quantity'];
        }

    }
    return $currentPurchase['quantity'] - $totalOrdered;
}

function getProductPrice($id) {
    global $db;
    $stock = getProductStock($id);
    if($stock){
        $stmt = $db->prepare("SELECT 
            *
            FROM tbl_purchase_child
            INNER JOIN tbl_purchase_master
            ON tbl_purchase_child.purchase_master_id = tbl_purchase_master.purchase_master_id
            WHERE product_id = ?
            ORDER BY date_added"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $purchases = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

         $stmt = $db->prepare("SELECT 
            count(*) as total_purchase
            FROM tbl_payment 
            INNER JOIN tbl_order
                ON tbl_payment.order_id = tbl_order.order_id
            INNER JOIN tbl_cart_master
                ON tbl_order.cart_master_id = tbl_order.cart_master_id
            INNER JOIN tbl_cart_child
                ON tbl_cart_master.cart_master_id = tbl_cart_child.cart_master_id
            WHERE product_id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $totalOrdered = $stmt->get_result()->fetch_assoc()['total_purchase'];

        $currentPurchase;

        foreach ($purchases as $key => $purchase) {

            if($totalOrdered < $purchase['quantity']){
                $currentPurchase = $purchase;
                break;
            } else {
                $totalOrdered -= $purchase['quantity'];
            }

        }
        return $currentPurchase['selling_price'];
    }
}

?>
