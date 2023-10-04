<?php

require ('connect.php');
require ('admin-check.php');
require ('util.php');

//file upload
require '\xampp\htdocs\a\php-image-resize-master\lib\ImageResize.php';
require '\xampp\htdocs\a\php-image-resize-master\lib\ImageResizeException.php';

global $db;



function dealImage(){
    //random a data string as part of image name

    $date         = date('Y-m-d-H-i-s');
    $randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);
    $ext          = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image_filename = $date."-" .$randomString.".".$ext;
    $new_image_path        = './images/uploads/'.$image_filename;

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

//add information to database
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $key_feature = filter_input(INPUT_POST, 'key_feature', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
        $image = dealImage();
    }else{
        $image = '';
    }

    //check the top sales checkbox
    if(isset($_POST['top_sales'])) {
        $top_sales = 1;// 1 is true,this product is a top sales product.
    }else {
        $top_sales = 0;// 0 means false,this product is not a top sales product.
    }

    //check the category option result
    $category_id = filter_input(INPUT_POST, 'select_category', FILTER_SANITIZE_NUMBER_INT);

    //check if the category_id is 0, if it is, set it to null
    if ($category_id === '0') {
        $category_id = null;
    }



    // Ensure title and content must have at least 1 character, otherwise throw an error.
    if (empty($product_name) || empty($key_feature) || empty($description)) {
        util::jsonError("All fields are required.");
    } elseif (strlen($product_name) < 1 || strlen($key_feature) < 1 || strlen($description) < 1) {
        util::jsonError("All fields must have at least 1 character.");
    }

    // clean the description html to remove first <p> and last </p >
    $description = preg_replace('/^<p>/', '', $description);
    // remove the last </p >
    $description = preg_replace('/<\/p>$/', '', $description);
    // encode the description to html entities
    $description = htmlentities($description);

    //insert information to database
    $sql = "INSERT INTO products (product_name, product_keyfeature, product_description, product_image, top_sales, category_id)
            VALUES (:product_name, :key_feature, :description, :image, :top_sales,:category_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':product_name', $product_name, PDO::PARAM_STR);
    $stmt->bindValue(':key_feature', $key_feature, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':image', $image, PDO::PARAM_STR);
    $stmt->bindValue(':top_sales', $top_sales, PDO::PARAM_INT);
    $stmt->bindValue(':category_id', $category_id, PDO::PARAM_INT);

    $stmt->execute();

    util::jsonSuccess("Product added successfully.");



}

//retrive the category list from database for the select option
$query = "SELECT * FROM category";
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reflective® safeguard Fabric, Clothing & Accessories | Reflective®.ca</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="admin-cms.css">
    <!-- CSS and script from bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

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
            <h3>Add new products</h3>
            <br>

            <form id="add-product" method="post">
                <label for="product_name">Product Name</label><br>
                <input type="text" name="product_name" id="product_name"  required>
                <br><br>
                <input type='checkbox' name='top_sales' id='top_sales'>
                <label for='top_sales'>TOP SALES PRODUCT</label>
                <br><br>
                <label for="key_feature">Key Feature</label><br>
                <input type="text" name="key_feature" id="key_feature" placeholder="describe in 10 words" required>
                <br><br>
                <label for="select_category">Category</label><br>
                <select name="select_category" id="select_category">
                        <option value="0">--Null--</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br><br>
                <label for="description">Description</label><br>
                <div name="description" id="description"></div>
                <br><br>
                <label for='image'>Image Filename:</label>
                <input type='file' name='image' id='image'>
                <br><br>
                <input type="submit" value="Add Product" class="btn btn-primary">
            </form>
        </div>
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

    // add product form submit
    $('#add-product').submit(function (event) {
        event.preventDefault();

        const data = new FormData($('#add-product')[0]);
        //append the description to the data from quill editor and quillGeneratedHTML the content
        data.append('description', quill.root.innerHTML);

        console.log(data);

        $.ajax({
            type: 'POST',
            url: 'add-product.php',
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



</script>

</body>
</html>