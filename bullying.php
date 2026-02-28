<?php
session_start();
if (!isset($_SESSION['account_id'])) { header("Location: login.php"); exit(); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'auth'); 
    $stmt = $conn->prepare("INSERT INTO website_reports (account_id, type, subject, description) VALUES (?, 'BULLYING', ?, ?)");
    $stmt->bind_param("iss", $_SESSION['account_id'], $_POST['offender'], $_POST['evidence']);
    $stmt->execute();
    $success = "Report filed. A Game Master will investigate shortly.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Harassment | Hazardous War</title>
    <style>
        body { background: #0a0505; color: #f0d1d1; font-family: "Palatino Linotype", serif; margin: 0; text-align: center; }
        .nav-bar { background: rgba(35, 10, 10, 0.95); border-bottom: 2px solid #7a3c3c; padding: 15px; }
        .nav-bar a { color: #fff; text-decoration: none; margin: 0 15px; font-size: 13px; text-transform: uppercase; }
        .container { max-width: 600px; margin: 50px auto; background: rgba(25, 10, 10, 0.9); padding: 30px; border: 1px solid #ff4444; border-radius: 4px; }
        h1 { color: #ff4444; text-transform: uppercase; letter-spacing: 5px; }
        input, textarea { width: 100%; padding: 12px; margin: 10px 0; background: #1a0000; border: 1px solid #7a3c3c; color: #fff; box-sizing: border-box; }
        .btn-report { background: linear-gradient(to bottom, #7a3c3c, #3a1a1a); border: 1px solid #ff4444; color: white; padding: 12px 30px; cursor: pointer; text-transform: uppercase; width: 100%; }
        .btn-report:hover { background: #ff4444; color: #000; }
    </style>
</head>
<body>
    <nav class="nav-bar">
        <a href="index.php">Home</a>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </nav>
    <div class="container">
        <h1>Harassment Report</h1>
        <?php if(isset($success)) echo "<p style='color:#ff8000'>$success</p>"; ?>
        <p style="font-size: 12px; color: #aaa;">Abuse of this system will result in an account ban.</p>
        <form method="POST">
            <input type="text" name="subject" placeholder="Offender's Character Name" required>
            <textarea name="details" rows="5" placeholder="Details of the incident (Times, Chat logs, etc)..." required></textarea>
            <button type="submit" class="btn-report">File Official Complaint</button>
        </form>
    </div>
</body>
</html>