const http = require('http');

const server = http.createServer((req, res) => {
  res.writeHead(200, { 'Content-Type': 'text/html' });
  res.end('<h1>Servidor de prueba funcionando correctamente</h1>');
});

server.listen(3000, 'localhost', () => {
  console.log('Servidor de prueba ejecutándose en http://localhost:3000/');
}); 