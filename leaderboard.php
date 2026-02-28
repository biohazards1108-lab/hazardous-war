<?php
session_start();

// Database Connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'ascent'; 
$db_name = 'characters';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// ALL Major WotLK Boss Achievement IDs
$major_bosses = [
    // ICC
    456, 460, 453, 454, 455, 459, 461, 462,
    // Ulduar
    2891, 2894, 3117, 2892, 2893,
    // ToC
    3917, 3918, 3812,
    // Naxx/OS/Eye
    574, 575, 622, 625, 2043
];

$ids_list = implode(',', $major_bosses);

// THE REAL QUERY: Counts how many unique boss achievements each player has
$sql = "SELECT c.name, c.level, c.race, c.class, COUNT(a.achievement) as boss_kills 
        FROM characters c
        JOIN character_achievement a ON c.guid = a.guid
        WHERE a.achievement IN ($ids_list)
        GROUP BY c.guid
        ORDER BY boss_kills DESC, c.level DESC
        LIMIT 10";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hall of Heroes | Hazardous War</title>
    <style>
        body {
            background-color: #050a12;
            background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)),
                url('https://images.blz-contentstack.com/v3/assets/blt3452e3b114fab0cd/blt72076046e7f8184c/629910d52579731057e62a4d/wotlk-classic-background.jpg');
            background-size: cover;
            background-attachment: fixed;
            color: #d1e1f0;
            font-family: "Palatino Linotype", serif;
            margin: 0;
            text-align: center;
        }

        .nav-bar { background: rgba(10, 20, 35, 0.95); border-bottom: 2px solid #3c5a7a; padding: 15px 0; }
        .nav-bar a { color: #fff; text-decoration: none; margin: 0 20px; text-transform: uppercase; font-size: 13px; }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: rgba(10, 15, 25, 0.9);
            padding: 40px;
            border: 1px solid #2d445a;
            box-shadow: 0 0 50px rgba(0, 174, 255, 0.1);
        }

        h1 { color: #00aeff; letter-spacing: 5px; text-transform: uppercase; text-shadow: 0 0 15px #00aeff; }

        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th { border-bottom: 2px solid #3c5a7a; padding: 15px; color: #00aeff; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid rgba(255,255,255,0.05); }

        .rank-1 { color: #ff8000; font-weight: bold; text-shadow: 0 0 5px #ff8000; } /* Legendary */
        .rank-2 { color: #a335ee; font-weight: bold; } /* Epic */
        .rank-3 { color: #0070dd; font-weight: bold; } /* Rare */

        .class-icon { font-weight: bold; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="leaderboard.php">Leaderboards</a>
        <a href="players.php">Online</a>
        <a href="media.php">Media</a>
    </nav>

    <div class="container">
        <h1>Hall of Heroes</h1>
        <p>The mightiest champions of Northrend, ranked by Major Raid Completions.</p>

        <table>
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Raid Clears</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $rank = 1;
                if ($result->num_rows > 0):
                    while($row = $result->fetch_assoc()): 
                        $rank_class = "rank-" . $rank;
                ?>
                    <tr class="<?php echo $rank_class; ?>">
                        <td>#<?php echo $rank; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td style="color: <?php echo getClassColor($row['class']); ?>">
                            <?php echo getClassName($row['class']); ?>
                        </td>
                        <td style="color: #1eff00;"><?php echo $row['boss_kills']; ?> / 20</td>
                    </tr>
                <?php 
                    $rank++;
                    endwhile; 
                else: ?>
                    <tr><td colspan="4">No heroes have conquered the raids yet...</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

<?php
// Helper functions for class colors
function getClassName($id) {
    $classes = [1=>'Warrior', 2=>'Paladin', 3=>'Hunter', 4=>'Rogue', 5=>'Priest', 6=>'Death Knight', 7=>'Shaman', 8=>'Mage', 9=>'Warlock', 11=>'Druid'];
    return $classes[$id] ?? 'Unknown';
}

function getClassColor($id) {
    $colors = [1=>'#C79C6E', 2=>'#F58CBA', 3=>'#ABD473', 4=>'#FFF569', 5=>'#FFFFFF', 6=>'#C41F3B', 7=>'#0070DE', 8=>'#69CCF0', 9=>'#9482C9', 11=>'#FF7D0A'];
    return $colors[$id] ?? '#fff';
}
?>