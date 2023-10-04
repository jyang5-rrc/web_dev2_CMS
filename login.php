
<?php

require ('connect.php');
require ('util.php');
session_start();


    $errors = [];

    global $db;

    // if a user is already logged in, redirect to the home page
    if (isset($_SESSION['user_id'])) {
        header('Location: index.php');
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'username', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($username) && empty($email)) {
            util::jsonError('Username or email is required.');

        } elseif (empty($password)) {
            util::jsonError('Password is required.');
        } else {
            //check if the username or email exists in the database

            $query = "SELECT * FROM reflective_co WHERE user_name = :username OR email = :email";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username, PDO::PARAM_STR);
            $statement->bindValue(':email', $email, PDO::PARAM_STR);
            $statement->execute();
            $user = $statement->fetch(PDO::FETCH_ASSOC);


            //if user is not empty, then verify the password by comparing the password in database


            if ($user) {
                if (password_verify($password, $user['password'])) {

                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['user_name'];
                    $_SESSION['email'] = $user['email'];
                    header("Location: index.php");
                    exit();
                } else {
                    util::jsonError("Username or password is incorrect.");
                }
            } else {
                util::jsonError("Username or password is incorrect.");
            }
        }

//          header('Content-Type: application/json');
//          echo json_encode([
//              'message' => 'success',
//              'status' => 1,
//              'data' => []
//          ], JSON_THROW_ON_ERROR);
//          exit();
    }





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reflective® safeguard Fabric, Clothing & Accessories | Reflective®.ca</title>
    <link rel="stylesheet" type="text/css" href="signup.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
<div id="nav">
    <?php include('nav.php'); ?>
</div>

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info" >
                <div class="panel-heading">
                    <div class="panel-title">Log In</div>
                    <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                </div>

                <div style="padding-top:30px" class="panel-body" >

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form id="loginform" class="form-horizontal" role="form"  method="post">

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" value="" placeholder="username or email">
                        </div>

                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                        </div>

<!--                        <div>-->
<!--                            --><?php //if (!empty($errors)): ?>
<!--                            <ul>-->
<!--                                --><?php //foreach ($errors as $error): ?>
<!--                                <li>--><?php //echo $error; ?><!--</li>-->
<!--                                --><?php //endforeach; ?>
<!--                            </ul>-->
<!--                            --><?php //endif; ?>
<!--                        </div>-->


<!--                        <div class="input-group">-->
<!--                            <div class="checkbox">-->
<!--                                <label>-->
<!--                                    <input id="login-remember" type="checkbox" name="remember" value="1"> Remember me-->
<!--                                </label>-->
<!--                            </div>-->
<!--                        </div>-->


                        <div style="margin-top:10px" class="form-group">
                            <!-- Button -->

                            <div class="col-sm-12 controls">
<!--                                <a id="btn-login" href="#" class="btn btn-success">Login</a>-->
                                <button type="submit" class="btn btn-success">Login</button>

                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-md-12 control">
                                <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                    Don't have an account!
                                    <a href="signup.php">
                                        Sign Up Here
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>

    </div>

    <div id="footer">
        <?php include('footer.php'); ?>
    </div>

<!--    <script>-->
<!--        // bind the login form <a> to the submit event-->
<!--        $('#btn-login').on('click', function(e) {-->
<!--            // prevent the default action-->
<!--            e.preventDefault();-->
<!--            // serialize the form data-->
<!--            var formData = $('#loginform').serialize();-->
<!--            // make the ajax request to the server-->
<!--            $.ajax({-->
<!--                url: './login.php',-->
<!--                method: 'POST',-->
<!--                data: formData,-->
<!--                dataType: 'json'-->
<!--            })-->
<!--            .done(function(data) {-->
<!--                // if the response is a success, redirect to the home page-->
<!--                if (data.status) {-->
<!--                    window.location.href = './index.php';-->
<!--                } else {-->
<!--                    // otherwise, display the error message-->
<!--                    $('#login-alert').html(data.message).fadeIn();-->
<!--                }-->
<!--            })-->
<!--            .fail(function(xhr, status, error) {-->
<!--                // if the ajax request fails display the error message-->
<!--                $('#login-alert').html(error).fadeIn();-->
<!--            });-->
<!--        });-->
<!--    </script>-->
</body>
</html>
