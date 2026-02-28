<?php
session_start();
if (!isset($_SESSION['account_id'])) { header("Location: login.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'auth'); // Update password if needed
    $stmt = $conn->prepare("INSERT INTO website_reports (account_id, type, subject, description) VALUES (?, 'BUG', ?, ?)");
    $stmt->bind_param("iss", $_SESSION['account_id'], $_POST['subject'], $_POST['details']);
    $stmt->execute();
    $success = "Bug report submitted to the engineering team!";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bug Tracker | Hazardous War</title>
    <style>
        body { background: #050a12; color: #d1e1f0; font-family: "Palatino Linotype", serif; margin: 0; text-align: center; }
        .nav-bar { background: rgba(10, 20, 35, 0.95); border-bottom: 2px solid #3c5a7a; padding: 15px; }
        .nav-bar a { color: #fff; text-decoration: none; margin: 0 15px; font-size: 13px; text-transform: uppercase; }
        .container { max-width: 600px; margin: 50px auto; background: rgba(10, 15, 25, 0.9); padding: 30px; border: 1px solid #00aeff; border-radius: 4px; }
        h1 { color: #00aeff; text-transform: uppercase; letter-spacing: 5px; }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; background: #000; border: 1px solid #3c5a7a; color: #fff; box-sizing: border-box; }
        .btn-frost { background: linear-gradient(to bottom, #3c5a7a, #1a2a3a); border: 1px solid #00aeff; color: white; padding: 12px 30px; cursor: pointer; text-transform: uppercase; width: 100%; }
        .btn-frost:hover { background: #00aeff; color: #000; }
    </style>
</head>
<body>
    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Bug Tracker</h1>
        <?php if(isset($success)) echo "<p style='color:#1eff00'>$success</p>"; ?>
        <form method="POST">
            <input type="text" name="subject" placeholder="Bug Location (e.g. Stormwind Bank)" required>
            <textarea name="details" rows="5" placeholder="Describe the glitch..." required></textarea>
            <button type="submit" class="btn-frost">Submit Report</button>
        </form>
    </div>
</body>
</html>