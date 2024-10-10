<?php
session_start();

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful! Welcome, " . $user['username'];
        header("Location: index.php");
        exit;
        // Redirect to homepage or dashboard
    } else {
        echo "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - McDonald's Philippines</title>
</head>
<body>
<link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image:url("images/login.jpg");
            background-size:cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .login-container img {
            max-width: 100px;
            margin-bottom: 20px;
        }
        h2 {
            color: #D52B1E;
            margin-bottom: 20px;
        }
        input[type="text"], input[type="password"] {
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
            width: 80%;
        }
        button:hover {
            background-color: #D52B1E;
        }
        .login-link {
            margin-top: 20px;
            display: block;
            color: #007BFF;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="images/logo.png" alt="McDonald's Logo">
        <h2>Login to Your Account</h2>

        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <a href="signup.php" class="signup-link">Don't have an account? Sign up here!</a>
    </div>

</body>
</html>
