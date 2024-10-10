<?php
session_start();

require 'db.php';
if (isset($_SESSION["user"])) {
    header("location: login.php");
 }


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);

    echo "Signup successful!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup - McDonald's Philippines</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
<style>
        body {
            background-image: url("images/signup.jpg");
            background-size:cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .signup-container {
            width: 100%;
            max-width: 400px;
            margin: 30px auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .signup-container img {
            max-width: 100px;
            margin-bottom: 20px;
            padding: 10px;
        }
        h2 {
            color: #D52B1E;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #FFC300;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 50%;
        }
        button:hover {
            background-color: #D52B1E;
        }
        .signup-link {
            margin-top: 20px;
            display: block;
            color: #007BFF;
            text-decoration: none;
        }
        .signup-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="signup-container">
        <img src="images/logo.png" alt="McDonald's Logo">
    <h2>Create your account</h2>
    <form method="POST" action="signup.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Sign Up</button>
        </form>

        <a href="login.php" class="login-link">Already have an account? Login here!</a>
    </div>
</body>
</html>
