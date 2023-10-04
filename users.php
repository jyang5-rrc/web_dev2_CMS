<?php
require ('connect.php');
require ('admin-check.php');
require ('util.php');

global $db;

//add new user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //check if the user is posted
    if ($action === 'add-user') {
        //check if the user name is empty
        if (empty($_POST['add-user'])) {
            util::jsonError("user name is required.");
        }
        $user_name = filter_input(INPUT_POST, 'add-user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//        var_dump($user_name);
        $sql = "INSERT INTO reflective_co (user_name) VALUES (:user_name)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':user_name', $user_name);

        try {
            $result = $statement->execute();
//            var_dump($result);
            if (!$result) {
                util::jsonError("user added failed.");
            }
        } catch (Exception $e) {
            util::jsonError("user already exists");
        }


        util::jsonSuccess("user added successfully.");
    }

    //update user
    if ($action === 'edit-user') {


        $user_name = filter_input(INPUT_POST, 'edit-user-name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $role = filter_input(INPUT_POST, 'edit-user-role', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //filtter the email
        $email = filter_input(INPUT_POST, 'edit-user-email', FILTER_SANITIZE_EMAIL);
        //filtter the password
        $password = filter_input(INPUT_POST, 'edit-user-password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //if email and password is empty, util error
        if ($email === ''){
            util::jsonError("email is required.");
        }
        //hash password
        $password = password_hash($password, PASSWORD_DEFAULT);

        //retrive the data from database
        $sql = "SELECT * FROM reflective_co WHERE id = :id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $user = $statement->fetch();

        //check if the user is exist
        if (!$user) {
            util::jsonError("user not found.");
        }

        //check if the user name is changed
        if ($user['user_name'] !== $user_name) {
            //check if the user name is exist in database
            $sql = "SELECT * FROM reflective_co WHERE user_name = :user_name";
            $statement = $db->prepare($sql);
            $statement->bindValue(':user_name', $user_name);
            $statement->execute();
            $result = $statement->fetch();

            if ($result) {
                util::jsonError("user already exists");
            }

            //if the user name is not exist, update the user name

            $sql = "UPDATE reflective_co SET user_name = :user_name WHERE id = :id";
            $statement = $db->prepare($sql);
            $statement->bindValue(':user_name', $user_name);
            $statement->bindValue(':id', $id);
            try {
                $result = $statement->execute();
                if (!$result) {
                    util::jsonError("user edit failed.");
                }
            } catch (Exception $e) {
                util::jsonError("user already exists");
            }

        }

        //check if the role is changed
        if ($user['role'] !== $role) {
            //update the role
            $sql = "UPDATE reflective_co SET role = :role WHERE id = :id";
            $statement = $db->prepare($sql);
            $statement->bindValue(':role', $role);
            $statement->bindValue(':id', $id);
            try {
                $role = $statement->execute();
                if (!$role) {
                    util::jsonError("user edit failed.");
                }
            } catch (Exception $e) {
                util::jsonError("user already exists");
            }


        }

        //check if the email is changed
        if ($user['email'] !== $email) {
            //check if the email is exist in database
            $sql = "SELECT * FROM reflective_co WHERE email = :email";
            $statement = $db->prepare($sql);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $result = $statement->fetch();

            if ($result) {
                util::jsonError("user already exists");
            }

            //if the email is not exist, update the email
            $sql = "UPDATE reflective_co SET email = :email WHERE id = :id";
            $statement = $db->prepare($sql);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':id', $id);
            try {
                $result = $statement->execute();
                if (!$result) {
                    util::jsonError("user edit failed.");
                }
            } catch (Exception $e) {
                util::jsonError("user already exists");
            }

        }

        //check if the password is set
        if ($password) {
            //update the password
            $sql = "UPDATE reflective_co SET password = :password WHERE id = :id";
            $statement = $db->prepare($sql);
            $statement->bindValue(':password', $password);
            $statement->bindValue(':id', $id);
            try {
                $result = $statement->execute();
                if (!$result) {
                    util::jsonError("user edit failed.");
                }
            } catch (Exception $e) {
                util::jsonError("user already exists");
            }

        }

        util::jsonSuccess("user edit successfully.");
    }


    //delete user
    if ($action === 'delete-user') {
        $user_name = filter_input(INPUT_POST, 'edit-user', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        // check if the id is exist in database
        $sql = "SELECT * FROM reflective_co WHERE id = :id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch();

        if (!$result) {
            util::jsonError("user not found.");
        }

        $sql = "DELETE FROM reflective_co WHERE id = :id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $id);
        try {
            $result = $statement->execute();
            if (!$result) {
                util::jsonError("user delete failed.");
            }
        } catch (Exception $e) {
            util::jsonError("user delete failed.");
        }
        util::jsonSuccess("user delete successfully.");


    }


}

//get all user
$sql = "SELECT * FROM reflective_co";
$statement = $db->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();






?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reflective® safeguard Fabric, Clothing & Accessories | Reflective®.ca</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="admin-cms.css">
    <!-- CSS and script from bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


</head>
<body>

<div class="container-fluid">
    <?php include('admin-nav-asider.php'); ?>
    <div class="col py-3">
        <!--display the product card with image and links for edit and delete -->
        <div class="container">
            <h3>User Mange</h3>
            <p>Here you can manage user's information.</p>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <form id="add-user" method="post">
                        <input type="hidden" name="action" value="add-user">
                        <input type="text" name="add-user" placeholder="Add a user name">
                        <input type="submit" name="submit" value="Add"  class="btn btn-primary">
                    </form>
                </li>
            </ul>
            <br>

            <!--table of user-->
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col" style="width: 15%; " id="sort-name-text">Role</th>
                    <th scope="col" style="width: 35%; " id="sort-name-text">User's Name</th>
                    <th scope="col" style="width: 20%" id="sort-create-time-text">E-mail</th>
                    <th scope="col" style="width: 15%">Action</th>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($result as $row):?>

                    <tr>
                        <td><?php echo $row['role']; ?></td>

                        <td><?php echo $row['user_name']; ?></td>

                        <td><?php echo $row['email']; ?></td>


                        <td>
                            <a href="#" style="padding-right: 20px" onclick="showEditModal(<?php echo $row['id']; ?>, '<?php echo $row['user_name']; ?>',
                                    '<?php echo $row['role']; ?>','<?php echo $row['email']; ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16" >
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                </svg>
                            </a>

                            <a href="#" onclick="DeleteItem(<?php echo $row['id']; ?>, '<?php echo $row['user_name']; ?>')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                    <!--modal-->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit user</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border: none;">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!--input for edit the original user name-->
                                    <form id="edit-user">
                                        <input type="hidden" name="action" value="edit-user">
                                        <label for="edit-user-name">Role:</label>
                                        <input type="text" name="edit-user-role" id="edit-user-role" value="" style="height: 35px;width: 300px;"><br>
                                        <label for="edit-user-name">User's name:</label>
                                        <input type="text" name="edit-user-name" id="edit-user-name" value="" style="height: 35px;width: 300px;" placeholder="Enter user's name"><br>
                                        <label for="edit-user-email">E-mail:    </label>
                                        <input type="email" name="edit-user-email" id="edit-user-email" value="" placeholder="Enter user's E-mail"><br>
                                        <label for="edit-user-password">Password:  </label>
                                        <input type="text" name="edit-user-password" id="edit-user-password" value="" style="height: 35px;width: 300px;" placeholder="Enter new password">
                                        <input type="hidden" name="id" id="edit-id" value="<?php echo $row['id']; ?>">
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" id="save-changes" class="btn btn-primary" style="width: 150px;">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach;?>
                </tbody>
            </table>






        </div>
    </div>
</div>


<script>
    // add user form submit
    $('#add-user').submit(function (event) {
        event.preventDefault();

        const data = new FormData($('#add-user')[0]);
        console.log(data);

        $.ajax({
            type: 'POST',
            url: 'users.php',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status === 1) {
                    alert(response.message);
                    window.location.href = "users.php";
                }
                alert(response.message);

            }
        });
    });


    // show edit modal with show function of bootstrap
    function showEditModal(id, name,role, email) {
        // set the value of input
        $('#edit-user-name').val(name);
        $('#edit-user-role').val(role);
        $('#edit-user-email').val(email);

        // set the value of hidden input
        $('#edit-id').val(id);
        $('#editModal').modal('show');
    }


    // edit user form submit
    //save change click event
    $('#save-changes').click(function (event) {
        event.preventDefault();
        //get the data from form
        const data = new FormData($('#edit-user')[0]);

        console.log(data);

        $.ajax({
            type: 'POST',
            url: 'users.php',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status === 1) {
                    alert(response.message);
                    window.location.href = "users.php";
                }
                alert(response.message);

            }
        });
    });

    //deleteItem function click event
    function DeleteItem(id, name) {
        const data = new FormData();
        data.append('action', 'delete-user');
        data.append('id', id);
        data.append('name', name);

        $.ajax({
            type: 'POST',
            url: 'users.php',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 1) {
                    alert(response.message);
                    window.location.href = "users.php";
                }
                alert(response.message);

            }
        });
    }













</script>

</body>
</html>

