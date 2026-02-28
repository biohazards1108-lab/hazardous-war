<?php
session_start();

// Database Connection - Note: This usually connects to 'characters' database, not 'auth'
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'ascent'; 
$db_name = 'characters'; // Make sure this matches your characters database name

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    $online_count = 0;
} else {
    // Count how many players have 'online = 1'
    $result = $conn->query("SELECT name, race, class, level, zone FROM characters WHERE online = 1");
    $online_count = $result->num_rows;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Heroes | Hazardous War</title>
    <style>
        body {
            background-color: #050a12;
            background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.blz-contentstack.com/v3/assets/blt3452e3b114fab0cd/blt72076046e7f8184c/629910d52579731057e62a4d/wotlk-classic-background.jpg');
            background-size: cover;
            background-attachment: fixed;
            color: #d1e1f0;
            font-family: "Palatino Linotype", serif;
            margin: 0;
            text-align: center;
        }

        .nav-bar {
            background: rgba(10, 20, 35, 0.95);
            border-bottom: 2px solid #3c5a7a;
            padding: 15px 0;
        }

        .nav-bar a { color: #fff; text-decoration: none; margin: 0 20px; text-transform: uppercase; font-size: 13px; }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: rgba(10, 15, 25, 0.9);
            padding: 30px;
            border: 1px solid #2d445a;
            border-radius: 4px;
        }

        h1 { color: #00aeff; letter-spacing: 5px; text-transform: uppercase; }

        .status-bar {
            background: rgba(30, 255, 0, 0.1);
            border: 1px solid #1eff00;
            padding: 10px;
            margin-bottom: 20px;
            color: #1eff00;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            border-bottom: 2px solid #3c5a7a;
            padding: 12px;
            color: #00aeff;
            text-transform: uppercase;
            font-size: 14px;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #1a2a3a;
            font-size: 15px;
        }

        .no-players { padding: 40px; color: #555; font-style: italic; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="rules.php">Rules</a>
    </nav>

    <div class="container">
        <h1>Realm Population</h1>
        
        <div class="status-bar">
            ● <?php echo $online_count; ?> Heroes Currently Online
        </div>

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Level</th>
                    <th>Race</th>
                    <th>Class</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php if($online_count > 0): ?>
                    <?php while($player = $result->fetch_assoc()): ?>
                        <tr>
                            <td style="color: #fff; font-weight: bold;"><?php echo $player['name']; ?></td>
                            <td><?php echo $player['level']; ?></td>
                            <td><?php echo getRaceName($player['race']); ?></td>
                            <td style="color: <?php echo getClassColor($player['class']); ?>"><?php echo getClassName($player['class']); ?></td>
                            <td style="font-size: 12px; color: #88a0b5;"><?php echo $player['zone']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="no-players">The frozen wastes are currently empty...</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Helper functions to turn IDs into Names
function getRaceName($id) {
    $races = [1=>'Human', 2=>'Orc', 3=>'Dwarf', 4=>'Night Elf', 5=>'Undead', 6=>'Tauren', 7=>'Gnome', 8=>'Troll', 10=>'Blood Elf', 11=>'Draenei'];
    return $races[$id] ?? 'Unknown';
}

function getClassName($id) {
    $classes = [1=>'Warrior', 2=>'Paladin', 3=>'Hunter', 4=>'Rogue', 5=>'Priest', 6=>'Death Knight', 7=>'Shaman', 8=>'Mage', 9=>'Warlock', 11=>'Druid'];
    return $classes[$id] ?? 'Unknown';
}

function getClassColor($id) {
    $colors = [1=>'#C79C6E', 2=>'#F58CBA', 3=>'#ABD473', 4=>'#FFF569', 5=>'#FFFFFF', 6=>'#C41F3B', 7=>'#0070DE', 8=>'#69CCF0', 9=>'#9482C9', 11=>'#FF7D0A'];
    return $colors[$id] ?? '#fff';
}
?>
