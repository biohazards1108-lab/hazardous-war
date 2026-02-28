<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patch Notes | Hazardous War</title>
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
        }

        .nav-bar {
            background: rgba(10, 20, 35, 0.95);
            border-bottom: 2px solid #3c5a7a;
            padding: 15px 0;
            text-align: center;
        }

        .nav-bar a { color: #fff; text-decoration: none; margin: 0 20px; text-transform: uppercase; font-size: 13px; }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: rgba(10, 15, 25, 0.9);
            border: 1px solid #2d445a;
            padding: 40px;
            border-radius: 4px;
        }

        h1 { color: #00aeff; text-transform: uppercase; letter-spacing: 5px; text-shadow: 0 0 10px #00aeff; }

        .patch-version {
            color: #ff8000; /* Legendary Orange */
            font-size: 1.4em;
            border-bottom: 1px solid #3c5a7a;
            margin-top: 30px;
            padding-bottom: 5px;
            text-align: left;
        }

        .patch-date {
            float: right;
            color: #555;
            font-size: 0.7em;
            margin-top: 10px;
        }

        .change-list {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .change-item {
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            display: flex;
            align-items: flex-start;
        }

        .type-tag {
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-right: 15px;
            min-width: 60px;
            text-align: center;
        }

        .tag-fix { background: #4e0000; color: #ff4444; border: 1px solid #ff4444; }
        .tag-new { background: #004e00; color: #1eff00; border: 1px solid #1eff00; }
        .tag-buff { background: #4e4e00; color: #ffff00; border: 1px solid #ffff00; }

        .description { color: #bdccdb; font-size: 0.95em; }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="changelog.php">Changelog</a>
        <a href="rules.php">Rules</a>
        <a href="dashboard.php">Account</a>
    </nav>

    <div class="container">
        <h1>Development Chronicles</h1>
        <p>Follow the evolution of Hazardous War.</p>

        <div class="patch-version">
            Patch 1.0.2 <span class="patch-date">FEBRUARY 2026</span>
        </div>
        <ul class="change-list">
            <li class="change-item">
                <span class="type-tag tag-new">New</span>
                <span class="description">Added the <b>Vote Reward Shop</b>. Players can now trade points for gear.</span>
            </li>
            <li class="change-item">
                <span class="type-tag tag-fix">Fix</span>
                <span class="description">Resolved a database issue where characters weren't appearing in the dashboard.</span>
            </li>
            <li class="change-item">
                <span class="type-tag tag-buff">Buff</span>
                <span class="description">Increased XP rates for the weekend to 5x.</span>
            </li>
        </ul>

        <div class="patch-version">
            Patch 1.0.1 <span class="patch-date">JANUARY 2026</span>
        </div>
        <ul class="change-list">
            <li class="change-item">
                <span class="type-tag tag-new">New</span>
                <span class="description">Initial server launch. Welcome to <b>Hazardous War</b>!</span>
            </li>
            <li class="change-item">
                <span class="type-tag tag-fix">Fix</span>
                <span class="description">Corrected the Realmlist configuration for external connections.</span>
            </li>
        </ul>

    </div>

</body>
</html>
