<?php
require ('connect.php');
require ('admin-check.php');
require ('util.php');
//file upload
require '\xampp\htdocs\a\php-image-resize-master\lib\ImageResize.php';
require '\xampp\htdocs\a\php-image-resize-master\lib\ImageResizeException.php';

global $db;
$categories = [];


function dealImage(){
    //random a data string as part of image name

    $date         = date('Y-m-d-H-i-s');
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
    $ext          = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image_filename = $date."-" .$randomString.".".$ext;
    $new_image_path        = './images/uploads/'.$image_filename;
//    var_dump($_FILES);

    if (file_is_allowed($_FILES['image']['tmp_name'], $new_image_path)) {

        move_uploaded_file($_FILES['image']['tmp_name'], $new_image_path);

        if($ext === 'jpg' || $ext === 'png' || $ext === 'gif'){
            // Only Resize the image,create a new object to resize the image
            $imageResize = new Gumlet\ImageResize($new_image_path);
            $imageResize->resizeToHeight(400);
            $imageResize->save('./images/uploads/medium-'. $image_filename);
            $imageResize->resizeToBestFit(286,180);
            $imageResize->save('./images/uploads/thumbnail-'. $image_filename);
        }


    }

    return $image_filename;
}

function file_is_allowed($temporary_path, $new_path) {
    $allowed_mime_types      = ['image/gif', 'image/jpg', 'image/png','image/jpeg'];
    $allowed_file_extensions = ['gif', 'jpg','jpeg', 'png'];

    $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
    $actual_mime_type        = getimagesize($temporary_path)['mime'];

    $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
    $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

    return $file_extension_is_valid && $mime_type_is_valid;
}


function delete_image($image_name) {
    $image_path = './images/uploads/' . $image_name;
    $medium_image_path = './images/uploads/medium-' . $image_name;
    $thumbnail_image_path = './images/uploads/thumbnail-' . $image_name;

    if (file_exists($image_path)) {
        unlink($image_path);
    }
    if (file_exists($medium_image_path)) {
        unlink($medium_image_path);
    }
    if (file_exists($thumbnail_image_path)) {
        unlink($thumbnail_image_path);
    }

}


// $_Get product id ,then select the product information from database
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM products WHERE product_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $product_name = $product['product_name'];
            $key_feature = $product['product_keyfeature'];
            $description = html_entity_decode($product['product_description']);
            $image = $product['product_image'];
            $top_sales = $product['top_sales'];
            $category_id = $product['category_id'];

            //if top_sales is 1, set the checkbox to checked
            if ($top_sales === 1) {
                $top_sales = 'checked';
            } else {
                $top_sales = '';
            }

            //if the category_id is null, set the category_name to 'Null'
            if($category_id === null) {
                $category_name = 'Null';
            }  else {
                //get the category name from category table
                $query = "SELECT category_name FROM category WHERE category_id = :category_id";
                $statement = $db->prepare($query);
                $statement->bindValue(':category_id', $category_id, PDO::PARAM_INT);
                $statement->execute();
                $category = $statement->fetch(PDO::FETCH_ASSOC);
                $category_name = $category['category_name'];
            }

            //get all category for select option
            $query = "SELECT * FROM category";
            $statement = $db->prepare($query);
            $statement->execute();

            $categories = $statement->fetchAll();
        }

    }else{
            //POST method
            //get the action type
            $action = filter_input(INPUT_POST, 'action');

            //update product information
            if ($action === 'update') {
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
                $new_product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $new_key_feature = filter_input(INPUT_POST, 'key_feature', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $new_description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                // get product from database
                $query = "SELECT * FROM products WHERE product_id = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                $product = $statement->fetch(PDO::FETCH_ASSOC);
                // check if product exists
                if (!$product) {
                    util::jsonError("Product does not exist.");
                }


                if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
                    $new_image = dealImage();
                    // update image name in database
                    $updateQuery = "UPDATE products SET product_image = :image WHERE product_id = :id";
                    $updateStatement = $db->prepare($updateQuery);
                    $updateStatement->bindValue(':id', $id, PDO::PARAM_INT);
                    $updateStatement->bindValue(':image', $new_image, PDO::PARAM_STR);
                    $updateStatement->execute();

                    //delete image
                    delete_image('../images/uploads/'.$product['product_image']);
                }


                if (strlen($new_product_name) >= 1 && strlen($new_key_feature) >= 1 && strlen($new_description) >= 1) {
                    $updateQuery = "UPDATE products SET product_name = :product_name, product_keyfeature = :key_feature,
                                product_description = :description WHERE product_id = :id";
                    $updateStatement = $db->prepare($updateQuery);
                    $updateStatement->bindValue(':id', $id, PDO::PARAM_INT);
                    $updateStatement->bindValue(':product_name', $new_product_name, PDO::PARAM_STR);
                    $updateStatement->bindValue(':key_feature', $new_key_feature, PDO::PARAM_STR);
                    $updateStatement->bindValue(':description', $new_description, PDO::PARAM_STR);
                    $updateStatement->execute();



                    util::jsonSuccess('Product updated successfully.');

                } else {
                    echo "All fields must be at least 1 character.";
                }


            }elseif ($action === 'delete') {
                $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

                // get product from database
                $query = "SELECT * FROM products WHERE product_id = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
                $product = $statement->fetch(PDO::FETCH_ASSOC);
                // check if product exists
                if (!$product) {
                    util::jsonError("Product does not exist.");

                }

                $deleteQuery = "DELETE FROM products WHERE product_id = :id";
                $deleteStatement = $db->prepare($deleteQuery);
                $deleteStatement->bindValue(':id', $id, PDO::PARAM_INT);
                $deleteStatement->execute();
                //delete image
                delete_image('./images/uploads/' . $product['product_image']);


                util::jsonSuccess('Product deleted successfully.');
            }




    }



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

    <!--css and script for quill-->
    <link rel="stylesheet" href="../node_modules/quill/dist/quill.snow.css">
    <script src="../node_modules/quill/dist/quill.min.js"></script>
    <script src="../assets/js/main.js"></script>


    <!--css and script for quill-->
    <link rel="stylesheet" href="../node_modules/quill/dist/quill.snow.css">
    <script src="../node_modules/quill/dist/quill.min.js"></script>
    <script src="../assets/js/main.js"></script>

    <!-- Include stylesheet -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <!-- Include the Quill library -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


