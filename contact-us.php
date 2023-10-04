<?php

session_start();
require ('connect.php');


?>
<!DOCTYPE html>
<html lang="en">
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
  
  <main id="main-contact-form-content" >
    <div id="main-contact-form-content-container">
      <h1>Contact Us</h1>
    </div>
    <div id="main-contact-form-content-container">
      <div>
        <h2>Winnipeg(Canada)</h2>
        <p>Address:609 Princes Street, Winnipeg, RRF T0F<br>
           Tel: +1 456 869 2456<br>
           Email:service@rs.ca</p>
      </div>
      <div>
        <h2>NewYork(Unite States)</h2>
        <p>Address:609 Princes Street, Winnipeg, RRF T0F<br>
           Tel: +1 456 869 2456<br>
           Email:service@rs.ca</p>
      </div>
    </div>
    <div id="main-contact-form-content-container">
      <div>
        <h2>New Delhi(India)</h2>
        <p>Address:609 Princes Street, Winnipeg, RRF T0F<br>
           Tel: +1 456 869 2456<br>
           Email:service@rs.ca</p>
      </div>
      <div>
        <h2>GuangZhou(China)</h2>
        <p>Address:609 Princes Street, Winnipeg, RRF T0F<br>
           Tel: +1 456 869 2456<br>
           Email:service@rs.ca</p>
      </div>
    </div>
    
   
    <fieldset id="contact-form-container">
      <legend>Send us a message</legend>
      <form id="contact-form" action="#">
        <div>
          <label for="name">Name:</label>
          <br>
          <input type="text" id="name" name="name" value="" autofocus="autofocus">
          <div class="error" id="name_error">* Please enter your name.</div>
        </div>
        
        <div>
          <label for="phone">Phone Number:</label>
          <br>
          <input type="tel" id="phone" name="phone" >
          <div class="error" id="phone_error">* Please enter your phone number.</div>
        </div>
        
        <div>
          <label for="email">Email:</label>
          <br>
          <input type="text" id="email" name="email" >
          <div class="error" id="email_error">* Please enter a valid Email address.</div>
        </div>
        
        <div>
          <label for="location">Your location city:</label>
          <br>
          <input type="location" id="location" name="location" >
          <div class="error" id="location_error">* Please enter your city name, so that we can arrange staff to contact with you.</div>
        </div>
        
        <div>
          <label for="query">Query title:</label>
          <br>
          <input type="query" id="query" name="query" >
          <div class="error" id="query_error">* Please describe your question briefly.Then give your more details in the content box as you want.</div>
        </div>
        
        <div>
          <label for="querycontent">Query Content:</label>
          <br>
          <textarea id="querycontent" name="querycontent" rows="10" cols="50" ></textarea>
        </div>
        <div>
          <button type="submit">Submit</button>
          <button type="reset">Reset</button>
        </div>
        
        
      </form>
    </fieldset>
    

  </main>

  <footer id="main-footer">
    <div class="footer_links">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Twitter</a></li>
            <li><a href="product&service.php">Products&Service</a></li>
            <li><a href="contact-us.html">Contact Us</a></li>
        </ul>
    </div>
    <p>Reflective Safeguard &copy; 2023, All Rights Reserved</p>
    
  </footer>

</body>