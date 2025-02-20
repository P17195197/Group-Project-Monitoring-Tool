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
    <title>Articles</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/scrolling-nav.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.2.4/css/responsive.dataTables.min.css" rel="stylesheet">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
          rel = "stylesheet">

    <!--    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">-->
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

<div class="container test-publish">
    <div class="row p-5 b-shadow <?php echo $user['roleName'] == 'System Admin' || $user['roleName'] == 'Tutor' ? "" : "hidden"?>">
        <div class="hidden" id="choice-template">
            <div class="row">
                <div class="col-12">
                    <div class="test-add-answer">
                        <input type="text" class="form-control answer-choice" placeholder="Milestone name...">
                    </div>
                </div>

            </div>
        </div>
        <div id="test-question-template" class="test-question-template hidden">
            <div class="col-md-12 col-lg-12 question-template b-shadow" id="test-test-{test-id}">
                <div class="question">
                    <div class="form-group">
                        <label for="test-add-test">Project {test-id}*</label>
                        <input id="test-add-test-{test-id}" type="text" name="test-add-test" class="form-control" placeholder="What is the name of the project?" required="required" data-error="Need a valid name.">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group has-error has-danger">
                                <label for="test-class-{test-id}">Which group is this project for? *</label>
                                <select id="test-class-{test-id}" name="test-class-{test-id}" class="form-control" required="required" data-error="Please select a group.">
                                    <option value="" selected="" disabled="">Select Group</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group has-error has-danger">
                                <label for="test-date-{test-id}">Submission date? *</label>
                                <input type="text" id="test-date-{test-id}" name="test-date-{test-id}" class="form-control" required="required" data-error="Please select a date.">

                            </div>

                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="test-duration-{test-id}">Demo duration *</label>
                                <input id="test-duration-{test-id}" type="number" value="60" name="test-duration-{test-id}" class="form-control" placeholder="Duration is required *" required="required" data-error="Subject is required.">
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12">
                            <input type="button" id="add-topic-{test-id}" class="btn btn-success btn-send disabled add-choice"
                                   value="+ Add Milestone">
                        </div>
                        <div class="col-9" class="test-question-choice" id="choices-{test-id}">
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
                                    <div class="test-add-answer">
                                        <input type="text" class="form-control answer-choice" placeholder="Milestone name...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-12 test-questions" id="test-questions">

        </div>
        <div class="col-12 text-right">
            <input type="button" id="add-question" class="btn btn-success btn-send disabled"
                   value="+ Add Project">
            <input type="button" id="submit-form" class="btn btn-primary btn-send disabled" value="Submit">
        </div>
        <div class="col-md-12 pt-2">
            <div class="alert alert-success hidden" id="message-status-success">
                <strong>Success!</strong> Projects added successfully. Refresh page now.</a>.
            </div>
        </div>
        <div class="col-md-12 pt-2">
            <div class="alert alert-danger hidden" id="message-status-failure">
                <strong>Failed!</strong> There was an error adding the projects. Please try later.
            </div>
        </div>


    </div>
    <div class="row p-5 p-t-6 mt-5 mb-5 b-shadow">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h4 class="pt-4">Scheduled projects</h4>
            <div class="table-responsive">
                <table id="tests-table" style="width: 100%" class="table table-striped table-bordered" >
                    <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Group</th>
                        <th>Submission Date</th>
                        <th>Demo Duration</th>
                        <th>Milestones</th>
                    </tr>
                    </thead>
                </table>
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
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<!-- Plugin JavaScript -->
<script src="./vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom JavaScript for this theme -->
<script src="./js/scrolling-nav.js"></script>
<script src="./js/jquery.dataTables.min.js"></script>
<script src="./js/common.js"></script>
<script src="js/projects.js"></script>

</body>
</html>