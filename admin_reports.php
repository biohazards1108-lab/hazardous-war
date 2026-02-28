<?php
session_start();
// Replace '1' with your actual Account ID from HeidiSQL (The Admin Account)
if (!isset($_SESSION['account_id']) || $_SESSION['account_id'] != 1) {
    die("Access Denied: You are not an Administrator.");
}

$conn = new mysqli('localhost', 'root', '', 'auth');
$result = $conn->query("SELECT * FROM website_reports ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Intel | Hazardous War</title>
    <style>
        body { background: #050a12; color: #fff; font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background: rgba(10, 20, 35, 0.9); }
        th, td { border: 1px solid #3c5a7a; padding: 12px; text-align: left; }
        th { background: #00aeff; color: #000; text-transform: uppercase; }
        .type-BUG { color: #00aeff; font-weight: bold; }
        .type-BULLYING { color: #ff4444; font-weight: bold; }
    </style>
</head>
<body>
    <h1>Incoming Intelligence Reports</h1>
    <table>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Subject/Offender</th>
            <th>Description</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['created_at']; ?></td>
            <td class="type-<?php echo $row['type']; ?>"><?php echo $row['type']; ?></td>
            <td><?php echo htmlspecialchars($row['subject']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
