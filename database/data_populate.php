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
    case 'get_groups':
        $groups = get_groups();
        echo json_encode ($groups);
        break;
    case 'send_message':
        $senderid = $_SESSION['user']['id'];
        $receiverid = $_POST['receiverid'];
        $subject = $_POST['subject'];
        $content = $_POST['content'];
        $message = send_message($senderid, $receiverid, $subject, $content);
        echo json_encode($message);
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
    case 'add_projects':
        $projects = json_decode ($_POST['projects']);
        $added_projects = add_projects($projects);
        echo json_encode ($added_projects);
        break;
    case 'add_problems':
        $problems = json_decode ($_POST['problems']);
        $added_problems = add_problems($problems);
        echo json_encode ($added_problems);
        break;
    case 'get_problems':
        $group_id = $_POST["groupId"];
        $all_problems = get_problems($group_id);
        echo json_encode ($all_problems);
        break;
    case 'get_choices':
        $problem_id = $_POST['problemId'];
        $choices = get_choices($problem_id);
        echo json_encode ($choices);
        break;
    case 'get_students':
        $group_id = $_POST['groupId'];
        $students = get_students ($group_id);
        echo json_encode ($students);
        break;
    case 'enrol_in_group':
        $student_id = $_POST['studentId'];
        $group_id = $_POST['groupId'];
        $enrolled = enrol_in_group($student_id, $group_id);
        echo json_encode ($enrolled);
        break;
    case 'get_all_users':
        $users = get_all_users();
        echo json_encode ($users);
        break;
    case 'change_user_status':
        $user_id = $_POST['userId'];
        $active_status = $_POST['activeStatus'];
        echo json_encode (change_user_status($user_id, $active_status));
        break;
    case 'get_projects':
        $projects = get_projects();
        echo json_encode ($projects);
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
    $sql = "SELECT 	u1.id,
                    CONCAT(u1.firstName, ' ', u1.lastName) AS contactName,
                    u1.username, 
                    u1.avatar, 
                    u1.onlineStatus,
                    m.subject,
                    m.content,
                    m.sentTime,
                    m.senderId,
                    m.receiverId,
                    m.status
            FROM (SELECT DISTINCT userId FROM 
                        (
                           SELECT DISTINCT senderId AS userId 
                           FROM messages 
                           WHERE senderId = " . $_SESSION["id"] . " OR receiverId = " . $_SESSION["id"] . "
                           UNION
                           SELECT DISTINCT receiverId AS userId 
                           FROM messages 
                           WHERE senderId = " . $_SESSION["id"] . " or receiverId = " . $_SESSION["id"] . "
                           ) distinctUsers
                WHERE userId <> " . $_SESSION["id"] . ") u    
                    INNER JOIN user u1 ON u1.id = u.userId
                    INNER JOIN messages m ON 
                        ((m.senderId = u.userId AND m.receiverId = " . $_SESSION["id"] . ") OR (m.senderId = " . $_SESSION["id"] . " AND m.receiverId = u.userId)) 
                        AND m.sentTime = (	SELECT MAX(sentTime) FROM messages
                                            WHERE (senderId = u.userId AND receiverId= " . $_SESSION["id"] . ") OR
                                                (senderId = " . $_SESSION["id"] . " AND receiverId = u.userId)
                                            )";

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
    $sql = "INSERT INTO messages (subject, content, sentTime, senderId, receiverId)
            VALUES("
        . "'" . mysqli_real_escape_string($conn, $subject) . "',"
        . "'" . mysqli_real_escape_string($conn, $content) . "',"
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

function add_projects($projects){
    $conn = get_new_connection();
    $added = false;
    foreach($projects as $project){
        $sql = "INSERT INTO projects (projectName, projectDate, duration, groupId, milestones) VALUES("
            . "'" . $project->projectName . "',"
            . "'" . date('Y-m-d',strtotime($project->projectDate)) . "',"
            . "'" . $project->projectDuration . "',"
            .  $project->groupId . ","
            . "'" . $project->milestones . "'"
            . ")";
        $inserted = mysqli_query($conn, $sql);
        if($inserted != null){
            $added = true;
        }else{
            $added = false;
        }
    }
    mysqli_close($conn);
    return $added;
}

function add_problems($problems){
    //add problems
    //add choices
    $conn = get_new_connection();
    $added = false;

    foreach ($problems->problems as $problem){
        $sql = "INSERT INTO problems(statement, groupId, postedBy, postedDate) VALUES ("
                . "'" . $problem->statement . "',"
                . $problems->groupId . ","
                . $_SESSION['id'] . ","
                . "'" . date('Y-m-d h:i:s') ."'"
                . ");";
        $inserted = mysqli_query($conn, $sql);
        $problemId = mysqli_insert_id ($conn);
        if($inserted != null){
            $added = true;
        }else{
            $added = false;
        }
        foreach ($problem->choices as $choice ){
            $choice_sql = "INSERT INTO answers(answer, isCorrect, problemId) VALUES ("
                    . "'" . $choice->choice . "',"
                    . $choice->isCorrect . ","
                    . $problemId . ");";
            $choice_inserted = mysqli_query($conn, $choice_sql);
            if($choice_inserted != null){
                $added = true;
            }else{
                $added = false;
            }
        }
    }
    mysqli_close($conn);
    return $added;
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
	        INNER JOIN user u ON a.authorId = u.id
	        ORDER BY createdDate DESC";

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

function get_groups(){
    $groups = array();
    $conn = get_new_connection();
    $sql = "SELECT c.*,
                        CASE
                            WHEN e.id IS NULL THEN 0
                            ELSE 1
                        END AS enrolmentStatus
            FROM groups c
                LEFT JOIN enrolments e ON c.id = e.groupId
                AND studentId = " . $_SESSION["id"];

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $groups[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $groups;
}

function get_problems($group_id){
    $problems = array();
    $conn = get_new_connection();
    $sql = "SELECT p.*, CONCAT(u.firstName, ' ', u.lastName) AS userName, c.groupName FROM problems p
                INNER JOIN user u ON p.postedBy = u.id
                INNER JOIN groups c ON c.id = p.groupId
            WHERE c.id = " . $group_id . ";";

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $problems[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $problems;
}

function get_choices($problem_id){
    $choices = array();
    $conn = get_new_connection();
    $sql = "SELECT * FROM answers WHERE problemId = " . $problem_id . ";";

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $choices[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $choices;
}

function get_students($group_id){
    $students = array();
    $conn = get_new_connection();
    $sql = "SELECT e.*, CONCAT(u.firstName, ' ', u.lastName) AS userName FROM enrolments e
                INNER JOIN user u ON u.id = e.studentId
            WHERE e.groupId = " . $group_id;

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $students[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $students;
}

function enrol_in_group($student_id, $group_id){
    $conn = get_new_connection();
    $sql = "INSERT INTO enrolments(studentId, groupId, enrolledDate)
            VALUES ("
            . $student_id . ","
            . $group_id . ","
            . "'" . date('Y-m-d h:i:s') . "'"
            . ")";

    $inserted = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if($inserted != null){
        return true;
    }
    return false;
}

function get_all_users(){
    $users = array();
    $conn = get_new_connection();
    $sql = "SELECT u.id, u.username, u.firstName, u.lastName, u.onlineStatus, u.isActive, u.userRoleId, ur.roleName FROM user u
                INNER JOIN userrole ur ON ur.id = u.userRoleId 
            WHERE u.id <> " . $_SESSION['id'];

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

function change_user_status($user_id, $active_status){
    $conn = get_new_connection();
    $sql = "UPDATE user SET isActive = " . $active_status ." WHERE id = " . $user_id . ";";

    $updated = mysqli_query($conn, $sql);
    mysqli_close($conn);

    if($updated != null){
        return true;
    }
    return false;
}

function get_projects(){
    $projects = array();
    $conn = get_new_connection();
    $sql = "SELECT t.*, c.groupName FROM projects t
							INNER JOIN groups c ON C.id = t.groupId;";

    $result = mysqli_query($conn, $sql);
    if($result != null){
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $projects[] = $row;
            }
        }
    }
    mysqli_close($conn);
    return $projects;
}