<?php
session_start();
require ('./../database/dbconfig.php');

if(isset($_GET['action'])){
    switch ($_GET['action']){
        case "getusers":
//            return json_encode(get_users($_GET['userRoleId'], $_GET['username']));
            return 'This is the response';
            break;
        default:
            break;
    }
}
//
//function get_users($user_role_id){
//    $users = array();
//    $conn = get_new_connection();
//    $sql = "SELECT u.*, ur.roleName FROM user u
//            INNER JOIN userrole ur ON u.userRoleId = ur.id
//            WHERE u.userRoleId = " . $user_role_id . "
//                AND u.username <> '" . $_SESSION['user_id'] . "'" ;
//
//
//    $result = mysqli_query($conn, $sql);
//    if($result != null){
//        if (mysqli_num_rows($result) > 0) {
//            while($row = mysqli_fetch_assoc($result)) {
//                $users[] = $row;
//            }
//        }
//    }
//    mysqli_close($conn);
//    return $users;
//}

