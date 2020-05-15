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
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
          rel = "stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
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
<body id="page-top">

<?= render_navbar ( $user[ "roleName" ] ); ?>

<div class="container test-publish">
    <div class="row p-5">
        <div class="hidden" id="choice-template">
            <div class="row">
                <div class="col-11">
                    <div class="test-add-answer">
                        <input type="text" class="form-control answer-choice" placeholder="Type choice and select if it is correct..">
                    </div>
                </div>
                <div class="col-1">
                    <input type="radio" name="correct-answer-{problem-id}" class="form-group answer-radio"
                           >
                </div>

            </div>
        </div>
        <div class="row w-100 pt-5 pl-4">
            <div class="col-4">
                <div class="form-group has-error has-danger">
                    <label for="problem-class">Select class *</label>
                    <select id="problem-class" name="problem-class" class="form-control" required="required" data-error="Please select a class.">
                        <option value="" selected="" disabled="">Select Class</option>
                    </select>
                </div>
            </div>

        </div>

        <div id="test-question-template" class="test-question-template hidden">
            <div class="col-md-12 col-lg-12 question-template" id="test-test-{problem-id}">
                <div class="question">
                    <div class="form-group">
                        <label for="test-add-test">Problem {problem-id}*</label>
                        <input id="add-problem-{problem-id}" type="text" name="test-add-test" class="form-control" placeholder="Write the problem statement here..." required="required" data-error="Need a valid problem.">
                        <div class="help-block with-errors"></div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <input type="button" id="add-topic-{problem-id}" class="btn btn-success btn-send disabled add-choice"
                                   value="+ Add Choice">
                        </div>
                        <div class="col-9" class="test-question-choice" id="choices-{problem-id}">
                            <div class="row">
                                <div class="col-11">
                                    <div class="test-add-answer">
                                        <input type="text" class="form-control answer-choice" placeholder="Type choice and select if it is correct...">

                                    </div>
                                </div>
                                <div class="col-1">
                                    <input type="radio" name="correct-answer-{problem-id}" class="form-group answer-radio"
                                           checked="checked">
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
                   value="+ Add Problem">
            <input type="button" id="submit-form" class="btn btn-primary btn-send disabled" value="Submit">
        </div>

    </div>

    <div class="row p-5">
        <div class="col-md-12 col-lg-12"> <h4>Problems</h4>
            <table id="problems-table" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Posted By</th>
                    <th>Posted on</th>
                    <th>Problem Statement</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <div id="dialog" title="Problem" class="modal-dialog hidden">
        <div class="statement">
            <h6 class="font-weight-bold">Problem Statement</h6>
            <div class="problem-statement">
                <p id="problem-statement-dialog"></p>
            </div>
        </div>
        <div class="choices pt-5">
            <h6 class="font-weight-bold">Choices</h6>
            <div class="answer-choices-dialog" id="answer-choices-dialog">

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>

<!-- Custom JavaScript for this theme -->
<script src="./js/scrolling-nav.js"></script>
<script src="./js/jquery.dataTables.min.js"></script>
<script src="./js/common.js"></script>
<script src="./js/problems.js"></script>

</body>
</html>