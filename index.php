<?php 
session_start(); 
// Database Connection for Stats
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'ascent'; 
$db_name = 'characters'; 
$conn_stats = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Logic for Stats Widget
if ($conn_stats->connect_error) {
    $status_text = "OFFLINE";
    $status_color = "#ff4444";
    $online_count = 0;
    $top_hero = "None";
} else {
    $status_text = "ONLINE";
    $status_color = "#1eff00";
    
    // Get Online Count
    $online_res = $conn_stats->query("SELECT COUNT(*) as total FROM characters WHERE online = 1");
    $online_count = $online_res->fetch_assoc()['total'];

    // Get Current Top Hero (Level)
    $top_hero_res = $conn_stats->query("SELECT name FROM characters ORDER BY level DESC, logout_time DESC LIMIT 1");
    $top_hero = $top_hero_res->fetch_assoc()['name'] ?? "None";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hazardous War | WotLK Private Server</title>
    <style>
        body {
            background-color: #050a12;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                url('https://images.blz-contentstack.com/v3/assets/blt3452e3b114fab0cd/blt72076046e7f8184c/629910d52579731057e62a4d/wotlk-classic-background.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #d1e1f0;
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            margin: 0;
            padding: 0;
        }

        /* Navigation */
        .nav-bar {
            background: rgba(10, 20, 35, 0.95);
            border-bottom: 2px solid #3c5a7a;
            padding: 15px 0;
            text-align: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .nav-bar a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: 0.3s;
        }
        .nav-bar a:hover { color: #00aeff; }

        /* Main Container */
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 50px 20px;
            text-align: center;
        }

        .hero-title {
            font-size: 4rem;
            color: #00aeff;
            text-transform: uppercase;
            letter-spacing: 10px;
            text-shadow: 0 0 20px rgba(0, 174, 255, 0.6);
            margin-bottom: 10px;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 40px;
        }

        /* Stats Widget */
        .stats-grid {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }
        .stat-card {
            background: rgba(10, 15, 25, 0.9);
            border: 1px solid #3c5a7a;
            padding: 20px;
            min-width: 220px;
            border-radius: 4px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
        .stat-label { color: #00aeff; font-size: 11px; text-transform: uppercase; letter-spacing: 2px; }
        .stat-value { font-size: 24px; font-weight: bold; margin-top: 5px; }

        /* Buttons */
        .btn-frost {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #00aeff, #0056b3);
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 3px;
            box-shadow: 0 0 15px rgba(0, 174, 255, 0.4);
            transition: 0.3s;
        }
        .btn-frost:hover { transform: translateY(-3px); box-shadow: 0 0 25px #00aeff; }

        /* News Section */
        .news-section {
            background: rgba(10, 15, 25, 0.85);
            border: 1px solid #2d445a;
            padding: 30px;
            text-align: left;
            margin-top: 50px;
        }
        .news-item { border-left: 3px solid #00aeff; padding-left: 20px; margin-bottom: 25px; }
        .news-date { color: #555; font-size: 12px; }
        .news-title { color: #fff; font-size: 18px; margin: 5px 0; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="connection.php">Connection</a>
        <a href="leaderboard.php">Leaderboard</a>
        <a href="players.php">Online</a>
        <a href="media.php">Media</a>
        <a href="changelog.php">Changelog</a>
        <a href="rules.php">Rules</a>
        <?php if(isset($_SESSION['account_id'])): ?>
            <a href="dashboard.php" style="color: #00aeff;">My Account</a>
        <?php else: ?>
            <a href="login.php" style="color: #00aeff;">Login</a>
        <?php endif; ?>
    </nav>

    <div class="container">
        <h1 class="hero-title">Hazard
