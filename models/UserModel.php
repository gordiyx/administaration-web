<?php
class UserModel {
    private $conn;

    // Constructor accepts a database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Verifies if a user with the given username and password exists
    public function verifyUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Return true if a matching user is found
        if ($result->num_rows > 0) {
            return true;
        }
        return false;
    }

    // Checks if the given user has admin privileges
    public function isAdmin($username) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ? AND is_admin = 1");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }

    // Retrieves all users from the database
    public function getAllUsers() {
        $stmt = $this->conn->query("SELECT * FROM users");
        return $stmt->fetch_all(MYSQLI_ASSOC);
    }

    // Adds a new user to the database
    public function addUser($name, $surname, $email, $phone, $office, $description, $password) {
        $stmt = $this->conn->prepare("INSERT INTO users (name, surname, email, phone, office, description, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $surname, $email, $phone, $office, $description, $password);
        $stmt->execute();
    }

    // Updates an existing user's details
    public function updateUser($id, $name, $surname, $email, $phone, $office, $description) {
        $stmt = $this->conn->prepare("UPDATE users SET name = ?, surname = ?, email = ?, phone = ?, office = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $name, $surname, $email, $phone, $office, $description, $id);
        $stmt->execute();
    }

    // Deletes a user from the database by ID
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Retrieves a single user's data by ID
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>
