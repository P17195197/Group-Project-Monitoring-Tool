<?php
// Always start this first
session_start();
require('./../config.php');
require('./../helpers/auth.php');
require('./../helpers/render_helpers.php');

$user = check_auth();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="./../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./../css/scrolling-nav.css" rel="stylesheet">
    <link href="./../css/jquery.dataTables.min.css" rel="stylesheet">
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

<h1> This is articles page</h1>

<?=render_footer(); ?>
</body>
</html>
