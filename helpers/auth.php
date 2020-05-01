<?php

function check_auth(){
    if(!isset($_SESSION['user_id'])) {
        session_destroy();
        header('Location: index.php');
    } else {
        return $_SESSION['user'];
    }
    return null;
}
