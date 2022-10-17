<?php

class Message {
    public static function add($tag,$message){
        if(!isset($_SESSION['messages'])){
            $_SESSION['message'] = array($tag => $message);
        } else {
            $_SESSION['message'][$tag] = $message;
        }
    }
    public static function show($tag,$message){
        if(!isset($_SESSION['messages'])){
            return; 
        }
        foreach ($_SESSION['messages'] as $tag => $message) {

        }
    }
}

?>
