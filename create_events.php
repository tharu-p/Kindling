<?php
$lang_code = isset($_GET['lang']) ? $_GET['lang'] : 'en'; // Get language from URL or default to English
$lang_file = $lang_code . '.php';

if (file_exists($lang_file)) {
    include $lang_file;
} else {
    include 'en.php'; // Default to English if language file not found
}
?>

<html>
    <head>
        <title>
            Kindling | <?php echo $lang['create_event']; ?>
        </title>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyChO3rGlCHU1gmcQmREUXZI-InheicIPuc&libraries=places&callback=initAutocomplete&loading=async"></script>
        <link rel="icon" type="image/x-icon" href="fire.png">
        <link href="home.css" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik&display=swap" rel="stylesheet">
    </head>
<body class="extrabg" onload="initAutocomplete()">
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

    
        <!-- Form -->
        <div style="width: 30%; height: 80%;" class="form">
          <form action="submit_event.php" method="post">
            <h1><?php echo $lang['create_event']; ?></h1>
              <input type="text" maxlength="50" name="title" placeholder="Title" required>
              <textarea name="description" maxlength="300" id="description" placeholder="Write how long the event will last for, what it's about, etc." required></textarea>
              <input type="date" name="date" placeholder="Date" required>
              <input type="time" name="time" placeholder="Time" required>
              <input type="text" maxlength="255" id="location" name="location" placeholder="Enter a location (Ex. 123 Cookie Street)">
              <input type="hidden" id="latitude" name="latitude">
              <input type="hidden" id="longitude" name="longitude">
              <button class="btnn" type="submit" value="Submit"><?php echo $lang['create']; ?></button>
            </form>
          </div>    
        <!-- Form -->

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

  function initAutocomplete() {
    const locationInput = document.getElementById("location");
    const latitudeInput = document.getElementById("latitude");
    const longitudeInput = document.getElementById("longitude");

    const autocomplete = new google.maps.places.Autocomplete(locationInput);

    autocomplete.addListener("place_changed", () => {
      const place = autocomplete.getPlace();

      if (!place.geometry) {
        locationInput.placeholder = "Enter a valid location";
        return;
      }

      const formattedAddress = place.formatted_address; // Or place.name
      const latitude = place.geometry.location.lat();
      const longitude = place.geometry.location.lng();

      locationInput.value = formattedAddress;  // Update the input field
      latitudeInput.value = latitude;
      longitudeInput.value = longitude;


    });
  }

  // Initialize the autocomplete
  window.initAutocomplete = initAutocomplete; // Make it globally accessible
</script>
</body>
</html>