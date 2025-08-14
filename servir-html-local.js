const http = require('http');
const fs = require('fs');
const path = require('path');

const PORT = 8080;

const server = http.createServer((req, res) => {
    // Servir el archivo index.html
    if (req.url === '/' || req.url === '/index.html') {
        fs.readFile(path.join(__dirname, 'index.html'), (err, content) => {
            if (err) {
                res.writeHead(500);
                res.end('Error al cargar el archivo HTML');
                return;
            }
            res.writeHead(200, { 'Content-Type': 'text/html' });
            res.end(content);
        });
    } else {
        res.writeHead(404);
        res.end('Página no encontrada');
    }
});

server.listen(PORT, () => {
    console.log(`Servidor ejecutándose en http://localhost:${PORT}`);
    console.log('Presiona Ctrl+C para detener el servidor');
}); 