<?php
session_start();
$conn = new mysqli('localhost', 'root', 'ascent', 'characters');

// 1. Define Staff (Manual list since staff aren't usually a DB table)
$staff_members = [
    ['name' => 'biohazards1108', 'owner' => 'Owner / Lead Dev', 'class' => 6, 'color' => '#C41F3B'], // DK Red
    ['name' => 'Darkbishop1109', 'co-owner' => 'Game Master', 'class' => 2, 'color' => '#F58CBA'], // Pally Pink
];

// 2. Fetch Online Players
$online_players = $conn->query("SELECT name, race, class, level, zone FROM characters WHERE online = 1 ORDER BY level DESC");

// Helper for WotLK Zone Names (Add more as needed)
function getZoneName($zoneId) {
    $zones = [33=>'Shadowfang Keep', 490=>'Icecrown', 4395=>'Dalaran', 3537=>'Borean Tundra', 65=>'Dragonblight'];
    return $zones[$zoneId] ?? "Unknown Territory ($zoneId)";
}

function getClassName($id) {
    $classes = [1=>'Warrior', 2=>'Paladin', 3=>'Hunter', 4=>'Rogue', 5=>'Priest', 6=>'Death Knight', 7=>'Shaman', 8=>'Mage', 9=>'Warlock', 11=>'Druid'];
    return $classes[$id] ?? 'Hero';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>War Room | Hazardous War</title>
    <style>
        body {
            background: #050a12 url('https://images.blz-contentstack.com/v3/assets/blt3452e3b114fab0cd/blt72076046e7f8184c/629910d52579731057e62a4d/wotlk-classic-background.jpg') fixed center;
            background-size: cover; color: #d1e1f0; font-family: "Palatino Linotype", serif; margin: 0; text-align: center;
        }
        .nav-bar { background: rgba(10, 20, 35, 0.95); border-bottom: 2px solid #3c5a7a; padding: 15px 0; }
        .nav-bar a { color: #fff; text-decoration: none; margin: 0 15px; text-transform: uppercase; font-size: 12px; }
        
        .container { max-width: 1000px; margin: 40px auto; background: rgba(10, 15, 25, 0.9); padding: 40px; border: 1px solid #2d445a; }
        
        h1, h2 { color: #00aeff; text-transform: uppercase; letter-spacing: 3px; }

        /* Staff Section */
        .staff-grid { display: flex; justify-content: center; gap: 20px; margin-bottom: 50px; flex-wrap: wrap; }
        .staff-card { background: rgba(0,0,0,0.5); border: 1px solid #00aeff; padding: 20px; width: 200px; border-radius: 5px; }
        
        /* Online Table */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: rgba(0,0,0,0.3); }
        th { border-bottom: 2px solid #3c5a7a; padding: 12px; color: #00aeff; }
        td { padding: 12px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        
        .class-color-6 { color: #C41F3B; } /* Example DK */
        .online-indicator { color: #1eff00; font-size: 10px; margin-right: 5px; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="staff_and_online.php">War Room</a>
        <a href="leaderboard.php">Leaderboard</a>
    </nav>

    <div class="container">
        <h1>Command Council</h1>
        <div class="staff-grid">
            <?php foreach($staff_members as $staff): ?>
            <div class="staff-card">
                <div style="color: <?php echo $staff['color']; ?>; font-size: 20px; font-weight: bold;"><?php echo $staff['name']; ?></div>
                <div style="font-size: 12px; color: #88a0b5; margin-top: 5px;"><?php echo $staff['role']; ?></div>
            </div>
            <?php endforeach; ?>
        </div>

        <hr style="border: 0; border-top: 1px solid #2d445a; margin: 40px 0;">

        <h2>Active Intelligence</h2>
        <p>Current heroes deployed in the field.</p>
        
        <table>
            <thead>
                <tr>
                    <th>Hero</th>
                    <th>Level</th>
                    <th>Class</th>
                    <th>Current Location</th>
                </tr>
            </thead>
            <tbody>
                <?php if($online_players->num_rows > 0): ?>
                    <?php while($p = $online_players->fetch_assoc()): ?>
                    <tr>
                        <td><span class="online-indicator">●</span><?php echo $p['name']; ?></td>
                        <td><?php echo $p['level']; ?></td>
                        <td style="color: #fff;"><?php echo getClassName($p['class']); ?></td>
                        <td style="color: #bdccdb; font-style: italic;"><?php echo getZoneName($p['zone']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="4">No active signals found in Northrend...</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
