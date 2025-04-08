const express = require('express');
const db = require('./db'); 
const router = express.Router();


function sendJson(res, data, statusCode = 200) {
  res.status(statusCode).json(data);
}


router.get('/users/:id?', (req, res) => {
  const id = req.params.id;

  if (id) {
    db.query('SELECT * FROM users WHERE id = ?', [id], (err, results) => {
      if (err) {
        console.error('Chyba při vykonávání dotazu:', err);
        return sendJson(res, { error: 'Chyba při vykonávání dotazu' }, 500);
      }
      if (results.length === 0) {
        return sendJson(res, { message: 'User not found' }, 404);
      }
      sendJson(res, results[0]);
    });
  } else {
    
    db.query('SELECT * FROM users', (err, results) => {
      if (err) {
        console.error('Chyba při vykonávání dotazu:', err);
        return sendJson(res, { error: 'Chyba při vykonávání dotazu' }, 500);
      }
      sendJson(res, results);
    });
  }
});

router.post('/users/:action?/:id?', (req, res) => {
    const { action, id } = req.params;
    const { name, surname } = req.body;
  
    if (action === 'update' && id) {
      console.log(`Request action: ${action}, User ID: ${id}, Data:`, { name, surname });
  
 
      if (!name || !surname) {
        return sendJson(res, { error: 'Invalid input. Required fields: name, surname' }, 400);
      }
  
      db.query(
        'UPDATE users SET name = ?, surname = ? WHERE id = ?',
        [name, surname, id],
        (err, results) => {
          if (err) {
            console.error('Chyba při vykonávání dotazu:', err);
            return sendJson(res, { error: err.message }, 500);
          }
          if (results.affectedRows === 0) {
            return sendJson(res, { message: 'User not found' }, 404);
          }
          console.log(`User ID: ${id} successfully updated`);
          sendJson(res, { message: 'User updated' });
        }
      );
    } else {
  
      if (!name || !surname) {
        return sendJson(res, { error: 'Invalid input. Required fields: name, surname' }, 400);
      }
  
      db.query('INSERT INTO users (name, surname) VALUES (?, ?)', [name, surname], (err, results) => {
        if (err) {
          console.error('Chyba při vykonávání dotazu:', err);
          return sendJson(res, { error: err.message }, 500);
        }
        console.log(`New user added:`, { id: results.insertId, name, surname });
        sendJson(res, { message: 'User added', id: results.insertId });
      });
    }
  });
  

router.delete('/users/:id', (req, res) => {
  const id = req.params.id;

  db.query('DELETE FROM users WHERE id = ?', [id], (err, results) => {
    if (err) {
      console.error('Chyba při vykonávání dotazu:', err);
      return sendJson(res, { error: 'Chyba při vykonávání dotazu' }, 500);
    }
    if (results.affectedRows === 0) {
      return sendJson(res, { message: 'User not found' }, 404);
    }
    sendJson(res, { message: 'User deleted' });
  });
});


router.use((req, res) => {
  sendJson(res, { error: 'Method not allowed' }, 405);
});

module.exports = router;