</head>
<body>

<div class="container-fluid">
    <?php include('admin-nav-asider.php'); ?>
    <div class="col py-3">
        <!--display the product card with image and links for edit and delete -->
        <div class="container">
            <h3>Edit Product</h3>
            <p>Here you can update product information.</p>

            <form id="update-product" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <label for="product_name">Product Name</label><br>
                <input type="text" name="product_name" id="product_name" value="<?php echo $product_name; ?>" required>
                <br><br>

                <input type="checkbox" name="top_sales" id="top_sales" value="<?php  ?>" <?php echo $top_sales; ?>>
                <label for="top_sales" >TOP SALES PRODUCT</label><br><br>
                <label for="key_feature">Key Feature</label><br>
                <input type="text" name="key_feature" id="key_feature" value="<?php echo $key_feature; ?>" required>
                <br><br>
                <label for="select_category">Category</label><br>
                <select name="select_category" id="select_category">

                    <option value="0">--Null--</option>
                    <?php foreach ($categories as $row) : ?>
                            <option value="<?php echo $row['category_id']; ?>"
                                <?php if ($row['category_id'] === $category_id) echo "selected"; ?>>
                                <?php echo $row['category_name']; ?>
                            </option>
                    <?php endforeach; ?>
                </select>
                <br><br>
                <label for="description">Description</label><br>
                <div name="description" id="description"><?php echo html_entity_decode($description); ?></div>
                <br><br>
                <label for='image'>Image Filename:
                </label>
                <p>Current image name: <?php echo $image; ?>
                    <br>Uploads another image if you want to change.
                </p>
                <input type='file' name='image' id='image'>

                <br><br>
                <input type="hidden" name="action" value="update">
                <input type="submit" class="btn btn-primary" value="Update Product">
            </form>
            <br>
            <form id="delete-product" method="post">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="action" value="delete">
                <input type="submit" class="btn btn-primary" value="Delete">
            </form>
        <div>

    </div>
</div>



    <script>
        var quill = new Quill('#description', {
            theme: 'snow', // Snow theme is the default theme
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{'header': 1}, {'header': 2}],
                    [{'list': 'ordered'}, {'list': 'bullet'}],
                    [{'script': 'sub'}, {'script': 'super'}],
                    [{'indent': '-1'}, {'indent': '+1'}],
                    [{'direction': 'rtl'}],
                    [{'size': ['small', false, 'large', 'huge']}],
                    [{'header': [1, 2, 3, 4, 5, 6, false]}],
                    [{'color': []}, {'background': []}],
                    [{'font': []}],
                    [{'align': []}],
                    ['clean'],
                    ['link', 'image', 'video']
                ]
            }
        });


        // update product form submit
        $('#update-product').submit(function (event) {
            event.preventDefault();
            const data = new FormData($('#update-product')[0]);
            //append the description to the data from quill editor and quillGeneratedHTML the content
            data.append('description', quill.root.innerHTML);
            console.log(data);

            $.ajax({
                type: 'POST',
                url: 'edit-product.php',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.status === 1) {
                        alert(response.message);
                        window.location.href = "products.php";
                    }
                    alert(response.message);
                }
            });
        });

        // delete product form submit

        $('#delete-product').submit(function (event) {
            event.preventDefault();
            const data = new FormData($('#delete-product')[0]);
            //append the description to the data from quill editor and quillGeneratedHTML the content
            data.append('description', quill.root.innerHTML);
            console.log(data);

            $.ajax({
                type: 'POST',
                url: 'edit-product.php',
                data: data,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert(response.message);
                    window.location.href = 'products.php';

                }
            });
        });
    </script>
</body>
</html>