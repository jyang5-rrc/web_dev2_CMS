<?php

require ('connect.php');
require ('admin-check.php');
require ('util.php');

global $db;

// $_Get product id ,then select the product information from database
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE product_id = :id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id, PDO::PARAM_INT);
    $statement->execute();
    $product = $statement->fetch();

    if ($product) {
        $product_id = $product['product_id'];
        $date_time = $product['date_time'];
        $update_time = $product['update_time'];
        $product_name = $product['product_name'];
        $key_feature = $product['product_keyfeature'];
        $description = $product['product_description'];
        $image = $product['product_image'];
        $description = html_entity_decode($description);


    }else{
        util::jsonError("Product not found.");
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


</head>
<body>

<div class="container-fluid">
    <?php include('admin-nav-asider.php'); ?>
    <div class="col py-3">
        <!--display the product card with image and links for edit and delete -->
        <div class="container">
            <h3>Product Detail</h3>
            <p>Here you can browse  product detail and manage them.</p>
            <ul class="nav justify-content-end">
                <li class="nav-item">
                    <a href="edit-product.php?id=<?php echo $id ?>" class="btn btn-primary">Edit</a>
                    <a href="delete-product.php?id=<?php echo $id ?>" class="btn btn-danger">Delete</a>
                </li>

            </ul>


            <br><br>
            <p><h2><?php echo $product_name; ?></h2></p>
            <br>
            <P>Upload time: <?php echo $date_time; ?></P>
            <p>Update time: <?php echo $update_time; ?></p>
            <br>
            <img src="./images/uploads/<?php echo $image; ?>" alt="product image" width="300" height="300">
            <br><br>
            <p><h4>Key Feature:</h4><?php echo $key_feature; ?></p>
            <br>
            <div><h4>Description:</h4><div id="description-dom"><?php echo html_entity_decode($description); ?></div></div>

            <br><br>
            <a href="products.php">Back to Product List</a>
        </div>
    </div>


</div>
<script>
    //$(document).ready(function(){
    //    const description = "<?php //echo html_entity_decode($description) ?>//";
    //    $("#description-dom").html(description);
    //});
</script>

</body>
</html>

