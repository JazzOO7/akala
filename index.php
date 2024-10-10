<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>McDonald's Inventory Management System</title>
    <style>
        body {
            font-family: times, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("images/cover.png");
            background-size: cover;
            overflow: auto; /* Allow scrolling */
            
        }

        /* Header Styling */
        header {
            background-color: #ffc107;
            max-width: 0px;
            padding: 0px;
            text-align: center;
            position: relative; /* To position title */
            background: linear-gradient(#8B0000, #FF6347, #8B0000); 
        }

        header img {
            max-width: 100px;
            position:relative;
            
            
        }

        /* Navbar Styling */
        nav {
            display: flex;
            justify-content: right;
            background: linear-gradient(#8B0000, #FF6347, #8B0000); /* Gradient background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Shadow effect */
        }

        nav a {
            color: white;
            padding: 14px 20px;
            text-decoration: none;
            text-align: center;
            transition: background 0.3s;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Banner Section */
        .banner {
            width: 100%;
            height: 400px;
            background-image: url('images/cover.png'); /* Replace with your animated background */
            background-size: cover;
            background-position: center;
            position: relative; /* For title positioning */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .banner-title {
            position: absolute;
            color: white;
            font-size: 48px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
            animation: fadeIn 2s ease-in-out; /* Title animation */
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .menu-item {
            display: inline-block;
            width: 30%;
            margin: 10px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 10px;
            background-color: #fff; /* Added background */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }

        .menu-item img {
            max-width: 80%;
            border-radius: 10px;
            transition: transform .2s, opacity 0.5s; /* Animate hover effect */
        }

        .menu-item img:hover {
            transform: scale(1.1); /* Zoom effect on hover */
            opacity: 0.9; /* Slight fade effect */
        }

        footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            position: relative; /* Added for consistency */
        }
    </style>
</head>
<body>

<header>
    
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="login.php">Login</a> |
    <a href="signup.php">Signup</a>
</nav>

<section class="banner">
    <h1 class="banner-title">Welcome to McDonald's</h1>
</section>

<div class="content">
    <div class="menu-item">
        <img src="images/bigmac.png" width="250" height="250" alt="Burger">
        <h3>Big Mac</h3>
        <p>A special burger with lettuce, cheese, pickles, and onions.</p>
    </div>

    <div class="menu-item">
        <img src="images/fries.jpg" width="250" height="250" alt="Fries">
        <h3>Fries</h3>
        <p>Golden, crispy fries made with the highest quality potatoes.</p>
    </div>

    <div class="menu-item">
        <img src="images/chicken.jpg" width="250" height="250" alt="Chicken">
        <h3>Chicken</h3>
        <p>A better and crunchy chicken.</p>
    </div>
</div>

<footer>
    <p>&copy; 2024 McDonald's Philippines. All rights reserved.</p>
</footer>

</body>
</html>
