<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['account_id'])) {
    header("Location: login.php");
    exit();
}

$accountId = $_SESSION['account_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gear Store - Hazardous War</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #1a1a1a; color: white; padding: 40px; }
        .container { max-width: 800px; margin: auto; }
        .header { border-bottom: 2px solid #f3ad1e; padding-bottom: 10px; margin-bottom: 30px; }
        .item-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .item-card { background: #2a2a2a; border: 1px solid #444; padding: 20px; border-radius: 10px; text-align: center; transition: 0.3s; }
        .item-card:hover { border-color: #f3ad1e; transform: translateY(-5px); }
        .price { color: #f3ad1e; font-size: 1.2em; font-weight: bold; }
        select { width: 100%; padding: 10px; margin: 15px 0; border-radius: 5px; background: #111; color: white; border: 1px solid #555; }
        button { background: #f3ad1e; color: black; border: none; padding: 12px 20px; cursor: pointer; font-weight: bold; border-radius: 5px; width: 100%; }
        button:hover { background: #ffc145; }
        .user-info { text-align: right; font-size: 0.9em; color: #aaa; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div class="user-info">Logged in as: <strong><?php echo htmlspecialchars($username); ?></strong> | <a href="logout.php" style="color:#f3ad1e;">Logout</a></div>
        <h1>Vote Reward Shop</h1>
    </div>

    <div class="item-grid">
        <div class="item-card">
            <h3>Standard Gold Pack</h3>
            <p>1,000 Gold delivered to mail</p>
            <p class="price">50 Voting Points</p>
            
            <label>Select Character:</label>
            <select class="char-selector">
                <option value="">-- Loading Characters --</option>
            </select>

            <button onclick="buyItem(this, 12345, 50)">Purchase Now</button>
        </div>

        <div class="item-card">
            <h3>Epic Leveling Sword</h3>
            <p>Heirloom quality weapon</p>
            <p class="price">150 Voting Points</p>
            
            <label>Select Character:</label>
            <select class="char-selector">
                <option value="">-- Loading Characters --</option>
            </select>

            <button onclick="buyItem(this, 22691, 150)">Purchase Now</button>
        </div>
    </div>
</div>

<script>
    // The Account ID from the PHP Session
    const currentAccId = <?php echo $accountId; ?>;

    // 1. Automatically fetch characters when the page loads
    fetch(`http://127.0.0.1:5000/get-characters/${currentAccId}`)
        .then(res => res.json())
        .then(data => {
            const dropdowns = document.querySelectorAll('.char-selector');
            dropdowns.forEach(select => {
                select.innerHTML = '<option value="">-- Select Character --</option>';
                data.forEach(name => {
                    select.innerHTML += `<option value="${name}">${name}</option>`;
                });
            });
        })
        .catch(err => {
            alert("Error: Python Bridge is not running!");
            console.error(err);
        });

    // 2. The Purchase Function
    function buyItem(btnElement, itemId, cost) {
        // Find the specific dropdown for this card
        const charName = btnElement.parentElement.querySelector('.char-selector').value;

        if (!charName) {
            alert("Please select a character first!");
            return;
        }

        if (!confirm(`Spend ${cost} points on this item for ${charName}?`)) return;

        fetch('http://127.0.0.1:5000/buy-with-points', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                account_id: currentAccId,
                character_name: charName,
                item_id: itemId,
                cost: cost
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                alert("SUCCESS: " + data.message);
            } else {
                alert("ERROR: " + data.error);
            }
        })
        .catch(err => alert("Communication error with the server bridge."));
    }
</script>

</body>
</html>