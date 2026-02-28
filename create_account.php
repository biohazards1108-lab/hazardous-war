<?php
// Database connection
$conn = new mysqli("localhost", "root", "ascent", "auth", 8080); // Adjusted for your port 8080

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtoupper($_POST['username']);
    $password = strtoupper($_POST['password']);
    
    // Using the 255 length we fixed in your database!
    $verifier = password_hash($password, PASSWORD_DEFAULT); 

    $stmt = $conn->prepare("INSERT INTO account (username, verifier) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $verifier);

    if ($stmt->execute()) {
        // Smooth transition redirect
        $message = "Account Created! Redirecting...";
        header("refresh:2;url=dashboard.php");
    } else {
        $message = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Account | Icy North</title>
    <style>
        body {
            background: #050a0f; /* Deep dark blue-black */
            color: #d1e8ff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            /* Icy vignette effect */
            background-image: radial-gradient(circle, rgba(0,183,255,0.05) 0%, rgba(0,0,0,1) 80%);
        }

        /* Layout Container */
        .wrapper {
            display: flex;
            gap: 20px;
            width: 900px;
        }

        /* Main Registration Box */
        .container {
            flex: 2;
            background: rgba(10, 20, 30, 0.9);
            padding: 40px;
            border-radius: 8px;
            border: 1px solid #1a3a5a;
            box-shadow: 0 0 30px rgba(0, 162, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        /* Icy Header */
        h2 {
            margin-top: 0;
            color: #87cefa;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 0 0 10px rgba(135, 206, 250, 0.5);
            border-bottom: 2px solid #1a3a5a;
            padding-bottom: 10px;
        }

        /* Side Panel for Quests */
        .side-panel {
            flex: 1;
            background: rgba(5, 15, 25, 0.8);
            border-left: 3px solid #007bff;
            padding: 20px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        .side-panel h3 {
            color: #00bfff;
            font-size: 1.1em;
            margin-top: 0;
        }

        .quest-item {
            margin-bottom: 15px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid #14283d;
        }

        /* Form Styling */
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: #0d1b2a;
            border: 1px solid #1a3a5a;
            color: white;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(to bottom, #1e90ff, #0056b3);
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
        }

        button:hover {
            background: #1e90ff;
            box-shadow: 0 0 15px rgba(30, 144, 255, 0.6);
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #5c7d9d;
            text-decoration: none;
            transition: 0.3s;
        }

        .back-link:hover { color: #87cefa; }
    </style>
</head>
<body>

<div class="wrapper">
    <div class="container">
        <h2>Create Account</h2>
        <?php if($message) echo "<p style='color:#00ffcc;'>$message</p>"; ?>
        
        <form method="POST">
            <label>Username</label>
            <input type="text" name="username" required placeholder="Enter Username...">
            
            <label>Password</label>
            <input type="password" name="password" required placeholder="Enter Password...">
            
            <button type="submit">Begin Journey</button>
        </form>
        
        <a href="dashboard.php" class="back-link">← Back to main dashboard</a>
    </div>

    <div class="side-panel">
        <h3>Available Quests</h3>
        <div class="quest-item">
            <strong>❄️ The Frozen Trial</strong>
            <p>Reach Level 10 to unlock basic mounts.</p>
        </div>
        <div class="quest-item">
            <strong>⚔️ Custom Bounty</strong>
            <p>Defeat 50 creeps in the Northlands.</p>
        </div>
        <div class="quest-item">
            <strong>💎 Collector's Luck</strong>
            <p>Gather 10 rare crystals from the ice caves.</p>
        </div>
    </div>
</div>

</body>
</html>
