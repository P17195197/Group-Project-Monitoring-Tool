<?php
// Always start this first
session_start();
require('config.php');
require('database/user.php');

// Now check to see if they are logged in already
if(isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
}

// Login button pressed with details filled
if(isset($_POST['doRegister'])) {
    if (isset($_POST['username']) && isset($_POST['pass'])) {
        $username = $_POST['username'];
        $password = $_POST['pass'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $emailaddress = $_POST['emailaddress'];
        $phonenumber = $_POST['phonenumber'];
        $address = $_POST['address'];
        $userrole = $_POST["userrole"];

        if(register($username, $password, $firstname, $lastname, $emailaddress, $phonenumber, $address, $userrole) == null){
            $msg = 'Registration failed';
        }else{
            $msg = 'Successfully registered. Re-directing you to login page now...';
            header('refresh:3;url=index.php');
        }
    } else {
        $msg = 'Please fill all fields.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
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
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100 p-t-50 p-b-90">
            <form method="POST" class="login100-form validate-form flex-sb flex-w">
					<span class="login100-form-title p-b-51">
						Register
					</span>

                <div class="form-group" style="width: 100%">
                    <label for="userrole">Role</label>
                    <select class="form-control" id="userrole" name="userrole">
                        <option value="2">Tutor</option>
                        <option value="3">Student</option>
                    </select>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
                    <input class="input100" type="text" name="username" placeholder="Username">
                    <span class="focus-input100"></span>
                </div>


                <div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
                    <input class="input100" type="password" name="pass" placeholder="Password">
                    <span class="focus-input100"></span>
                </div>


                <div class="wrap-input100 validate-input m-b-16" data-validate = "First name is required">
                    <input class="input100" type="text" name="firstname" placeholder="First name">
                    <span class="focus-input100"></span>
                </div>


                <div class="wrap-input100 validate-input m-b-16" data-validate = "Last name is required">
                    <input class="input100" type="text" name="lastname" placeholder="Last name">
                    <span class="focus-input100"></span>
                </div>


                <div class="wrap-input100 validate-input m-b-16" data-validate = "Email address is required">
                    <input class="input100" type="text" name="emailaddress" placeholder="Email address">
                    <span class="focus-input100"></span>
                </div>


                <div class="wrap-input100 validate-input m-b-16" data-validate = "Phone number is required">
                    <input class="input100" type="text" name="phonenumber" placeholder="Phone number">
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-16" data-validate = "Address is required">
                    <input class="input100" type="text" name="address" placeholder="Address">
                    <span class="focus-input100"></span>
                </div>


                <div class="container-login100-form-btn m-t-17">
                    <button name="doRegister" class="login100-form-btn">
                        Register
                    </button>
                </div>

                <div class="result"><?php echo isset($_POST['doRegister']) ? $msg : ''; ?></div>

            </form>
        </div>
    </div>
</div>


<div id="dropDownSelect1"></div>

<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

</body>
</html>