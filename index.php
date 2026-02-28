<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hazardous War | WotLK Private Realm</title>
    <style>
        /* Base Styling */
        body {
            background-color: #050a12;
            background-image: 
                linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)),
                url('https://images.blz-contentstack.com/v3/assets/blt3452e3b114fab0cd/blt72076046e7f8184c/629910d52579731057e62a4d/wotlk-classic-background.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #d1e1f0;
            font-family: "Palatino Linotype", "Book Antiqua", Palatino, serif;
            margin: 0;
        }

        /* Navigation Bar */
        .nav-bar {
            background: rgba(10, 20, 35, 0.95);
            border-bottom: 2px solid #3c5a7a;
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.8);
        }

        .nav-bar a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: color 0.3s;
        }

        .nav-bar a:hover {
            color: #00aeff;
            text-shadow: 0 0 8px #00aeff;
        }

        .nav-bar a.active {
            color: #00aeff;
            border-bottom: 1px solid #00aeff;
        }

        /* Hero Section */
        .hero {
            height: 60vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .hero h1 {
            font-size: 60px;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 10px;
            color: #fff;
            text-shadow: 0 0 20px #00aeff, 4px 4px #000;
        }

        .hero p {
            font-size: 18px;
            color: #a3d8ff;
            max-width: 600px;
            line-height: 1.6;
        }

        /* Feature Sections */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .card {
            background: rgba(10, 15, 25, 0.85);
            border: 1px solid #2d445a;
            padding: 30px;
            border-radius: 4px;
            text-align: center;
            transition: transform 0.3s, border-color 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: #00aeff;
            box-shadow: 0 10px 30px rgba(0, 174, 255, 0.2);
        }

        .card h3 {
            color: #00aeff;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 0;
        }

        .card p {
            font-size: 14px;
            color: #bdccdb;
            margin-bottom: 25px;
        }

        /* Buttons */
        .btn-frost {
            display: inline-block;
            background: linear-gradient(to bottom, #3c5a7a, #1a2a3a);
            border: 1px solid #00aeff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 2px;
            transition: all 0.3s;
        }

        .btn-frost:hover {
            background: #00aeff;
            color: #000;
            box-shadow: 0 0 15px #00aeff;
        }

        /* Armory Special Highlight */
        .armory-card {
            border: 1px solid #ff8000; /* Legendary Orange */
            background: rgba(25, 15, 10, 0.85);
        }
        
        .armory-card h3 {
            color: #ff8000;
        }

        footer {
            text-align: center;
            padding: 40px;
            color: #555;
            font-size: 12px;
            border-top: 1px solid #1a1a1a;
        }
    </style>
</head>
<body>

   <nav class="nav-bar">
    <a href="index.php">Home</a>
    <a href="rules.php">Rules</a>
    <a href="connection.php">How to Connect</a>
    <a href="players.php">Online Players</a>
    
    <?php if(isset($_SESSION['account_id'])): ?>
        <a href="dashboard.php" style="color: #00aeff;">My Account</a>
        <a href="gear.php">Vote Shop</a>
        <a href="donations.php">Donate</a>
        <a href="bugs.php">Bugs</a>
        <a href="logout.php" style="color: #ff4444;">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php" style="border: 1px solid #00aeff; padding: 5px 10px;">Join Now</a>
    <?php endif; ?>
</nav>

    <section class="hero">
        <h1>Hazardous War</h1>
        <p>Conquer the Frozen Wastes of Northrend in the ultimate World of Warcraft private realm experience.</p>
        <div style="margin-top: 30px;">
            <?php if(!isset($_SESSION['account_id'])): ?>
                <a href="register.php" class="btn-frost">Start Your Journey</a>
            <?php else: ?>
                <a href="dashboard.php" class="btn-frost">Manage My Account</a>
            <?php endif; ?>
        </div>
    </section>

    <div class="container">
        <div class="card armory-card">
            <h3>Vote Reward Shop</h3>
            <p>Spend your hard-earned voting points on legendary gear and rare items.</p>
            <a href="gear.php" class="btn-frost" style="border-color: #ff8000;">Enter Shop</a>
        </div>

        <div class="card">
            <h3>Donation Store</h3>
            <p>Support the server and get premium items delivered instantly to your in-game mailbox.</p>
            <a href="donations.php" class="btn-frost">View Store</a>
        </div>

        <div class="card">
            <h3>Bug Tracker</h3>
            <p>Help us improve the realm. Report issues directly to our development team.</p>
            <a href="bugs.php" class="btn-frost">Report Bug</a>
        </div>
    </div>

    <footer>
        &copy; 2026 Hazardous War Project. For educational purposes only.
    </footer>

</body>

</html>
