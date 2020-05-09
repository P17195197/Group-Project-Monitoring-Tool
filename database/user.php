<?php
require ('dbconfig.php');
require ('chat_helpers.php');

/* Method to login with a username and password */
function login($username, $password){
    $user = null;
    $conn = get_new_connection();
    $sql = "SELECT u.*, ur.roleName FROM user u INNER JOIN userrole ur ON u.userRoleId = ur.id WHERE username = '" . $username . "'";
    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                if($row["password"] == md5($password)){
                    $user = $row;
                    update_online_status($conn, $username, 1);
                    break;
                }
            }
        }
    }
    mysqli_close($conn);
    return $user;
}

function get_user($userId){
    $user = null;
    $conn = get_new_connection();
    $sql = "SELECT * FROM user WHERE id = '" . $userId . "'";
    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                mysqli_close($conn);
                return $user;
            }
        }
    }
    mysqli_close($conn);
    return $user;
}

function register($username, $password, $firstname, $lastname, $emailaddress, $phonenumber, $address, $userrole){
    $user = null;
    $conn = get_new_connection();
    $sql = "INSERT INTO `university_platform`.`user`
            (`username`,
            `password`,
            `emailAddress`,
            `phoneNumber`,
            `firstName`,
            `lastName`,
            `address`,
            `registrationTime`,
            `isActive`,
            `userRoleId`)
            VALUES("
        . "'" . $username . "',"
        . "'" . md5($password) . "',"
        . "'" . $emailaddress . "',"
        . "'" . $phonenumber . "',"
        . "'" . $firstname . "',"
        . "'" . $lastname . "',"
        . "'" . $address . "',"
        . "'" . date('Y-m-d h:i:s') . "',"
        . 1 . ","
        . $userrole
        . ")";

    $inserted = mysqli_query($conn, $sql);
    if($inserted != null){
        $user = $username;
    }
    mysqli_close($conn);
    return $user;
}

function logout($username){
    $conn = get_new_connection();
    update_online_status($conn, $username, 0);
}