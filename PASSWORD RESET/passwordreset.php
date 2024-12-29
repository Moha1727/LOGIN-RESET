<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Replace with your database password
$dbname = 'login_system';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE reset_token = ?");
    $stmt->bind_param("ss", $new_password, $token);

    if ($stmt->execute()) {
        echo "Password reset successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>