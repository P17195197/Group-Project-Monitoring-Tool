<?php
session_start();
require ('dbconfig.php');

$functionname = $_POST['function_name'];
switch ($functionname){
    case 'get_users':
        $users = get_users($_POST['user_role_id']);
        echo json_encode($users);
        break;
    case 'get_contacted_users':
        $contacts = get_contacted_users ();
        echo  json_encode ($contacts);
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
        $user_id = $_POST["user_id"];
        $messages = get_messages($user_id);
        echo json_encode($messages);
        break;
    case 'get_articles':
        $articles = get_articles ();
        echo json_encode ($articles);
        break;
    case 'post_article':
        $title = $_POST["title"];
        $content = $_POST["content"];
        $article = post_article ($title, $content);
        echo json_encode ($article);
        break;
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

function get_contacted_users(){
    $contacts = array();
    $conn = get_new_connection();
    $sql = "SELECT CONCAT(u.firstName, ' ', u.lastName) AS contactName, 
                    u.id,
                    u.username, 
                    u.avatar, 
                    u.onlineStatus 
            FROM user u WHERE id IN (
                SELECT DISTINCT userId FROM 
                (
                    SELECT DISTINCT senderId AS userId FROM messages WHERE senderId = " . $_SESSION["id"] . " OR receiverId = " . $_SESSION["id"] . "
                    UNION
                    SELECT DISTINCT receiverId AS userId FROM messages WHERE senderId = " . $_SESSION["id"] . " or receiverId = " . $_SESSION["id"] . "
                ) distinctUsers
                WHERE userId <> " . $_SESSION["id"] .
            ");";

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $contacts[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $contacts;
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

function get_messages($user_id){
    $messages = array();
    $conn = get_new_connection();
    $sql = "SELECT m.*, u1.username AS sender, u2.username AS receiver FROM messages m
                INNER JOIN user u1 ON u1.id = m.senderId
                INNER JOIN user u2 ON u2.id = m.receiverId
            WHERE (m.senderId = " . $user_id . " and m.receiverId = " . $_SESSION["id"] . ")
                OR (m.senderId = " . $_SESSION["id"] . " and m.receiverId = " . $user_id .")
            ORDER BY m.sentTime ASC;";

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


function post_article($title, $content){
    $conn = get_new_connection();
    $sql = "INSERT INTO `university_platform`.`articles`
            (`authorId`, 
            `title`, 
            `content`, 
            `createdDate`)
            VALUES (" .
                "'" . $_SESSION["id"] . "'," .
                "'" . $title . "'," .
                "'" . $content . "'," .
                "NOW()" .
                ")";

    $inserted = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if($inserted != null){
        return true;
    }
    return false;
}

function get_articles(){
    $articles = array();
    $conn = get_new_connection();
    $sql = "SELECT a.*, CONCAT(u.firstName, ' ', u.lastName) AS authorName FROM articles a
	        INNER JOIN user u ON a.authorId = u.id";

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $articles[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $articles;
}