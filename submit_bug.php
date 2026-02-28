<?php
// --- CONFIGURATION ---
$webhook_url = "https://discord.com/api/webhooks/1476634364090519622/xcPFqB7Qg3Mip--zu_Y0iYsCbJ6XTsj7Q5AVKPSmestbsuBPFdFfG1zjy-tVtsT4N9XY";
$server_name = "HazardousWar Dev Team";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $char_name = $_POST['char_name'];
    $category  = $_POST['category'];
    $message   = $_POST['description'];
    $evidence  = $_POST['link'] ? $_POST['link'] : "No evidence provided";

    // Build the Discord Embed Message
    $json_data = json_encode([
        "username" => $server_name,
        "avatar_url" => "https://i.imgur.com/your-wow-icon.png", // Optional icon
        "embeds" => [
            [
                "title" => "New Bug Report Received!",
                "type" => "rich",
                "color" => hexdec("f8b700"), // WoW Gold
                "fields" => [
                    [
                        "name" => "Reporter",
                        "value" => $char_name,
                        "inline" => true
                    ],
                    [
                        "name" => "Category",
                        "value" => strtoupper($category),
                        "inline" => true
                    ],
                    [
                        "name" => "Description",
                        "value" => $message,
                        "inline" => false
                    ],
                    [
                        "name" => "Evidence Link",
                        "value" => $evidence,
                        "inline" => false
                    ]
                ],
                "footer" => [
                    "text" => "HazardousWar Bug Tracker",
                ],
                "timestamp" => date("c")
            ]
        ]
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

    // Send the data to Discord
    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);
    curl_close($ch);

    // Redirect back to home with a success message
    echo "<script>alert('Report Sent! Our GMs will investigate.'); window.location.href='index.html';</script>";
}
?>