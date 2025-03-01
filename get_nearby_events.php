<?php

$lang_code = isset($_GET['lang']) ? $_GET['lang'] : 'en'; // Get language from URL or default to English
$lang_file = $lang_code . '.php';

if (file_exists($lang_file)) {
  include $lang_file;
} else {
  include 'en.php'; // Default to English if language file not found
}

include 'db_connect.php';
include 'functions.php';

$userLat = $_POST['userLat'];
$userLng = $_POST['userLng'];

$sql = "SELECT * FROM events";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $distance = calculateDistance($userLat, $userLng, $row['latitude'], $row['longitude']);
    if ($distance <= 10) {  
        $events[] = ['event' => $row, 'distance' => $distance];
    }
}

// Sort events by distance
usort($events, function ($a, $b) {
    return $a['distance'] <=> $b['distance'];
});

// Start the grid container
echo '<div class="grid-container">';

// Display events
foreach ($events as $eventData) {
    $event = $eventData['event'];
    ?>
    <div class="grid-item">
        <h3><?php echo $event['title']; ?></h3>
        <p><?php echo $lang['distance']; ?> <?php echo round($eventData['distance'], 2); ?> km</p>
        <p><?php echo $lang['description']; ?> <?php echo $event['description']; ?></p>
        <p><?php echo $lang['date_time']; ?> <?php echo $event['date']; ?> - <?php echo $event['time']; ?></p>
        <p><?php echo $lang['location']; ?> <?php echo $event['location']; ?></p>
    </div>
    <?php
}
echo '</div>';
?>