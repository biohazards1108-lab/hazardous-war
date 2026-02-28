<?php
// Database configuration
$host = '127.0.0.1';
$user = 'root';        // Your DB username
$pass = 'ascent'; // Your DB password
$db   = 'characters';  // Usually 'characters' in Trinity/AzerothCore

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("0"); // Returns 0 if connection fails
}

// Query to count online players
$sql = "SELECT COUNT(*) as online_count FROM characters WHERE online = 1";
$result = $conn->query($sql);

if ($result) {
    $row = $result->fetch_assoc();
    echo $row['online_count'];
} else {
    echo "0";
}

$conn->close();
?><script>
function updatePlayerCount() {
    // We use 'fetch' to call the PHP script we made
    fetch('players.php')
        .then(response => response.text())
        .then(data => {
            const countElement = document.getElementById('real-player-count');
            if (countElement) {
                countElement.innerText = data;
            }
        })
        .catch(err => {
            console.error('Error fetching player count:', err);
            document.getElementById('real-player-count').innerText = "Offline";
        });
}

// Update every 30 seconds
setInterval(updatePlayerCount, 30000);
// Run once on page load
updatePlayerCount();
</script>