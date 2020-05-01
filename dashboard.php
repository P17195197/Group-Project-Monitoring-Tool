<?php
	// Always start this first
	session_start();
	require('config.php');
	require('helpers/auth.php');
	require('./render_helpers.php');
    require ('./database/message.php');
    $user = check_auth();


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
<body id="page-top">

<?=render_navbar($user["roleName"]); ?>

  <header class="bg-primary text-white">
    <div class="container text-center">
      <p class="lead"><?=$user['roleName'];?> dashboard page!</p>
      <h1>Welcome, <?=$user["firstName"] . ' ' . $user["lastName"];?>! </h1>
    </div>
  </header>

  <div class="container">
    <div class="row p-5">
        <div class="col-md-6 col-lg-6"> <h4>Your message history</h4>
            <table id="messagehistory" class="display" style="width:100%">
                <thead>
                <tr>
                    <th>Receiver</th>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Content</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Receiver</th>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Content</th>
                </tr>
                </tfoot>
            </table>
        </div>

        <div class="col-md-6 col-lg-6"> <h4>Talk to people from your institution</h4>
          <form id="contact-students" method="post" action="messages.php" role="form" novalidate="true">

              <div class="messages"></div>

              <div class="controls">

                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group has-error has-danger">
                              <label for="receiverrole">Whom do you want to contact? *</label>
                              <select id="receiverrole" name="receiverrole" class="form-control" required="required" data-error="Please select a role.">
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
                              <select id="receivinguser" name="receivinguser" class="form-control" required="required" data-error="Please select a student.">
                                  <option value=""></option>
                              </select>

                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="messagesubject">Subject *</label>
                              <input id="messagesubject" type="text" name="messagesubject" class="form-control" placeholder="Please enter a subject *" required="required" data-error="Subject is required.">
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="form_message">Message *</label>
                              <textarea id="form_message" name="message" class="form-control" placeholder="Your message" rows="4" required="required" data-error="Please, leave us a message."></textarea>
                              <div class="help-block with-errors"></div>
                          </div>
                      </div>
                      <div class="col-md-12">
                          <input type="button" id="send-message" class="btn btn-success btn-send disabled" value="Send message">
                      </div>

                      <div class="col-md-12 pt-2">
                          <div class="alert alert-success invisible" id="message-status-success">
                              <strong>Success!</strong> Your message is sent.</a>.
                          </div>
                      </div>
                      <div class="col-md-12 pt-2">
                          <div class="alert alert-danger invisible" id="message-status-failure">
                              <strong>Failed!</strong> There was an error sending your message. Please try later.
                          </div>
                      </div>
                  </div>

              </div>

          </form>
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

<script src="./js/scripts.js"></script>

</body>
</html>