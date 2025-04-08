
const mysql = require('mysql2');


const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'root',
  database: 'admin_interface'
});


connection.connect((err) => {
  if (err) {
    console.error('Chyba při připojení k databázi: ' + err.stack);
    return;
  }
  console.log('Připojeno k databázi jako id ' + connection.threadId);
});

module.exports = connection;  
