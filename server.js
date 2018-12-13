const express = require('express');
const app = express();
const path = require('path');

const root = 'dist';
const public = '/public';
// const static = root + public;

app.use(express.static(root));

app.get('/', function (req, res) {
  res.sendFile(path.join(__dirname + '/' + root + '/index.html'));
});
app.get('/:page', function (req, res) {
  res.sendFile(path.join(__dirname + '/' + root + '/index.html'));
});

const port = 8888;

app.listen(port, function () {
  console.log(`🔧 Dev 💻 server is 🔌 plugged on 🌍 http://localhost:${port} has 🚀 started`);
});
