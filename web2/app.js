const express = require('express')
const cookieParser = require('cookie-parser');
const Redis = require('ioredis');
const { v4: uuidv4 } = require('uuid');
const os = require('os');
const { error } = require('console');

const app = express();
app.use(express.json());
app.use(cookieParser());

// membangun koneksi dengan redis
const redis = new Redis({ host: 'redis-cache', port: 6379});
const hostname = os.hostname();

app.post('/api/login', async (req, res)=>{
    const { username } = req.body;
    if(!username) return res.status(400).json({ error: 'nama wajib diisi' });

    const sessionId = uuidv4();
    await redis.set(`session:${sessionId}`, username, 'EX', 3600);
    res.cookie('session_id', sessionId, { httpOnly: true });
    res.json({ message: 'Login Sukses', server: hostname });
});

app.post('/api/vote', async (req, res) => {
    const paslon = req.body.paslon;
    const sessionId = req.cookies.session_id;

    if(!sessionId) return res.status(401).json({ error: 'Anda harus Login!'});

    const username = await redis.get(`session:${sessionId}`);
    if(!username) return res.status(401).json({ error: 'sesi anda telah habis, silahkan login lagi'});

    const sudahNyoblos = await redis.get(`voted:${username}`);
    if (sudahNyoblos) {
        return res.status(400).json({ error: `TOLAK: ${username} sudah menggunakan hak pilih!`});
    }

    await redis.set(`voted:${username}`, 'true');
    await redis.incr(`skor:paslon${paslon}`);

    res.json({ message: `SUKSES: Suara ${username} masuk!`, server: hostname });
})

app.listen(3000, '0.0.0.0', () => {
    console.log("server sedang berjalan")
})