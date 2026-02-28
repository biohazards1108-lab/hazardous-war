import mysql.connector
import requests
import time
import subprocess

# --- CONFIGURATION ---
DB_CONFIG = {
    'host': '127.0.0.1',
    'user': 'root',
    'password': 'ascent', 
    'auth_db': 'auth',
    'char_db': 'characters'
}

WEBHOOKS = {
    'leveling': 'https://discord.com/api/webhooks/1477185331819446384/f2jjOMxl96A4NUH0P_83M0vPJ7kdTUZqbylarW1nffNSVfZbfdheEEe0VB92BFY-YK6a',
    'raids': 'https://discord.com/api/webhooks/1477185003367432273/lMzm83NUjvpdQXruXtV7GfR-MC4-OLZCD3TqfvOEJVXpmYLkwXpdVHRsLbLkzXt4Mh6Y',
    'security': 'https://discord.com/api/webhooks/1477181942045606031/tvNItu_wtZovWojyj20OlIpkrMxi5Jj513eWAIA_tcQ5pB7j-oBcfuQ0Tk84qc7PUJ9O'
}

# Achievements for Leaderboard Calculation
MAJOR_BOSS_IDS = [456, 460, 453, 454, 455, 459, 461, 462, 2891, 2894, 3117, 3917, 3918, 574, 575]

CHECK_INTERVAL = 30 
announced_ids = set() 
current_top_player = None # Tracks who is #1

def send_discord(channel, message):
    url = WEBHOOKS.get(channel)
    if url:
        try:
            requests.post(url, json={"content": message})
        except:
            print(f"Failed to ping {channel}")

def is_process_running(process_name):
    try:
        output = subprocess.check_output('tasklist', shell=True).decode()
        return process_name.lower() in output.lower()
    except:
        return False

def run_watchdog():
    global current_top_player
    print("❄️ Hazardous War Watchdog: Ultimate Edition Active")
    server_was_up = True

    while True:
        # 1. SERVER STATUS CHECK
        server_now_up = is_process_running("worldserver.exe")
        if server_was_up and not server_now_up:
            send_discord('security', "🚨 **CRITICAL ALERT:** The World Server is OFFLINE! @everyone")
        elif not server_was_up and server_now_up:
            send_discord('security', "✅ **RECOVERY:** The World Server is back online.")
        server_was_up = server_now_up

        try:
            conn = mysql.connector.connect(**DB_CONFIG)
            cursor = conn.cursor(dictionary=True)

            # 2. LEVEL 80 & BOSS KILL CHECKS (Same as before)
            # ... (omitted for brevity, keep your existing boss logic here)

            # 3. LEADERBOARD WATCHER
            ids_list = ",".join(map(str, MAJOR_BOSS_IDS))
            leader_query = f"""
                SELECT c.name, COUNT(a.achievement) as boss_kills 
                FROM {DB_CONFIG['char_db']}.characters c
                JOIN {DB_CONFIG['char_db']}.character_achievement a ON c.guid = a.guid
                WHERE a.achievement IN ({ids_list})
                GROUP BY c.guid
                ORDER BY boss_kills DESC, c.level DESC
                LIMIT 1
            """
            cursor.execute(leader_query)
            top_hero = cursor.fetchone()

            if top_hero:
                if current_top_player is None:
                    current_top_player = top_hero['name']
                elif top_hero['name'] != current_top_player:
                    # A new player has taken the lead!
                    send_discord('raids', f"👑 **NEW KINGSGLAIVE:** `{top_hero['name']}` has just taken the #1 spot on the Hall of Heroes with {top_hero['boss_kills']} raid clears!")
                    current_top_player = top_hero['name']

            conn.close()
        except Exception as e:
            print(f"Database error: {e}")

        time.sleep(CHECK_INTERVAL)

if __name__ == "__main__":
    run_watchdog()