<!--------w-----------

    Project : Web  Development 2
    Name: Jiajia Yang
    Date: 2023-08-25
    Description: Project of Web  Development 2 based on web development 1 project 4 ----Sign UP

--------------------->
<?php
    require('connect.php');

    $errors = [];

    function checkExistedEmail($email) {
        global $db;
        $query = "SELECT email FROM reflective_co WHERE email = :email";
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        //sanitize input
        $select = filter_input(INPUT_POST, 'select', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $as = filter_input(INPUT_POST, 'As', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userName = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password1', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $rePassword = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fullName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $gender= filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $companyName = filter_input(INPUT_POST, 'company', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $category = filter_input(INPUT_POST, 'catagory', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $contactNumber = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // validate all inputs , if any fails, throw an error.
        if (empty($select) || empty($as) ||
            empty($userName) || empty($email) ||
            empty($fullName) || empty($gender) ||
            empty($companyName) || empty($category) ||
            empty($contactNumber) || empty($location)) {

            $errors[] = "Blank with * required content.";

        }

        if (strlen($userName) < 1 || strlen($fullName) < 1 || strlen($companyName) < 1
                    || strlen($category) < 1 || strlen($location) < 1) {

            $errors[] ="All inputs must have at least 1 character.";

        }
        if ($email === false) {
            $errors[] ="Invalid email address.";

        }
        if ($password !== $rePassword) {
            $errors[] = "Password does not match.";

        }
        if (strlen($password) < 8) {
            $errors[] = "Password must have at least 8 characters.";

        }
        if (strlen($contactNumber) < 10) {
            $errors[] = "Contact number must have at least 10 digits.";

        }
        if (checkExistedEmail($email)){
            $errors[] = "User already exists, please try another one. Or you can login directly.";

        }

        //use password_hash() to hash the password
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO reflective_co (select_user, as_user, user_name, email, 
                           password, full_name, gender, company_name, industrial_category, 
                           contact_number, location) VALUES (:select, :as, :userName, :email, 
                                                             :password, :fullName, :gender, 
                                                             :companyName, :category, 
                                                             :contactNumber, :location)";
        $statement = $db->prepare($query);

        $statement->bindValue(':select', $select, PDO::PARAM_STR);
        $statement->bindValue(':as', $as,PDO::PARAM_STR);
        $statement->bindValue(':userName', $userName,PDO::PARAM_STR);
        $statement->bindValue(':email', $email,PDO::PARAM_STR);
        $statement->bindValue(':password', $password,PDO::PARAM_STR);
        $statement->bindValue(':fullName', $fullName,PDO::PARAM_STR);
        $statement->bindValue(':gender', $gender,PDO::PARAM_STR);
        $statement->bindValue(':companyName', $companyName,PDO::PARAM_STR);
        $statement->bindValue(':category', $category,PDO::PARAM_STR);
        $statement->bindValue(':contactNumber', $contactNumber,PDO::PARAM_STR);
        $statement->bindValue(':location', $location,PDO::PARAM_STR);

        $statement->execute();
        header("Location: login.php");
        exit();

    }



?>



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

        <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">Sign Up</div>
                    <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="login.php">Log In</a></div>
                </div>

                <div>
                    <?php if (!empty($errors)): ?>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li>ERROR: <?php echo $error; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>


                <div class="panel-body" >
                        <form  class="form-horizontal" method="post" >
                            <input type='hidden' name='csrfmiddlewaretoken' value='XFe2rTYl9WOpV8U6X5CfbIuOZOELJ97S' />
                            <div id="div_id_select" class="form-group required">
                                <label for="id_select"  class="control-label col-md-4  requiredField"> Select<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 "  style="margin-bottom: 10px">
                                    <label class="radio-inline"><input type="radio" checked="checked" name="select" id="id_select_1" value="Buyer"  style="margin-bottom: 10px">Buyer</label>
                                    <label class="radio-inline"> <input type="radio" name="select" id="id_select_2" value="Partner"  style="margin-bottom: 10px">Partner </label>
                                </div>
                            </div>
                            <div id="div_id_As" class="form-group required">
                                <label for="id_As"  class="control-label col-md-4  requiredField">As<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 "  style="margin-bottom: 10px">
                                    <label class="radio-inline"> <input type="radio" name="As" id="id_As_1" value="I"  style="margin-bottom: 10px">Individual </label>
                                    <label class="radio-inline"> <input type="radio" name="As" id="id_As_2" value="CI"  style="margin-bottom: 10px">Company/Institute </label>
                                </div>
                            </div>
                            <div id="div_id_username" class="form-group required">
                                <label for="id_username" class="control-label col-md-4  requiredField"> Username<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md  textinput textInput form-control" id="id_username" maxlength="30" name="username" placeholder="Choose your username" style="margin-bottom: 10px" type="text" />
                                </div>
                            </div>
                            <div id="div_id_email" class="form-group required">
                                <label for="id_email" class="control-label col-md-4  requiredField"> E-mail<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md emailinput form-control" id="id_email" name="email" placeholder="Your current email address" style="margin-bottom: 10px" type="email" />
                                </div>
                            </div>
                            <div id="div_id_password1" class="form-group required">
                                <label for="id_password1" class="control-label col-md-4  requiredField">Password<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md textinput textInput form-control" id="id_password1" name="password1" placeholder="Create a password" style="margin-bottom: 10px" type="password" />
                                </div>
                            </div>
                            <div id="div_id_password2" class="form-group required">
                                <label for="id_password2" class="control-label col-md-4  requiredField"> Re:password<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md textinput textInput form-control" id="id_password2" name="password2" placeholder="Confirm your password" style="margin-bottom: 10px" type="password" />
                                </div>
                            </div>
                            <div id="div_id_name" class="form-group required">
                                <label for="id_name" class="control-label col-md-4  requiredField"> full name<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md textinput textInput form-control" id="id_name" name="name" placeholder="Your Frist name and Last name" style="margin-bottom: 10px" type="text" />
                                </div>
                            </div>
                            <div id="div_id_gender" class="form-group required">
                                <label for="id_gender"  class="control-label col-md-4  requiredField"> Gender<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 "  style="margin-bottom: 10px">
                                    <label class="radio-inline"> <input type="radio" name="gender" id="id_gender_1" value="M"  style="margin-bottom: 10px">Male</label>
                                    <label class="radio-inline"> <input type="radio" name="gender" id="id_gender_2" value="F"  style="margin-bottom: 10px">Female </label>
                                </div>
                            </div>
                            <div id="div_id_company" class="form-group required">
                                <label for="id_company" class="control-label col-md-4  requiredField"> company name<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md textinput textInput form-control" id="id_company" name="company" placeholder="your company name" style="margin-bottom: 10px" type="text" />
                                </div>
                            </div>
                            <div id="div_id_catagory" class="form-group required">
                                <label for="id_catagory" class="control-label col-md-4  requiredField"> catagory<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md textinput textInput form-control" id="id_catagory" name="catagory" placeholder="Industrial catagory" style="margin-bottom: 10px" type="text" />
                                </div>
                            </div>
                            <div id="div_id_number" class="form-group required">
                                <label for="id_number" class="control-label col-md-4  requiredField"> contact number<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md textinput textInput form-control" id="id_number" name="number" placeholder="provide your number" style="margin-bottom: 10px" type="text" />
                                </div>
                            </div>
                            <div id="div_id_location" class="form-group required">
                                <label for="id_location" class="control-label col-md-4  requiredField"> Your Location<span class="asteriskField">*</span> </label>
                                <div class="controls col-md-8 ">
                                    <input class="input-md textinput textInput form-control" id="id_location" name="location" placeholder="Your Pincode and City" style="margin-bottom: 10px" type="text" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="controls col-md-offset-4 col-md-8 ">
                                    <div id="div_id_terms" class="checkbox required">
                                        <label for="id_terms" class=" requiredField">
                                            <input class="input-ms checkboxinput" id="id_terms" name="terms" style="margin-bottom: 10px" type="checkbox" />
                                            Agree with the terms and conditions
                                        </label>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="aab controls col-md-4 "></div>
                                <div class="controls col-md-8 ">
                                    <input type="submit" name="Signup" value="Sign Up" class="btn btn-primary btn btn-info" id="submit-id-signup" />

                                </div>
                            </div>

                        </form>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="footer">
        <?php include('footer.php'); ?>
    </div>

</body>
</html>