<?php
// (A) LOGIN CHECKS
require "check.php";

// (B) LOGIN PAGE HTML ?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-16">
        <link rel="stylesheet" href="css/general.css">
        <link rel="stylesheet" href="css/connexion.css">
        <title>
            Boutique Street'N Chic | FRANCE
        </title>
    </head>

    <body>
        <?php
            require "php/header.inc.php";
            require "php/aside.inc.php";
        ?>

        <main>
            <br>
            <br>
            <?php if (isset($failed_login)) { ?>
            <div id="bad-login">Invalid username or password.</div>
            <?php } ?>

            <?php if (isset($failed_inscription)) { ?>
            <div id="bad-inscription">You are already registered.</div>
            <?php } ?>

            <?php if (isset($success_inscirption)) { ?>
            <div id="good-inscription">You are now registered, you can log in.</div>
            <?php } ?>
            <br>

            <form id="login-form" method="post" target="_self">
              <h1>PLEASE SIGN IN</h1>
              <label for="user">User</label>
              <input type="text" name="user" required/>
              <label for="password">Password</label>
              <input type="password" name="password" required/>
              <input type="submit" name="signeIn" value="Sign In"/>
              <input type="submit" name="inscription" value="Inscription"/>
            </form>
            <br>
        </main>

        <?php
            require "php/footer.inc.php";
        ?>
    
    </body>
    
</html>