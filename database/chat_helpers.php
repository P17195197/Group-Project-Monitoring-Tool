<?php

function update_online_status($conn, $username, $online_status){
    $sql = "UPDATE user SET onlineStatus = " . $online_status . " WHERE username = '" . $username . "';";
    $conn->query($sql);
}