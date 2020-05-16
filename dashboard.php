<?php
// Always start this first
session_start ();
require ( 'config.php' );
require ( 'helpers/auth.php' );
require ( './render_helpers.php' );
require ( './database/message.php' );
$user = check_auth ();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css"
          rel="stylesheet">

    <link href="css/main.css" rel="stylesheet">
</head>
<style type="text/css">
    .result {
        margin-top: 5%;
        padding: 5%;
        background: #eee;
        color: grey;
        text-align: center;
        width: 100%;
    }
</style>
<body id="page-top" class="styled-bg">

<?= render_navbar ( $user[ "roleName" ] ); ?>

<header class="bg-primary text-white connect-img">
    <div class="container text-center">
        <p class="lead"><?= $user[ 'roleName' ]; ?> dashboard page!</p>
        <h1>Welcome, <?= $user[ "firstName" ] . ' ' . $user[ "lastName" ]; ?>! </h1>
    </div>
</header>

<div class="container">
    <div class="row p-5 hidden">
        <div class="col-6">
            <div id="chat-contact-template">
                <div class="row chat-contact-item" id="contact-{user-id}">
                    <div class="col-3 chat-contact">
                        <div class="chat-contact-image">
                            <img src="images/user-profile.png" alt="{contact-username}">
                        </div>
                    </div>
                    <div class="col-9">
                        <h7>{contact-name}</h7>
                        <span class="last-message-date">{last-message-time}</span>
                        <p class="chat-preview">
                            {last-message}
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-6">
            <div id="incoming-message-template" class="hidden">
                <div class="row incoming-message" id="message-{message_id}">
                    <div class="col-1">
                        <div class="incoming-message-avatar">
                            <img src="./images/user-profile.png" alt="{username}">
                        </div>
                    </div>
                    <div class="col-11 incoming-message-text">
                        <div class="incoming-message-span">
                            <p>{message-text}</p>
                            <span class="message-time">
                                {message-time}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="outgoing-message-template" class="hidden">
                <div class="row outgoing-message" id="message-{message_id}">
                    <div class="col-11 outgoing-message-text">
                        <div class="outgoing-message-span">
                            <p>{message-text}</p>
                            <span class="message-time">
                                {message-time}
                            </span>
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="outgoing-message-avatar hidden">
                            <img src="./images/user-profile.png" alt="{username}">
                        </div>

                    </div>
                </div>
            </div>

        </div>


    </div>
    <div class="row p-5">
        <div class="row chat-area">


        <div class="col-md-6 col-lg-6 chat-contacts">
            <input type="hidden" id="current-user" value="<?php echo ( $_SESSION[ "user_id" ] ) ?>">
            <input type="hidden" id="current-user-id" value="<?php echo ( $_SESSION[ "id" ] ) ?>">
            <input type="hidden" id="selected-user">
            <input type="hidden" id="selected-user-id">
            <div class="chat-recent">
                <div class="chat-recent-heading">
                    <h4>Recent Chats</h4>
                </div>
            </div>
            <div id="contact-list">

            </div>
        </div>


        <div class="col-md-6 col-lg-6 chat-box">
            <div class="chat-window">
                <div id="chat-window">

                </div>
            </div>
            <div class="chat-type">
                <div class="input-message">
                    <input type="text" class="write-message" id="chat-message-input" placeholder="Write your message">
                    <button type="button" id="chat-send-message" class="send-button">
                        <i class="fa fa-paper-plane-o"></i>
                    </button>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div class="row p-5">
        <div class="row w-100">
            <div class="col-md-6 col-lg-6 b-shadow p-4"><h4>Want to start a conversation?</h4>
                <form id="contact-students" role="form">

                    <div class="messages"></div>

                    <div class="controls">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-error has-danger">
                                    <label for="receiverrole">Whom do you want to contact? *</label>
                                    <select id="receiverrole" name="receiverrole" class="form-control" required="required"
                                            data-error="Please select a role.">
                                        <option value="" selected disabled>Select receiver role</option>
                                        <option value="2">Tutor</option>
                                        <option value="3">Student</option>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group has-error has-danger">
                                    <label for="receivinguser">Select the user you want to contact *</label>
                                    <select id="receivinguser" name="receivinguser" class="form-control" required="required"
                                            data-error="Please select a student.">
                                        <option value=""></option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="messagesubject">Subject *</label>
                                    <input id="messagesubject" type="text" name="messagesubject" class="form-control"
                                           placeholder="Please enter a subject *" required="required"
                                           data-error="Subject is required.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_message">Message *</label>
                                    <textarea id="form_message" name="message" class="form-control"
                                              placeholder="Your message" rows="4" required="required"
                                              data-error="Please, leave us a message."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <input type="submit" id="send-message" class="btn btn-success btn-send disabled"
                                       value="Send message">
                            </div>

                            <div class="col-md-12 pt-2">
                                <div class="alert alert-success hidden" id="message-status-success">
                                    <strong>Success!</strong> Your message is sent.</a>.
                                </div>
                            </div>
                            <div class="col-md-12 pt-2">
                                <div class="alert alert-danger hidden" id="message-status-failure">
                                    <strong>Failed!</strong> There was an error sending your message. Please try later.
                                </div>
                            </div>
                        </div>

                    </div>

                </form>
            </div>

        </div>


    </div>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Uni Project</p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="./vendor/jquery/jquery.min.js"></script>
<script src="./vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="./vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom JavaScript for this theme -->
<script src="./js/scrolling-nav.js"></script>
<script src="./js/jquery.dataTables.min.js"></script>

<script src="./js/common.js"></script>
<script src="./js/scripts.js"></script>

</body>
</html>