<?php
	// Always start this first
	session_start();
    require ('database/user.php');
    logout($_SESSION["user_id"]);
    // Destroying the session clears the $_SESSION variable, thus "logging" the user
    // out. This also happens automatically when the browser is closed
    session_destroy();
	header('Location: index.php');

?>