import mysql.connector
from flask import Flask, request, jsonify
from flask_cors import CORS

app = Flask(__name__)
CORS(app)

# Configuration - Update these with your actual DB info
DB_CONFIG = {
    "host": "localhost",
    "user": "root",
    "password": "your_password", 
    "database": "characters"
}

def get_db_connection():
    return mysql.connector.connect(**DB_CONFIG)

@app.route('/api/purchase', methods=['POST'])
def handle_purchase():
    try:
        data = request.json
        char_id = data.get('char_id')
        item_name = data.get('item_name')

        db = get_db_connection()
        cursor = db.cursor()
        # Logic to send in-game mail
        sql = "INSERT INTO mail (receiver, subject, body, has_items) VALUES (%s, %s, %s, 1)"
        cursor.execute(sql, (char_id, "Shop Purchase", f"You bought {item_name}!"))
        db.commit()
        cursor.close()
        db.close()
        return jsonify({"status": "success", "message": "Item delivered!"})
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)}), 500

@app.route('/api/get_mail/<char_id>', methods=['GET'])
def get_mail(char_id):
    try:
        db = get_db_connection()
        cursor = db.cursor(dictionary=True)
        cursor.execute("SELECT sender, subject, body, has_items FROM mail WHERE receiver = %s", (char_id,))
        messages = cursor.fetchall()
        cursor.close()
        db.close()
        return jsonify({"status": "success", "mail": messages})
    except Exception as e:
        return jsonify({"status": "error", "message": str(e)}), 500

if __name__ == '__main__':
    print("🚀 Hazardous War Server starting on http://127.0.0.1:5000")
    app.run(debug=True, port=5000)