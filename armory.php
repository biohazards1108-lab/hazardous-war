<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HazardousWar | Armory Shop</title>
    <style>
        * { cursor: url('https://cur.cursors-4u.net/games/gam-4/gam388.cur'), auto !important; }
        
        :root {
            --wow-gold: #f8b700;
            --panel-bg: rgba(10, 10, 10, 0.95);
            --border-color: #5a4a32;
        }

        body {
            background: #050505 url('https://worldofwarcraft.blizzard.com/static/images/layout/bg-body-tertiary.jpg') no-repeat center top fixed;
            background-size: cover;
            color: #ccc;
            font-family: 'Georgia', serif;
            margin: 0;
        }

        .header-bar {
            background: linear-gradient(#2a2218, #000);
            border-bottom: var(--wow-gold) 2px solid;
            padding: 20px;
            text-align: center;
        }

        .header-bar h1 {
            margin: 0;
            color: var(--wow-gold);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 24px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .shop-controls {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .search-input, .category-select {
            background: #000;
            border: 1px solid var(--wow-gold);
            color: #fff;
            padding: 10px;
            font-family: 'Georgia', serif;
        }

        .search-input { flex-grow: 1; }

        .armory-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .item-card {
            background: var(--panel-bg);
            border: 1px solid var(--border-color);
            padding: 20px;
            text-align: center;
            transition: 0.3s;
            position: relative;
        }

        .item-card:hover {
            border-color: var(--wow-gold);
            transform: translateY(-5px);
            background: rgba(40, 30, 20, 0.95);
        }

        .item-icon {
            width: 56px;
            height: 56px;
            border: 2px solid #444;
            margin-bottom: 15px;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        .item-price {
            color: #1eff00;
            font-size: 14px;
            margin-bottom: 15px;
            display: block;
        }

        .btn-buy {
            background: linear-gradient(#f8b700, #8a6500);
            border: 1px solid #000;
            padding: 8px 20px;
            color: #000;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            width: 100%;
        }

        .character-box {
            background: rgba(255, 209, 0, 0.1);
            border: 1px solid var(--wow-gold);
            padding: 15px;
            margin-bottom: 25px;
            text-align: center;
        }

        .nav-back {
            color: var(--wow-gold);
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            margin-bottom: 10px;
        }

        /* Quality Colors */
        .legendary { color: #ff8000; border-color: #ff8000 !important; }
        .epic { color: #a335ee; border-color: #a335ee !important; }
        .rare { color: #0070dd; border-color: #0070dd !important; }
    </style>
</head>
<body>

<div class="header-bar">
    <a href="index.html" class="nav-back">← Back to Homepage</a>
    <h1>HazardousWar Armory</h1>
</div>

<div class="container">
    <div class="character-box">
        <label for="charName">Target Character Name:</label>
        <input type="text" id="charName" class="search-input" style="max-width: 300px; margin-left: 10px;" placeholder="Enter Name...">
        <p style="font-size: 12px; margin-top: 10px; color: #888;">Items are sent via in-game mail to the character listed above.</p>
    </div>

    <div class="shop-controls">
        <input type="text" id="searchInput" class="search-input" placeholder="Search for items..." onkeyup="filterItems()">
        <select id="catFilter" class="category-select" onchange="filterItems()">
            <option value="all">All Categories</option>
            <option value="weapon">Legendary Weapons</option>
            <option value="mount">Rare Mounts</option>
            <option value="utility">Utility & Bags</option>
            <option value="fun">Fun & Cosmetics</option>
        </select>
    </div>

    <div class="armory-grid" id="armoryGrid">
        </div>
</div>

<script>
    const inventory = [
        { name: "Thunderfury", price: 5000, icon: "inv_sword_39", type: "weapon", rarity: "legendary" },
        { name: "Sulfuras, Hand of Ragnaros", price: 4500, icon: "inv_hammer_unique_lutan", type: "weapon", rarity: "legendary" },
        { name: "Spectral Tiger", price: 2500, icon: "ability_mount_spectraltiger", type: "mount", rarity: "epic" },
        { name: "Ashes of Al'ar", price: 3000, icon: "ability_mount_phoenix_mount", type: "mount", rarity: "legendary" },
        { name: "Amani War Bear", price: 1500, icon: "ability_mount_warbear_low", type: "mount", rarity: "epic" },
        { name: "Teebu's Blazing Longsword", price: 1800, icon: "inv_sword_11", type: "weapon", rarity: "epic" },
        { name: "Quel'Serrar", price: 2000, icon: "inv_sword_41", type: "weapon", rarity: "epic" },
        { name: "Staff of Jordan", price: 800, icon: "inv_staff_13", type: "weapon", rarity: "epic" },
        { name: "36-Slot Soul-Bag", price: 300, icon: "inv_misc_bag_24", type: "utility", rarity: "rare" },
        { name: "Portable Mailbox", price: 500, icon: "inv_letter_15", type: "utility", rarity: "rare" },
        { name: "Field Repair Bot 74G", price: 500, icon: "inv_gizmo_01", type: "utility", rarity: "rare" },
        { name: "1000 Gold Satchel", price: 200, icon: "inv_misc_coin_02", type: "utility", rarity: "rare" },
        { name: "Orb of Deception", price: 400, icon: "inv_misc_orb_02", type: "fun", rarity: "rare" },
        { name: "Super Simian Sphere", price: 600, icon: "inv_misc_orb_05", type: "fun", rarity: "rare" },
        { name: "Savory Deviate Delight x100const inventory = [
        // --- PREVIOUS ITEMS ---
        { name: "Thunderfury", price: 5000, icon: "inv_sword_39", type: "weapon", rarity: "legendary" },
        { name: "Sulfuras, Hand of Ragnaros", price: 4500, icon: "inv_hammer_unique_lutan", type: "weapon", rarity: "legendary" },
        { name: "Spectral Tiger", price: 2500, icon: "ability_mount_spectraltiger", type: "mount", rarity: "epic" },
        { name: "Ashes of Al'ar", price: 3000, icon: "ability_mount_phoenix_mount", type: "mount", rarity: "legendary" },
        { name: "Amani War Bear", price: 1500, icon: "ability_mount_warbear_low", type: "mount", rarity: "epic" },
        { name: "Teebu's Blazing Longsword", price: 1800, icon: "inv_sword_11", type: "weapon", rarity: "epic" },
        { name: "Quel'Serrar", price: 2000, icon: "inv_sword_41", type: "weapon", rarity: "epic" },
        { name: "Staff of Jordan", price: 800, icon: "inv_staff_13", type: "weapon", rarity: "epic" },
        { name: "36-Slot Soul-Bag", price: 300, icon: "inv_misc_bag_24", type: "utility", rarity: "rare" },
        { name: "Portable Mailbox", price: 500, icon: "inv_letter_15", type: "utility", rarity: "rare" },
        { name: "Field Repair Bot 74G", price: 500, icon: "inv_gizmo_01", type: "utility", rarity: "rare" },
        { name: "1000 Gold Satchel", price: 200, icon: "inv_misc_coin_02", type: "utility", rarity: "rare" },
        { name: "Orb of Deception", price: 400, icon: "inv_misc_orb_02", type: "fun", rarity: "rare" },
        { name: "Super Simian Sphere", price: 600, icon: "inv_misc_orb_05", type: "fun", rarity: "rare" },
        { name: "Savory Deviate Delight x100", price: 100, icon: "inv_misc_food_51", type: "fun", rarity: "common" },
        { name: "Tabard of the Void", price: 450, icon: "inv_shirt_purple_01", type: "fun", rarity: "rare" },
        { name: "Skullflame Shield", price: 1200, icon: "inv_shield_01", type: "weapon", rarity: "epic" },
        { name: "Chef's Hat", price: 250, icon: "inv_helmet_15", type: "fun", rarity: "rare" },
        { name: "Warp Stalker Mount", price: 1100, icon: "ability_mount_warpstalker", type: "mount", rarity: "epic" },
        { name: "Deathcharger's Reins", price: 1200, icon: "ability_mount_undeadhorse", type: "mount", rarity: "epic" },

        // --- NEW 15 ITEMS ---
        { name: "Warglaive of Azzinoth (Main)", price: 6000, icon: "inv_weapon_glave_01", type: "weapon", rarity: "legendary" },
        { name: "Warglaive of Azzinoth (Off)", price: 6000, icon: "inv_weapon_glave_02", type: "weapon", rarity: "legendary" },
        { name: "Raven Lord's Reins", price: 1800, icon: "ability_mount_raventusk", type: "mount", rarity: "epic" },
        { name: "Mimiron's Head", price: 3500, icon: "inv_misc_enggizmos_03", type: "mount", rarity: "legendary" },
        { name: "Tabard of Flame", price: 450, icon: "inv_shirt_red_01", type: "fun", rarity: "rare" },
        { name: "Tabard of Frost", price: 450, icon: "inv_shirt_blue_01", type: "fun", rarity: "rare" },
        { name: "Corrupted Ashbringer", price: 7500, icon: "inv_sword_112", type: "weapon", rarity: "legendary" },
        { name: "The Hungering Cold", price: 2200, icon: "inv_sword_97", type: "weapon", rarity: "epic" },
        { name: "Atiesh, Greatstaff of the Guardian", price: 7000, icon: "inv_staff_30", type: "weapon", rarity: "legendary" },
        { name: "X-51 Nether-Rocket X-TREME", price: 2000, icon: "ability_mount_rocketmount", type: "mount", rarity: "epic" },
        { name: "Reins of the Swift Spectral Tiger", price: 4000, icon: "ability_mount_spectraltiger", type: "mount", rarity: "legendary" },
        { name: "Murloc Costume", price: 800, icon: "inv_misc_fish_04", type: "fun", rarity: "epic" },
        { name: "Ogre Pinata", price: 150, icon: "inv_misc_toy_01", type: "fun", rarity: "common" },
        { name: "Zulian Tiger", price: 1600, icon: "ability_mount_jungle-tiger", type: "mount", rarity: "epic" },
        { name: "Carapace of Wendigo", price: 900, icon: "inv_chest_leather_01", type: "utility", rarity: "rare" }
    