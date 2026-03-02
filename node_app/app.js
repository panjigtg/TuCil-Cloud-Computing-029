const express = require('express')

const app = express();
app.get('/', (req, res)=>{
    res.send("hello Docker this is app from Node");
});

app.listen(3000, () => {
    console.log("server sedang berjalan")
})