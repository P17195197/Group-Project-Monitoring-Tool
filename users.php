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

<div class="container article-publish">
    <input type="hidden" id="user-role" value="<?php echo $user["roleName"] ?>">
    <input type="hidden" id="user-id" value="<?php echo $user["id"] ?>">
    <div class="row p-5 b-shadow">
        <div class="col-12">
            <h4>Users</h4>
            <div class="users-table table-responsive">
                <table id="users-table" class="table table-striped table-bordered" style="width: 100%">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Role</th>
                        <th>Online Status</th>
                        <th>Active Status</th>
                        <th>Id</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="col-md-12 pt-2">
                <div class="alert alert-success invisible" id="message-status-success">
                    <strong>Success!</strong> Updated user status.</a>.
                </div>
            </div>
            <div class="col-md-12 pt-2">
                <div class="alert alert-danger invisible" id="message-status-failure">
                    <strong>Failed!</strong> Unable to update user status.
                </div>
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
<script src="./js/users.js"></script>

</body>
</html>