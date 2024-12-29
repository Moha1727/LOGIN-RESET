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
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(16));

    $stmt = $conn->prepare("UPDATE users SET reset_token = ? WHERE email = ?");
    $stmt->bind_param("ss", $token, $email);

    if ($stmt->execute()) {
        $reset_link = "http://localhost/reset_password.php?token=$token";
        echo "Password reset link: $reset_link";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>