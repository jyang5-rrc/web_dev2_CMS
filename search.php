<?php

require ('nav.php');

session_start();



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
<div id="nav">
    <?php include('nav.php'); ?>
</div>

<div class="container-fluid" style="margin-top: 100px;">
    <div class="col py-3">
        <!--display the product card with image and links for edit and delete -->
        <div class="container">
            <h1>Search Result</h1><br>
        </div>

        <div class="row" >
            <!--product card-->
            <?php foreach ($result as $row): ?>
                <?php $id = $row['product_id'];
                $name = strlen($row['product_name'])>30 ? substr($row['product_name'],0,20)."..." : $row['product_name'];
                $description = strlen($row['product_description'])>100 ? substr($row['product_description'],0,100)."..." : $row['product_description'];
                $description= html_entity_decode($description);
                $image = $row['product_image'];
                if($image === ''){
                    $image = 'default-image.jpeg';
                }
                $top_sales = $row['top_sales'];
                ?>

                <div class="card" style="width: 25%; padding-right:10px;padding-left: 10px; " >
                    <img class="card-img-center" src="images/uploads/thumbnail-<?php echo $image; ?>" alt="<?php echo $image; ?>">
                    <div class="card-body">

                        <h5 class="card-title"><?php echo $name; ?></h5>
                        <div class="card-text">
                            <p><?php echo html_entity_decode($description); ?></p>
                        </div>


                        <p><a href="product-detail-user.php?id=<?php echo $id; ?>" class="btn btn-primary" role="button">View</a>

                            <?php if($top_sales): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                                    <path d="M8 16c3.314 0 6-2 6-5.5 0-1.5-.5-4-2.5-6 .25 1.5-1.25 2-1.25 2C11 4 9 .5 6 0c.357 2 .5 4-2 6-1.25 1-2 2.729-2 4.5C2 14 4.686 16 8 16Zm0-1c-1.657 0-3-1-3-2.75 0-.75.25-2 1.25-3C6.125 10 7 10.5 7 10.5c-.375-1.25.5-3.25 2-3.5-.179 1-.25 2 1 3 .625.5 1 1.364 1 2.25C11 14 9.657 15 8 15Z"/>
                                </svg>
                            <?php endif; ?>
                        </p>

                    </div>
                </div>
            <?php endforeach; ?>
            <!--product card end-->
        </div>

    </div>
</div>


