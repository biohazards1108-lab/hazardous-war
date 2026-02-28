<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Rules | Hazardous War</title>
    <style>
        body {
            background-color: #050a12;
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.blz-contentstack.com/v3/assets/blt3452e3b114fab0cd/blt72076046e7f8184c/629910d52579731057e62a4d/wotlk-classic-background.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #d1e1f0;
            font-family: "Palatino Linotype", serif;
            margin: 0;
            line-height: 1.6;
        }

        .nav-bar {
            background: rgba(10, 20, 35, 0.95);
            border-bottom: 2px solid #3c5a7a;
            padding: 15px 0;
            text-align: center;
        }

        .nav-bar a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            background: rgba(10, 15, 25, 0.9);
            border: 1px solid #2d445a;
            padding: 40px;
            border-radius: 4px;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }

        h1 {
            color: #00aeff;
            text-transform: uppercase;
            letter-spacing: 5px;
            text-align: center;
            text-shadow: 0 0 10px #00aeff;
        }

        .rule-section {
            margin-bottom: 30px;
            border-bottom: 1px solid #1a2a3a;
            padding-bottom: 20px;
        }

        .rule-title {
            color: #fff;
            font-weight: bold;
            font-size: 1.2em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
        }

        .rule-title span {
            color: #00aeff;
            margin-right: 15px;
            font-size: 1.5em;
        }

        .rule-content {
            margin-left: 40px;
            color: #bdccdb;
            font-size: 0.95em;
        }

        .warning-box {
            background: rgba(255, 68, 68, 0.1);
            border: 1px solid #ff4444;
            padding: 20px;
            margin-top: 40px;
            text-align: center;
            color: #ff4444;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="register.php">Register</a>
        <a href="dashboard.php">Dashboard</a>
    </nav>

    <div class="container">
        <h1>Laws of the Northrend</h1>
        
        <div class="rule-section">
            <div class="rule-title"><span>01</span> Exploitation & Cheating</div>
            <div class="rule-content">
                The use of third-party software (bots, speed hacks, fly hacks) is strictly prohibited. Exploiting map bugs or spell glitches to gain an advantage will result in a permanent ban.
            </div>
        </div>

        <div class="rule-section">
            <div class="rule-title"><span>02</span> Player Conduct</div>
            <div class="rule-content">
                Harassment, hate speech, or excessive griefing of other players is not tolerated. Keep the world competitive but respectful. Report offenders via the <a href="bullying.php" style="color:#00aeff;">Justice Portal</a>.
            </div>
        </div>

        <div class="rule-section">
            <div class="rule-title"><span>03</span> Account Security</div>
            <div class="rule-content">
                You are responsible for your account. Sharing passwords with others or "buying/selling" accounts for real money (RMT) is a bannable offense.
            </div>
        </div>

        <div class="rule-section">
            <div class="rule-title"><span>04</span> Staff Interaction</div>
            <div class="rule-content">
                Game Masters (GMs) are here to help. Impersonating staff or spreading misinformation about server operations is prohibited.
            </div>
        </div>

        <div class="warning-box">
            By playing on Hazardous War, you agree to abide by these laws. Ignorance is not an excuse.
        </div>
    </div>

</body>
</html>