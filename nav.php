<?php
//require('connect.php');
//require('util.php');
//
//session_start();
//
//global $db;
//
////get search keyword
//$search_keyword = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//
////base sql
//$sql = "SELECT * FROM products WHERE product_name LIKE :search_keyword";
//
////get all products
//$statement = $db->prepare($sql);
//$statement->bindValue(':search_keyword', "%$search_keyword%", PDO::PARAM_STR);
//$statement->execute();
//$result = $statement->fetchAll();
//
////if no result found, display error message
//if(empty($result)){
//    util::jsonError('No result found.');
//}
//
//
//
//?>
<nav>
    <div id ="topnav">
        <div id="topnav-utility-container">
            <nav id="topnav-utility-right" role="navigation" aria-label="Site Utility Navigation">
                <ul class="topnav-utility">
                    <li class="topnav-utility-item-flag" aria-label="Language selector">
                        <!--nation and language chosen : the link is not exist now ,href = "#"-->
                        <a class="topnav-utility-item-flag-link" href="#" title="Canada" aria-label="Click here to change the location or language. Currently on Canada EN">
                            <span class="topnav-utility-item-flag-image">
                                <img class="topnav-utility-item-flag-image" src="images/CanadaFlag.png" alt="Canada">
                            </span>
                            <span class="topnav-utility-item-flag-label">EN</span>
                        </a>
                    </li>
                    <li class="topnav-utility-item-chat">
                        <a class="topnav-utility-item-chat-link" title="Chat" href="contact-us.php">
                            <span class="topnav-utility-item-chat-icon" aria-hidden="true">
                                <img class="topnav-utility-item-chat-icon" src="images/ChatIcon.png" alt="chat">
                            </span>
                            <span class="topnav-utility-item-chat-label">Chat</span>
                        </a>
                    </li>
                    <li class="topnav-utility-item-cart">
                        <a class="topnav-utility-item-cart-link" title="Cart" href="product&service.php" aria-label="Cart">
                            <span class="topnav-utility-item-cart-icon">
                                <img class="topnav-utility-item-cart-icon" src="images/CartIcon.png" alt="cart">
                            </span>
                            <span class="topnav-utility-item-cart-label">Cart</span>
                        </a>
                    </li>
                    <li class="topnav-utility-item-login">
                        <a class="topnav-utility-item-login-link" title="login" href="login.php" aria-label="Login">
                            <span class="topnav-utility-item-flag-image">
                                <img class="topnav-utility-item-flag-image" src="images/loginFlag.png" alt="user login">
                            </span>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                    <span class="topnav-utility-item-login-label"><?php echo $_SESSION['username']; ?></span>
                            <?php else: ?>
                                <span class="topnav-utility-item-login-label">Log In</span>
                            <?php endif ?>
                        </a>
                    </li>
                    <li class="topnav-utility-item-admin">
                        <a class="topnav-utility-item-admin-link" title="admin" href="admin.php" aria-label="admin">
                            <span class="topnav-utility-item-flag-image">
                                <img class="topnav-utility-item-flag-image" src="images/admin.png" alt="login">
                            </span>
                            <?php if(isset($_SESSION['role'])): ?>
                                <span class="topnav-utility-item-admin-label"><?php echo $_SESSION['username']; ?></span>
                            <?php else: ?>
                                <span class="topnav-utility-item-admin-label">Admin</span>
                            <?php endif ?>
                        </a>
                    </li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="topnav-utility-item-logout">
                        <a class="topnav-utility-item-logout-link" title="Sign Out" href="signout.php" aria-label="Logout">
                            <span class="topnav-utility-item-flag-image">
                                <img class="topnav-utility-item-flag-image" src="images/sign-out-icon.png" alt="Sign Out">
                            </span>
                    <?php endif ?>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <header id="topnav-nav-container">
            <div id="header-brand">
                <a title="Brand" href="index.php" aria-label="Home page">
                    <ul>
                        <li><img src="images/Logo.png" alt="Reflective® Safeguard"></li>
                        <li><h1>Reflective<span>'®'</span> Safeguard</h1></li>
                    </ul>
                </a>
            </div>
            <nav id="header-nav">
                <div id="header-nav-right">
                    <ul>
                        <li id="current-page"><a href="index.php">Home</a></li>
                        <li><a href="product&service.php">Products&Services</a></li>
                        <li><a href="contact-us.php">ContactUs</a></li>
                        <li><a href="index.php"><img src="images/SalesIcon.png">Sales</a></li>
                    </ul>
                </div>
                <form id="header-nav-left" method="post">
                    <label for="search"></label>
                    <input type="text" id="search" name="search" placeholder="Search...">
                    <button type="submit" class="button_1">Search</button>
                </form>
            </nav>
            <nav>
                <div id="header-nav-right2">
                    <ul>
                        <li id="current-page2"><a href="index.php">Home</a></li>
                        <li><a href="product&service.php">Products&Services</a></li>
                        <li><a href="contact-us.php">ContactUs</a></li>
                        <li><a href="index.php#sales"><img src="images/SalesIcon.png">Sales</a></li>
                    </ul>
                </div>
            </nav>
        </header>



    </div>
</nav>

<!--<script>-->
<!--    // add product form submit-->
<!--    $('#header-nav-left').submit(function (event) {-->
<!--        event.preventDefault();-->
<!---->
<!--        const data = new FormData($('#header-nav-left')[0]);-->
<!---->
<!--        console.log(data);-->
<!---->
<!--        $.ajax({-->
<!--            type: 'POST',-->
<!--            url: 'nav.php',-->
<!--            data: data,-->
<!--            processData: false,-->
<!--            contentType: false,-->
<!--            success: function (response) {-->
<!--                if(response.status === 1) {-->
<!--                    alert(response.message);-->
<!--                    window.location.href = "search.php";-->
<!--                }-->
<!--                alert(response.message);-->
<!---->
<!--            }-->
<!--        });-->
<!--    });-->
<!--</script>-->
