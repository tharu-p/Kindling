<?php
include 'db_connect.php';

session_start();
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $loginUsername = $_POST['username'];
    $loginPassword = $_POST['password'];

    // IMPORTANT: Use prepared statements to prevent SQL injection!
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("ss", $loginUsername, $loginPassword); // "ss" for two strings
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Login successful!";
        $_SESSION['username'] = $loginUsername; // Corrected line: Use $loginUsername
        header("Location: home.php");
        exit(); // Important: Stop further execution after redirect
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close(); // Close the statement
}

mysqli_close($conn); // Close the database connection
?>