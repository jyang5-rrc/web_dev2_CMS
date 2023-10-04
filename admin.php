<?php
    require ('util.php');
    require ('connect.php');

    session_start();
    global $db;

    //check if user is already logged in
    if(isset($_SESSION['role'])){
        header("Location: admin-cms.php");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!isset($_SESSION['user_id'])){
            util::jsonError('Please Login first.');
        }

        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(empty($password)) {
            util::jsonError('Password is required.');
        }

        if($password === 'employee'){

            $role = 'employee';

            $query = "UPDATE reflective_co SET role = :role WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':role', $role, PDO::PARAM_STR);
            $statement->bindValue(':id', $_SESSION['user_id'], PDO::PARAM_INT);
            $statement->execute();



            $_SESSION['role'] = $role;

            util::jsonSuccess('You are now an employee.');

//            header("Location: admin-cms.php");
//            exit();

        }else{
            util::jsonError('Password is incorrect.');
        }


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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</head>
<body>
<div id="nav">
    <?php include('nav.php'); ?>
</div>

<div class="container">
    <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <div class="panel panel-info" >
            <div class="panel-heading">
                <div class="panel-title">Admin</div>
            </div>

            <div style="padding-top:30px" class="panel-body" >

                <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                <form id="loginform" class="form-horizontal" role="form"  method="post">


                    <div style="margin-bottom: 25px" class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                    </div>


                    <div style="margin-top:10px" class="form-group">
                        <!-- Button -->

                        <div class="col-sm-12 controls">
                            <button type="submit" class="btn btn-success">Check</button>

                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-md-12 control">
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                Please Login first!
                                <a href="login.php">
                                    Log In Here
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

<script>
    // login form submit
    $('#loginform').submit(function (event) {
        event.preventDefault();
        const data = new FormData($('#loginform')[0]);
        console.log(data);

        $.ajax({
            type: 'POST',
            url: 'admin.php',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                alert(response.message);
                window.location.href = 'admin-cms.php';
            }
        });
    });
</script>
</body>
</html>
