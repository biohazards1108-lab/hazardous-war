<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>How to Connect | Hazardous War</title>
    <style>
        body { background: #050a12; color: #d1e1f0; font-family: "Palatino Linotype", serif; margin: 0; text-align: center; }
        .container { max-width: 800px; margin: 50px auto; background: rgba(10, 15, 25, 0.9); padding: 40px; border: 1px solid #3c5a7a; }
        h1 { color: #00aeff; text-transform: uppercase; }
        .step { background: rgba(255,255,255,0.05); padding: 20px; margin: 15px 0; border-left: 4px solid #00aeff; text-align: left; }
        .step h3 { margin: 0; color: #fff; }
        code { background: #000; color: #1eff00; padding: 5px 10px; display: block; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Join the War</h1>
        
        <div class="step">
            <h3>1. Download the Game</h3>
            <p>Ensure you have a 3.3.5a WotLK Client installed.</p>
        </div>

        <div class="step">
            <h3>2. Set Realmlist</h3>
            <p>Open your Data/enUS/realmlist.wtf file and change the content to:</p>
            <code>set realmlist 127.0.0.1</code>
        </div>

        <div class="step">
            <h3>3. Create Account</h3>
            <p>Register on our <a href="register.php" style="color:#00aeff;">Sign Up</a> page and log in!</p>
        </div>
        
        <a href="index.php" style="color:#fff; text-decoration:none;">← Back to Home</a>
    </div>
</body>
</html>
