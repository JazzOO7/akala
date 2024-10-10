<?php
$host = 'localhost';
$dbname = 'mcdo';
$user = 'root';
$pass = ''; // Default password for XAMPP/WAMP/MAMP

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
