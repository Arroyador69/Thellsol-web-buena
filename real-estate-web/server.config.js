module.exports = {
  port: 3000,
  host: 'localhost',
  secure: true,
  ssl: {
    key: './certificates/localhost-key.pem',
    cert: './certificates/localhost.pem'
  }
}; 