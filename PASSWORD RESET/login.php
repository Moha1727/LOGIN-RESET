<?php
session_start();
$host = 'localhost';
$user = 'root';
$password = ''; // Replace with your database password
$dbname = 'login_system';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        echo "Login successful!";
    } else {
        echo "Invalid credentials.";
    }

    $stmt->close();
}
?>