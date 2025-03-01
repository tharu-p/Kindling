<?php
$lang_code = isset($_GET['lang']) ? $_GET['lang'] : 'en'; // Get language from URL or default to English
$lang_file = $lang_code . '.php';

if (file_exists($lang_file)) {
    include $lang_file;
} else {
    include 'en.php'; // Default to English if language file not found
}

include 'db_connect.php';
session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM events ORDER BY date, time"; // Order by date and time
$stmt = $conn->prepare($sql);

if ($stmt === false) {  // Check for prepare errors
    die("Error preparing statement: " . $conn->error);
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "<div class='promo'> <h3>Welcome, " . $username . "!</h3></div>";
} 

$stmt->execute();
$result = $stmt->get_result(); // Get the result set

// Start the HTML output
?>
<!DOCTYPE html>
<html>
<head>
  <title>
    Kindling | <?php echo $lang['events']; ?>
  </title>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChO3rGlCHU1gmcQmREUXZI-InheicIPuc&libraries=places" async defer></script>
  <link rel="icon" type="image/x-icon" href="fire.png">
  <link href="home.css" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik&display=swap" rel="stylesheet">
</head>
<body>
  <!-- Banner -->
  <?php if (!isset($_SESSION['username'])): ?>
    <div class='promo'>
        <h3>
            <?php echo $lang['new_to_kindling']; ?>
            <a class="link" href="register.php?lang=<?php echo $lang_code; ?>"><?php echo $lang['sign_up_here']; ?></a>
        </h3>
    </div>
  <?php endif; ?>
  <!-- Banner -->
  <!-- Navbar -->
  <table content="width=device-width, initial-scale=1.0" class="navbar">
    <tr>
      <th><select id="language-select" onchange="changeLanguage()">
        <option value="en" <?php if ($lang_code === 'en') echo 'selected'; ?>>English</option>
        <option value="es" <?php if ($lang_code === 'es') echo 'selected'; ?>>Español</option>
        <option value="zh-CN" <?php if ($lang_code === 'zh-CN') echo 'selected'; ?>>简体中文</option>
        <option value="hi" <?php if ($lang_code === 'hi') echo 'selected'; ?>>हिन्दी</option>
        <option value="ar" <?php if ($lang_code === 'ar') echo 'selected'; ?>>العربية</option>
    </select></th>
      <th><a class="navbutton" href="home.php?lang=<?php echo $lang_code; ?>">	&#128293; <?php echo $lang['home']; ?></a></th>
      <th><a class="navbutton" href="events.php?lang=<?php echo $lang_code; ?>">	&#127881; <?php echo $lang['events']; ?></a></th>
      <th><a class="navbutton" href="register.php?lang=<?php echo $lang_code; ?>"> &#128221; <?php echo $lang['register']; ?></a></th>
      <th><a class="navbutton" href="login.php?lang=<?php echo $lang_code; ?>"> &#127760; <?php echo $lang['login']; ?></a></th>
      <th><a class="navbutton" href="logout.php?lang=<?php echo $lang_code; ?>"> &#128274; <?php echo $lang['logout']; ?></a></th>
    </tr>
  </table>
  <!-- Navbar -->


        <!-- Events -->
    <h1 class="etitle"><?php echo $lang['community_events']; ?></h1>
    <a class="ebtnn" href="create_events.php"><?php echo $lang['create_event']; ?></a>
    <div class="events-container"> 
    <h2><?php echo $lang['nearby_events']; ?></h2>
    <div class="grid-container" id="nearby-events"> </div>
</div>


<div class="grid-container">  <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="event">  <h2 class='title'><?php echo $row["title"]; ?></h2>
                <p class="einfo"><?php echo $row["description"]; ?></p>
                <p class="einfo"><?php echo $lang['date']; ?> <?php echo $row["date"]; ?></p>
                <p class="einfo"><?php echo $lang['time']; ?> <?php echo $row["time"]; ?></p>
                <p class="einfo"><?php echo $lang['location']; ?> <?php echo $row["location"]; ?></p>
                </div>
            <?php
        }
    } else {
        echo "No events found.";
    }
    ?>
</div>
    
      <!--   Footer -->
  <div class="footer">
      <p>
        This is just a work in progress version of this application. <br>
      &#169; 2025, Kindling
      </p>
  </div>
  <!--   Footer -->
  <script>
  function changeLanguage() {
    const selectedLanguage = document.getElementById('language-select').value;
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    url.searchParams.set('lang', selectedLanguage);
    window.location.href = url.toString();
}
  function getUserLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        const userLat = position.coords.latitude;
        const userLng = position.coords.longitude;

        // AJAX call to send location to PHP
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'get_nearby_events.php'); // Path to your PHP script
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
          if (this.status >= 200 && this.status < 400) {
          document.getElementById('nearby-events').innerHTML = this.responseText; // Target the correct container
          } else {
            console.error('Error:', this.status, this.statusText); // Handle errors
            document.getElementById('events-container').innerHTML = "Error loading events."; // Display error message to user
          }
        };
        xhr.onerror = function() {
          console.error("Request failed"); // Handle network errors
            document.getElementById('events-container').innerHTML = "Error loading events."; // Display error message to user
        };
        xhr.send('userLat=' + userLat + '&userLng=' + userLng);

      }, function(error) {
        // Handle geolocation errors (e.g., user denied permission)
        console.error("Error getting location:", error);
        document.getElementById('events-container').innerHTML = "Error getting location."; // Inform user of the error
      });
    } else {
      console.error("Geolocation is not supported by this browser.");
        document.getElementById('events-container').innerHTML = "Geolocation is not supported."; // Inform user of the error
    }
  }

  // Call getUserLocation() when the page loads:
  window.onload = getUserLocation;
</script>
</body>
</html>
<?php

$stmt->close();
$conn->close();
?>