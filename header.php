<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Login System</title>
    <!-- <link rel="stylesheet" href="./style.css" type="text/css"> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="mystyles.css">

</head>

<body>
    <nav class="navbar is-light is-size-4 p-2 mb-4" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="index.php">
                Home
            </a>
            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div class="navbar-menu">
            <div class="navbar-end">
                <?php if (!isset($_SESSION['usersId'])) : ?>
                <a class="navbar-item" href="signup.php">
                    Sign Up
                </a>
                <a class="navbar-item" href="login.php">
                    Login
                </a>
                <?php else : ?>
                <a class="navbar-item " href="./controllers/Users.php?q=logout">
                    Logout
                </a>
                <?php endif; ?>
            </div>
        </div>

    </nav>

    <script>
    $(document).ready(function() {

        // Check for click events on the navbar burger icon
        $(".navbar-burger").click(function() {

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            $(".navbar-burger").toggleClass("is-active");
            $(".navbar-menu").toggleClass("is-active");

        });
    });
    </script>