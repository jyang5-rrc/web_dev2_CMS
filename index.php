<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reflective® safeguard Fabric, Clothing & Accessories | Reflective®.ca</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div id="nav">
        <?php include('nav.php'); ?>
    </div>
  
  <main id="main-content">

    <section id="brief-description">
        <div>
            <p><span>Reflective'®' Safeguard</span> is a Canadian company that provides high quality reflective fabric, clothing and accessories.</p>
        </div>
        <div>
            <a title="Reflective® Safeguard"  href="index.html" aria-label="Home page">
                <img src="images/brief-description-image.png" alt="Reflective® Safeguard">
            </a>
            
        </div>
        <div>
            <p>We are committed to providing the best products and services to our customers.</p>
        </div>
      </section>
      <section id="showcase">
        <div id="showcase-image-fabric">
            <a href="product&service.php">
                <h1>Reflective Fabric</h1>
            </a><span></span>
        </div>
        
        <div id="showcase-image-garment">
            <a href="product&service.php">
                <h1>Clothing</h1>
            </a><span></span>
        </div>

        <div id="showcase-image-accessories">
            <a href="product&service.php">
                <h1>Accessories</h1>
            </a><span></span>
        </div>
      </section>
      
      <section id="sales">
            
            <div id="sales-caption-container">
                <a name="sales"></a>
                <ul>
                    <li><h1>HOT SALES</h1></li>
                    <li>——————</li>
                    <li>
                        <a class="chat-link" title="Chat" href="/contact-us.html">
                        <span class="chat-icon" aria-hidden="true">
                            <img class="chat-icon" src="images/ChatIcon-black.png" alt="chat">
                        </span>
                        <span class="chat-label">Chat</span>
                        </a>
                    </li>
                    <li>Contact us to know more special sales</li>
                </ul>
            </div>
            
            <div id="sales-item-container">
                <div id="product-container">
                    <img src="images/hotsales/product1.jpg">
                    <h3><span>||</span> Cycling reflective wearable tape</h3>
                    <p>safety equipment designed to improve visibility and safety of cyclists while riding in low-light conditions. </p>
                </div>
                <div id="product-container">
                    <img src="images/hotsales/product2.png">
                    <h3><span>||</span> Rainbow reflective tape</h3>
                    <p>Unique rainbow-like appearance reflective film that has a prism-like structure which reflects light in multiple colors. </p>
                </div>
                <div id="product-container">
                    <img src="images/hotsales/product3.jpg">
                    <h3><span>||</span> Adhesive reflective film</h3>
                    <p>A thin layer of plastic that is coated with a reflective material.It's used for safety purposes in low-light conditions</p>
                </div>
                <div id="product-container">
                    <img src="images/hotsales/product4.jpg">
                    <h3><span>||</span> Car reflective sticker</h3>
                    <p>A durable and weather-resistant material that can withstand exposure to the elements. </p>
                </div>
            </div>

            <div id="sales-item-container">
                <div id="product-container">
                    <img src="images/hotsales/product5.jpg">
                    <h3><span>||</span> FR reflective Garment</h3>
                    <p>Special garment that are designed to provide protection against flames and heat with high-visibility reflective properties. </p>
                </div>
                <div id="product-container">
                    <img src="images/hotsales/product6.jpg">
                    <h3><span>||</span> FR reflective tape</h3>
                    <p>Special materials that are designed to provide protection against flames and heat with high-visibility reflective properties sewing on garment.</p>
                </div>
                <div id="product-container">
                    <img src="images/hotsales/product7.jpg">
                    <h3><span>||</span> Rainbow reflective fabric</h3>
                    <p>It is designed to reflect light in a variety of colors, similar to the effect of a rainbow. Fabric for fashion clothing.</p>
                </div>
                <div id="product-container">
                    <img src="images/hotsales/product8.jpg">
                    <h3><span>||</span> Rainbow reflective jacket</h3>
                    <p>The jacket made of rainbow reflective fabric when lighting on it , it will show rainbow color.</p>
                </div>
            </div>
            
      </section>

      <section id="sales">
        <div id="sales-caption-container">
            <ul>
                <li><h1>Professional Reflective Material Manufacturer</h1></li>
                <li>——————</li>
                <li>
                    <a class="chat-link" title="Chat" href="/contact-us.html">
                    <span class="chat-icon" aria-hidden="true">
                        <img class="chat-icon" src="images/ChatIcon-black.png" alt="chat">
                    </span>
                    <span class="chat-label">Chat</span>
                    </a>
                </li>
                <li>We have more than 20 years industrial experience of producing and serving.<br>Our products have been sold out to more than 40 countries of the world.<br>No matter what the problem is Please feel free to let us know.<br>Contact us to get more information.</li>
            </ul>
        </div>
      </section>    
      
  </main>

    <div id="footer">
        <?php include('footer.php'); ?>
    </div>





  
</body>
</html>
