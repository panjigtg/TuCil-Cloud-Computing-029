from flask import Flask, jsonify
import redis
import os

app = Flask(__name__)

cache = redis.Redis(host='redis-cache', port=6379, decode_responses=True)

@app.route('/api/skor')
def get_live_score():
    skor1 = cache.get('skor:paslon1') or 0
    skor2 = cache.get('skor:paslon2') or 0
    skor3 = cache.get('skor:paslon3') or 0
    
    return jsonify({
        "paslon1": int(skor1),
        "paslon2": int(skor2),
        "paslon3": int(skor3),
        "server": os.getenv('HOSTNAME', 'Unknown')
    })

if __name__ == '__main__':
    app.run(host="0.0.0.0", port=5000)
    
    