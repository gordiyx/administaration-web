const express = require('express');
const app = express();
const router = require('./endpoint');  // Import your route
const cors = require('cors');

// Middleware
app.use(cors());  // Enable CORS
app.use(express.json());  // Parse incoming JSON

// Use the router for your endpoints
app.use('/api', router);

// Test route
app.get('/', (req, res) => {
  res.send('Hello World');
});

// Start the server
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
