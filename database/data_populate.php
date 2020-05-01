<?php
session_start();
require ('dbconfig.php');

$functionname = $_POST['function_name'];
switch ($functionname){
    case 'get_users':
        $users = get_users($_POST['user_role_id']);
        echo json_encode($users);
        break;
    case 'send_message':
        $senderid = $_SESSION['user']['id'];
        $receiverid = $_POST['receiverid'];
        $subject = $_POST['subject'];
        $content = $_POST['content'];
        $message = send_message($senderid, $receiverid, $subject, $content);
        echo json_encode($message);
//        echo json_encode(print_r($message));
        break;
    case 'get_messages':
        $messages = get_messages();
        echo json_encode($messages);
    default:
        break;
}

function get_users($userroleId){
    $users = array();
    $conn = get_new_connection();
    $sql = "SELECT u.*, ur.roleName FROM user u
            INNER JOIN userrole ur ON u.userRoleId = ur.id
            WHERE u.userRoleId = " . $userroleId . "
                AND u.username <> '" . $_SESSION['user_id'] . "'" ;


    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $users[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $users;
}

function send_message($senderid, $receiverid, $subject, $content){
    $message = null;
    $conn = get_new_connection();
    $sql = "INSERT INTO `university_platform`.`messages`
            (`subject`,
            `content`,
            `sentTime`,
            `senderId`,
            `receiverId`)
            VALUES("
        . "'" . $subject . "',"
        . "'" . $content . "',"
        . "'" . date('Y-m-d h:i:s') . "',"
        .  $senderid . ","
        .  $receiverid
        . ")";

    $inserted = mysqli_query($conn, $sql);

    if($inserted != null){
        $message = true;
    }else{
        $message = false;
    }
    mysqli_close($conn);
    return $message;
}

function get_messages(){
    $messages = array();
    $conn = get_new_connection();
    $sql = "SELECT m.*, u2.username AS receiver FROM messages m 
            INNER JOIN user u ON u.id = m.senderId 
            INNER JOIN user u2 ON u2.id = m.receiverId
            WHERE m.senderId = " . $_SESSION['id']  ;

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $messages[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $messages;
}