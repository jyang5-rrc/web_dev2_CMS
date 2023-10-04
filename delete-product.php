<?php
require ('connect.php');
require ('admin-check.php');

global $db;

// $_Get product id ,then select the product information from database

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $query = "SELECT * FROM products WHERE product_id = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $product = $statement->fetch(PDO::FETCH_ASSOC);

        //delete product
        if ($product) {
            $product_name = $product['product_name'];
            $key_feature = $product['product_keyfeature'];
            $description = $product['product_description'];
            $image = $product['product_image'];

            $deleteQuery = "DELETE FROM products WHERE product_id = :id";
            $deleteStatement = $db->prepare($deleteQuery);
            $deleteStatement->bindValue(':id', $id, PDO::PARAM_INT);
            $deleteStatement->execute();


            //delete image
            $image_path = './images/uploads/' . $image;
            $medium_image_path = './images/uploads/medium-' . $image;
            $thumbnail_image_path = './images/uploads/thumbnail-' . $image;

            if (file_exists($image_path)) {
                unlink($image_path);
            }
            if (file_exists($medium_image_path)) {
                unlink($medium_image_path);
            }
            if (file_exists($thumbnail_image_path)) {
                unlink($thumbnail_image_path);
            }

            header("Location: products.php");
            exit();


        }
    }

?>
