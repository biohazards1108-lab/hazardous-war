<?php
session_start();

// SECURITY: If not logged in, redirect to login page
if (!isset($_SESSION['account_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$accountId = $_SESSION['account_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Dashboard | Hazardous War</title>
    <style>
        /* Matches your Index Styling */
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .nav-bar {
            background: rgba(10, 20, 35, 0.95);
            border-bottom: 2px solid #3c5a7a;
            padding: 15px 0;
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

        .nav-bar a:hover { color: #00aeff; }

        /* Dashboard Panel */
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .panel {
            background: rgba(10, 15, 25, 0.9);
            border: 1px solid #2d445a;
            padding: 40px;
            border-radius: 4px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
        }

        .panel h2 {
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 5px;
            text-shadow: 0 0 10px #00aeff;
            margin-bottom: 30px;
        }

        .info-row {
            background: rgba(255, 255, 255, 0.05);
            padding: 15px;
            margin: 10px 0;
            border-left: 3px solid #00aeff;
            text-align: left;
            display: flex;
            justify-content: space-between;
        }

        .info-label { color: #88a0b5; text-transform: uppercase; font-size: 12px; }
        .info-value { color: #fff; font-weight: bold; }

        /* Buttons */
        .btn-group {
            margin-top: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .btn-frost {
            display: block;
            background: linear-gradient(to bottom, #3c5a7a, #1a2a3a);
            border: 1px solid #00aeff;
            color: white;
            padding: 12px;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s;
        }

        .btn-frost:hover {
            background: #00aeff;
            color: #000;
            box-shadow: 0 0 15px #00aeff;
        }

        .logout-link {
            margin-top: 20px;
            display: block;
            color: #ff4444;
            text-decoration: none;
            font-size: 12px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="gear.php">Vote Shop</a>
        <a href="donations.php">Donate Store</a>
        <a href="logout.php">Logout</a>
    </nav>

    <div class="container">
        <div class="panel">
            <h2>Account Portal</h2>
            
            <p style="color: #a3d8ff; margin-bottom: 25px;">Welcome, Commander <strong><?php echo htmlspecialchars($username); ?></strong></p>

            <div class="info-row">
                <span class="info-label">Account ID</span>
                <span class="info-value">#<?php echo $accountId; ?></span>
            </div>

            <div class="info-row">
                <span class="info-label">Realm Status</span>
                <span class="info-value" style="color: #1eff00;">Online</span>
            </div>

            <div class="btn-group">
                <a href="gear.php" class="btn-frost">Vote Shop</a>
                <a href="donations.php" class="btn-frost">Donate Store</a>
            </div>

            <a href="logout.php" class="logout-link">Exit Session</a>
        </div>
    </div>

    <footer style="text-align: center; padding: 20px; color: #555; font-size: 12px;">
        &copy; 2026 Hazardous War Project.
    </footer>

</body>
</html>