<?php
$lang_code = isset($_GET['lang']) ? $_GET['lang'] : 'en'; // Get language from URL or default to English
$lang_file = $lang_code . '.php';

if (file_exists($lang_file)) {
    include $lang_file;
} else {
    include 'en.php'; // Default to English if language file not found
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kindling | <?php echo $lang['register']; ?></title>
    <link rel="icon" type="image/x-icon" href="fire.png">
    <link href="home.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik&display=swap" rel="stylesheet">
</head>

<body class="extrabg">
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
    <div style="width: 30%; height: 20%;" class="form">
        <form action="submit_register.php" method="post">
            <h1><?php echo $lang['register']; ?></h1>

            <input type="text" maxlength="20" name="username" placeholder="Enter Username Here">
            <input type="password" maxlength="20" name="password" placeholder="Enter Password Here">

            <button class="btnn" type="submit" value="register"><?php echo $lang['register']; ?></button>

            <p class="link"><?php echo $lang['already_account']; ?>
                <br>
                <a href="login.html"><?php echo $lang['log_in_here']; ?></a>  
            </p>
    </div>
    </form>
        <!-- Form -->

  <!--   Footer -->
  <div class="footer">
    <p>
      This is just a work in progress version of this application. <br>
      &#169; 2025, Kindling
    </p>
</div>
<!--   Footer -->
  <!-- Language Script -->
  <script>
function changeLanguage() {
    const selectedLanguage = document.getElementById('language-select').value;
    const currentUrl = window.location.href;
    const url = new URL(currentUrl);
    url.searchParams.set('lang', selectedLanguage);
    window.location.href = url.toString();
}
</script>
  <!-- Language Script -->
</body>
</html>