const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 3000;

const server = http.createServer((req, res) => {
  // Servir la página de prueba
  const filePath = path.join(__dirname, 'public', 'test.html');
  
  fs.readFile(filePath, (err, content) => {
    if (err) {
      res.writeHead(500, { 'Content-Type': 'text/plain' });
      res.end(`Error: ${err.message}`);
      return;
    }
    
    res.writeHead(200, { 'Content-Type': 'text/html' });
    res.end(content);
  });
});

server.listen(PORT, 'localhost', () => {
  console.log(`Servidor de prueba ejecutándose en http://localhost:${PORT}/`);
  console.log('Presiona Ctrl+C para detener el servidor');
}); 