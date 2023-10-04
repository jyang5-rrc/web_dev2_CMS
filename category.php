<?php
require ('connect.php');
require ('admin-check.php');
require ('util.php');

global $db;


//add new category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    //check if the category is posted
    if ($action === 'add-category') {
        //check if the category name is empty
        if (empty($_POST['add-category'])) {
            util::jsonError("Category name is required.");
        }
        $category_name = filter_input(INPUT_POST, 'add-category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sql = "INSERT INTO category (category_name) VALUES (:category_name)";
        $statement = $db->prepare($sql);
        $statement->bindValue(':category_name', $category_name);
        try {
            $result = $statement->execute();
            if (!$result) {
                util::jsonError("Category added failed.");
            }
        } catch (Exception $e) {
            util::jsonError("Category already exists");
        }


        util::jsonSuccess("Category added successfully.");
    }

    //update category
    if ($action === 'edit-category') {
        //check if the category name is empty
        if (empty($_POST['edit-category'])) {
            util::jsonError("Category name is required.");
        }

        $category_name = filter_input(INPUT_POST, 'edit-category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        // check if the id is exist in database
        $sql = "SELECT * FROM category WHERE category_id = :id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch();

        if (!$result) {
            util::jsonError("Category not found.");
        }

        // check if the category name is changed
        if ($category_name === $result['category_name']) {
            util::jsonError("Category name not changed.");
        }

        $sql = "UPDATE category SET category_name = :category_name WHERE category_id = :id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':category_name', $category_name);
        $statement->bindValue(':id', $id);
        try {
            $result = $statement->execute();
            if (!$result) {
                util::jsonError("Category edit failed.");
            }
        } catch (Exception $e) {
            util::jsonError("Category already exists");
        }
        util::jsonSuccess("Category edit successfully.");
    }


    //delete category
    if ($action === 'delete-category') {
        $category_name = filter_input(INPUT_POST, 'edit-category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        // check if the id is exist in database
        $sql = "SELECT * FROM category WHERE category_id = :id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $result = $statement->fetch();

        if (!$result) {
            util::jsonError("Category not found.");
        }

        $sql = "DELETE FROM category WHERE category_id = :id";
        $statement = $db->prepare($sql);
        $statement->bindValue(':id', $id);
        try {
            $result = $statement->execute();
            if (!$result) {
                util::jsonError("Category delete failed.");
            }
        } catch (Exception $e) {
            util::jsonError("Category delete failed.");
        }
        util::jsonSuccess("Category delete successfully.");


    }


}

// check if the action sort
$sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        //retrive the category information from database
        $sql = "SELECT * FROM category ORDER BY update_time ASC ";
        if ($sort === 'name') {

            $sql = "SELECT * FROM category ORDER BY category_name DESC ";
        }

        if($sort === 'create_time') {
            $sql = "SELECT * FROM category ORDER BY create_time DESC ";
        }


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
                <h3>Category Mange</h3>
                <p>Here you can add, edit, delete category.</p>
               <ul class="nav justify-content-end">
                   <li class="nav-item">
                       <form id="add-category" method="post">
                            <input type="hidden" name="action" value="add-category">
                            <input type="text" name="add-category" placeholder="Add Category" style="height: 35px;width: 300px;">
                            <input type="submit" name="submit" value="Add"  class="btn btn-primary">
                       </form>
                   </li>
               </ul>
                <br>

                <!--table of category-->
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col" style="width: 50%; " id="sort-name-text">Category Name
                            <a href="#" onclick="sortCategory('name')">
                                <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z"/>
                                    <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z"/>
                                </svg>
                            </a>
                        </th>
                        <th scope="col" style="width: 20%" id="sort-create-time-text">Create Time
                            <a href="#" onclick="sortCategory('create_time')">
                                <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down-alt" viewBox="0 0 16 16" >
                                    <path d="M3.5 3.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 12.293V3.5zm4 .5a.5.5 0 0 1 0-1h1a.5.5 0 0 1 0 1h-1zm0 3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 0 1h-3zm0 3a.5.5 0 0 1 0-1h5a.5.5 0 0 1 0 1h-5zM7 12.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5z"/>
                                </svg>
                            </a>
                        </th>
                        <th scope="col" style="width: 20%" id="sort-update-time-text">Update Time
                            <a href="#" onclick="sortCategory('update_time')" >
                                <svg  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down-alt" viewBox="0 0 16 16">
                                    <path d="M3.5 3.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 12.293V3.5zm4 .5a.5.5 0 0 1 0-1h1a.5.5 0 0 1 0 1h-1zm0 3a.5.5 0 0 1 0-1h3a.5.5 0 0 1 0 1h-3zm0 3a.5.5 0 0 1 0-1h5a.5.5 0 0 1 0 1h-5zM7 12.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5z"/>
                                </svg>
                            </a>
                        </th>
                        <th scope="col" style="width: 15%">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($result as $row):
                            $category_id = $row['category_id'];
                            $category_name = $row['category_name'];
                            $create_time = $row['create_time'];
                            $update_time = $row['update_time'];
                        ?>

                        <tr>
                            <td><?php echo $category_name; ?></td>

                            <td><?php echo $create_time; ?></td>

                            <td><?php echo $update_time; ?></td>

                            <td>
                                <a href="#" style="padding-right: 20px" onclick="showEditModal(<?php echo $category_id; ?>, '<?php echo $category_name; ?>')">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16" >
                                                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                            </svg>
                                </a>

                                <a href="#" onclick="DeleteItem(<?php echo $category_id; ?>, '<?php echo $category_name; ?>')">
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
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="border: none;">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!--input for edit the original category name-->
                                            <form id="edit-category">
                                                <input type="hidden" name="action" value="edit-category">
                                                <input type="text" name="edit-category" id="edit-category" value="" style="height: 35px;width: 300px;">
                                                <input type="hidden" name="id" id="edit-id" value="<?php echo $category_id; ?>">
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
    // add category form submit
    $('#add-category').submit(function (event) {
        event.preventDefault();

        const data = new FormData($('#add-category')[0]);
        console.log(data);

        $.ajax({
            type: 'POST',
            url: 'category.php',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status === 1) {
                    alert(response.message);
                    window.location.href = "category.php";
                }
                alert(response.message);

            }
        });
    });


    // show edit modal with show function of bootstrap
    function showEditModal(id, name) {
        // set the value of input
        $('#edit-category').val(name);
        // set the value of hidden input
        $('#edit-id').val(id);
        $('#editModal').modal('show');
    }


    // edit category form submit
    //save change click event
    $('#save-changes').click(function (event) {
        event.preventDefault();

        const data = new FormData($('#edit-category')[0]);
        console.log(data);

        $.ajax({
            type: 'POST',
            url: 'category.php',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if(response.status === 1) {
                    alert(response.message);
                    window.location.href = "category.php";
                }
                alert(response.message);

            }
        });
    });

    //deleteItem function click event
    function DeleteItem(id, name) {
        const data = new FormData();
        data.append('action', 'delete-category');
        data.append('id', id);
        data.append('name', name);

        $.ajax({
            type: 'POST',
            url: 'category.php',
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.status === 1) {
                    alert(response.message);
                    window.location.href = "category.php";
                }
                alert(response.message);

            }
        });
    }

    //sort function for category name by，create time and update time
    function sortCategory(name) {
        // Change the color of the specific element based on the name
        if (name === 'name') {
            $('#sort-name-text').css('color', 'blue');
        } else if (name === 'create_time') {
            $('#sort-create-time-text').css('color', 'blue');
        } else if (name === 'update_time') {
            $('#sort-update-time-text').css('color', 'blue');
        }
        // Store the default color in local storage
        localStorage.setItem('defaultTextColor', 'blue');


       // url param for sort
        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('sort', name);
        window.location.search = urlParams;


    }

// When the document is ready, check if there is a sorting parameter in the URL
    $(document).ready(function() {
        // Get the sorting parameter from the URL
        const urlParams = new URLSearchParams(window.location.search);
        const sortingParam = urlParams.get('sort');

        // Store the default color in local storage
        var defaultColor = localStorage.getItem('defaultTextColor') || 'black';

// Change the color of the specific element based on the name
        if(sortingParam === null) {
            $('#sort-update-time-text').css('color', defaultColor);
        }
        else
        if(sortingParam === 'name') {
            $('#sort-name-text').css('color', defaultColor);
        } else if (sortingParam === 'create_time') {
            $('#sort-create-time-text').css('color', defaultColor);
        } else if (sortingParam === 'update_time') {
            $('#sort-update-time-text').css('color', defaultColor);
        }
    });












</script>

</body>
</html>
