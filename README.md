# WEBA: Admin Interface Project

This project is a web-based administration interface built using PHP, MySQL, and React. It employs MVC architecture, Bootstrap for styling, and a REST API for data handling. The application requires a local server setup using XAMPP.

---

## Prerequisites

1. **Install XAMPP**
   - Download and install [XAMPP](https://www.apachefriends.org/index.html).
   - Ensure the following modules are running:
     - Apache
     - MySQL

2. **Environment Setup**
   - PHP (comes with XAMPP)
   - MySQL (comes with XAMPP)
   - Node.js and npm: [Download Node.js](https://nodejs.org/)

3. **Use Bootstrap for responsive UI design**.
    ```bash
    npm install bootstrap react-bootstrap
    ```

---

## Database Setup
- Open `phpMyAdmin` from XAMPP (`MySQL - Admin`).
- Create a database named `admin_interface` - shell:
  ```sql
  CREATE DATABASE admin_interface;
  ```

Use the following SQL script to create the users table:
```sql
CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    surname VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    office VARCHAR(100),
    description TEXT,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) NOT NULL DEFAULT 0,
    last_login TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```
---


## Key Pages
1. **Dashboard**
    - Displays the last 10 logged-in users.
2. **Users Section**
    - List, add, edit, and delete users.
    - Validation and notifications are implemented.
    - Only admins can manage users.
3. **Items Section**
    - Contains React buttons (no functionality).
4. **Others Section**
    - Displays logs in JSON format using REST API and AJAX.

---

## Project File Structure

Ensure your project folder contains the following structure:
```graphql
├── controllers/
│   └── UserController.php  # Contains PHP logic for managing user actions (login, CRUD operations for users).
├── logs-dashboard/
│   ├── build/              # Compiled production-ready files for React application.
│   ├── node_modules/       # Contains all the npm dependencies for React.
│   ├── public/             # Public assets (HTML templates, images) for the React app.
│   ├── src/                # Source files for the React app.
│   │   ├── components/
│   │   │   ├── Logs.css    # Styling for the LogsDashboard component.
│   │   │   └── LogsDashboard.js # React component to display logs and allow user actions (delete, filter).
│   │   ├── App.css         # Global CSS for the React application.
│   │   ├── App.js          # Main React component that initializes and renders the app.
│   │   ├── App.test.js     # Test file for React components (optional, used for unit testing).
│   │   ├── index.css       # Additional global styles for React.
│   │   ├── index.js        # Entry point for the React application, rendered into `index.html`.
│   │   ├── logo.svg        # Logo file used in the React app.
│   │   ├── reportWebVitals.js # Optional performance reporting for React app.
│   │   └── setupTests.js   # Configuration file for setting up testing in React.
│   ├── .gitignore          # Specifies files and folders to exclude from Git version control.
│   ├── package-lock.json   # Auto-generated file tracking the exact versions of dependencies.
│   └── package.json        # Defines project metadata, dependencies, and npm scripts for React.
├── models/
│   ├── db.php              # PHP script to establish a connection to the MySQL database.
│   └── UserModel.php       # Contains PHP code for interacting with the `users` database table (CRUD operations).
├── node/
│   ├── node_modules/       # Contains npm dependencies for the Node.js backend.
│   ├── db.js               # Node.js script to connect to the MySQL database.
│   ├── endpoint.js         # Defines REST API routes (e.g., GET, POST, DELETE) for user and log data.
│   ├── index.js            # Starts the Node.js server and integrates API endpoints.
│   ├── package-lock.json   # Auto-generated file for tracking dependency versions in Node.js.
│   └── package.json        # Metadata and dependency list for the Node.js project.
├── node_modules/           # Contains npm dependencies shared across PHP and Node.js projects.
├── views/
│   ├── users/
│   ├── bootstrap-icons.css # Stylesheet for Bootstrap icons used in the UI.
│   ├── bootstrap.css       # Core CSS file for Bootstrap (responsive UI framework).
│   ├── bootstrap.js        # JavaScript functionality for Bootstrap components (modals, dropdowns, etc.).
│   ├── dashboard.php       # PHP view for the admin dashboard (displays user statistics and logs).
│   ├── items.php           # Placeholder PHP view for item management (future functionality).
│   ├── login.php           # PHP view for the login page (authentication).
│   ├── others.php          # PHP view that uses AJAX to fetch and display logs from the server.
│   └── user.php            # PHP view for managing user details (CRUD operations for users).
├── db.php                  # Global database connection configuration for the PHP backend.
├── get_logs.php            # PHP script for fetching logs from the database (used by AJAX in the `others.php` view).
├── index.php               # Main entry point for the PHP application, routes requests to appropriate views.
├── package-lock.json       # Auto-generated file for tracking dependency versions (shared project).
├── package.json            # Metadata and dependency list for shared project resources.
├── rest.api.js             # JavaScript-based implementation of REST API functionality (for clients).
├── rest.api.json.php       # PHP script for providing JSON-formatted REST API responses.
├── rest.api.php            # PHP script for handling REST API requests (CRUD operations for the database).

```
---

## Configuration Database

1. Configure the database connection in **models/db.php**:
```php
<?php
$servername = "localhost";
$username = "root"; // use this for login
$password = ""; // use this for login
$dbname = "admin_interface"; // need to create befor login
...
?>
```

2. Add Initial Data Insert `admin` and `user` accounts manually via `phpMyAdmin`:
```sql
INSERT INTO users (name, surname, email, password, is_admin) VALUES
('Admin', 'User', 'admin@mail.com', 'root', 1),
('Regular', 'User', 'user@mail.com', 'user@1USER', 0);
```

---

## Running the Application

- Open a browser and navigate to http://localhost/{project-folder-name}.
- Login using the following credentials:
    - Admin: admin@mail.com | root
    - User: user@mail.com | user@1USER

---

## React Project Setup

1. Use `create-react-app` to initialize the project:
```bash
npx create-react-app logs-dashboard
cd logs-dashboard
```
2. Install dependencies:
```bash
npm install axios bootstrap react-bootstrap
```

3. **Organize the project structure:**
```graphql
├── build/                # Folder for production-ready React application (generated after `npm run build`).
├── node_modules/         # Contains npm dependencies required for the project.
├── public/               # Public folder for static assets and the root `index.html` file.
├── src/                  # Source folder containing all the core React files.
│   ├── components/       # Folder for React components used in the application.
│   │   ├── LogsDashboard.js # Main React component to display logs (interactive, includes delete and filter features).
│   │   ├── Logs.css      # Styling for the `LogsDashboard.js` component.
│   ├── App.css           # Global CSS for the React application.
│   ├── App.js            # Main application component; renders `LogsDashboard`.
│   ├── App.test.js       # Unit tests for the React application.
│   ├── index.css         # Global CSS file applied to the root of the React application.
│   ├── index.js          # Entry point for the React app, which renders the `App` component to the DOM.
│   ├── logo.svg          # SVG logo (default placeholder from `create-react-app`).
│   ├── reportWebVitals.js # Optional script to measure and report performance of the app.
│   ├── setupTests.js     # Setup file for running tests with Jest.
├── .gitignore            # Specifies files and folders to exclude from Git version control.
├── package-lock.json     # Auto-generated file that ensures consistent dependency versions.
├── package.json          # Metadata and dependencies for the React project.

```

- Run the development server:
```bash
npm start
```
- To build for production:
```bash
npm run build
```
- Open a browser and navigate to:
```bash
http://localhost:3000
```

5. PHP API Integration - Connect to Database
Ensure the PHP backend script `get_logs.php` is functioning. The script should return logs in the JSON format. Use the browser developer tools or a tool like `Postman` to confirm the API endpoint `http://localhost/get_logs.php` returns valid data.

---

## Node.js API Setup

1. Navigate to the node folder:
```bash
cd node
```
2. Install dependencies:
```bash
npm install
```
3. Start the Node.js server:
```bash
node index.js
```

---

## REST API Endpoints

REST API `(rest.api.php)`
```php
    GET: Retrieve all users.
    GET /id: Retrieve a user by ID.
    POST: Add a new user.
    UPDATE /id: Update a user.
    DELETE /id: Delete a user.
```

JSON API *(rest.api.json.php)*
```php
    Provides JSON-formatted data for AJAX calls.
```

---

## AJAX and MVC Integration

- AJAX in `views/others.php`: Dynamically fetches and displays logs from the REST API - Load user data via AJAX.
    ```php
    $(document).ready(function () {
    $.ajax({
        url: 'http://localhost/rest.api.json.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            ...
    ```

- MVC in User Management:
    `controllers/UserController.php`: Handles user-related operations.
    `models/UserModel.php`: Interfaces with the database for CRUD operations.
    `views/users/`: Contains user management UI components.

---

## Implementing REST API in Node.js

The API uses `db.js` for database interactions, `endpoint.js` for route handling, and `index.js` to run the server. It also includes instructions for testing the API with `Postman` and accessing it at `http://localhost:3000`.

**Project Structure**
```java
node/
├── node_modules/
├── db.js          # Handles database connection
├── endpoint.js    # Defines API routes
├── index.js       # Starts the server
├── package.json   # Node.js dependencies and scripts
├── package-lock.json
```

**Steps to Implement REST API**

1. Initialize the project:
```bash
mkdir node
cd node
npm init -y
```

2. Install necessary dependencies:
```bash
npm install express mysql body-parser
```

**Testing the API with Postman**

To test the API, install the Postman Desktop Application. Since the project runs locally, a browser-based Postman instance will not work.
Run server 
```bash
node index.js
```

1. Installing Postman
2. Testing API Endpoints
- `GET /logs`: `http://localhost:3000/users`
- `POST /logs` > Body (JSON):
``` json
{
  "name": "Sample Log",
  "description": "This is a test log entry."
}
```
- `DELETE /logs/id`
URL: http://localhost:3000/users/1. 1 - id.



