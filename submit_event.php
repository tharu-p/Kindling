<?php
include 'db_connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Retrieve data from the form (including description)
  $title = mysqli_real_escape_string($conn, $_POST["title"]);
  $description = mysqli_real_escape_string($conn, $_POST["description"]);  // Get the description
  $date = mysqli_real_escape_string($conn, $_POST["date"]);
  $time = mysqli_real_escape_string($conn, $_POST["time"]);
  $location = mysqli_real_escape_string($conn, $_POST["location"]);
  $latitude = $_POST['latitude'];
  $longitude = $_POST['longitude'];

  // Check if description is empty
  if (empty($description)) {
      die("Description cannot be empty. Please go back and fill in the description.");
  }

  $stmt = $conn->prepare("INSERT INTO events (title, description, date, time, location, latitude, longitude) VALUES (?, ?, ?, ?, ?, ?, ?)");
  if (!$stmt) {
      die("Error preparing statement: " . $conn->error);
  }
  $stmt->bind_param("sssssdd", $title, $description, $date, $time, $location, $latitude, $longitude);

  if ($stmt->execute()) {
      echo "New event created successfully";
      header("Location: events.php");
      exit();
  } else {
      echo "Error: " . $stmt->error; // Display MySQL error just in case
  }

  $stmt->close();
}

$conn->close();
?>