<?php
// 1. Start the session at the VERY top of the file
session_start();

// 2. Database Connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'ascent'; // Enter your HeidiSQL password here
$db_name = 'auth';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3. SRP6 Verifier Calculation (Matches TrinityCore/AzerothCore)
function calculate_verifier($u, $p, $s) {
    $u = strtoupper($u);
    $p = strtoupper($p);
    $h1 = sha1($u . ':' . $p, true);
    $h2 = sha1($s . $h1, true);
    $h2_rev = strrev($h2);
    return gmp_strval(gmp_import($h2_rev), 16);
}

// 4. Handle the Login Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = strtoupper(trim($_POST['username'] ?? ''));
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        // We fetch the ID here so we can use it for the Armory/Donations
        $stmt = $conn->prepare("SELECT id, verifier, salt FROM account WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user_data = $result->fetch_assoc()) {
            $db_id       = $user_data['id'];
            $db_verifier = $user_data['verifier'];
            $db_salt     = hex2bin($user_data['salt']); 

            // Check if the typed password matches the database verifier
            $check_verifier = calculate_verifier($username, $password, $db_salt);

            if ($check_verifier === $db_verifier) {
                // SUCCESS: Save user info to the Session
                $_SESSION['account_id'] = $db_id;
                $_SESSION['username'] = $username;

                echo "<p style='color:green;'>Login successful! Welcome back, " . htmlspecialchars($username) . ".</p>";
                
                // Redirect to dashboard after 2 seconds
                header("Refresh: 2; url=dashboard.php"); 
            } else {
                echo "<p style='color:red;'>Invalid password.</p>";
            }
        } else {
            echo "<p style='color:red;'>Account not found.</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color:orange;'>Please enter both username and password.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Hazardous War</title>
</head>
<body style="background:#1a1a1a; color:white; font-family:sans-serif; text-align:center; padding-top:50px;">
    <h2>Login to Hazardous War</h2>
    <form method="post" style="background:#2a2a2a; display:inline-block; padding:20px; border-radius:10px;">
        Username:<br>
        <input type="text" name="username" required><br><br>
        Password:<br>
        <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <p><a href="register.php" style="color:#f3ad1e;">Don't have an account? Register here.</a></p>
</body>
</html>