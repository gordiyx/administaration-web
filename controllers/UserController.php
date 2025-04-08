<?php
class UserController {
    private $userModel;

    // Constructor initializes the controller with the UserModel instance
    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    // Display the list of all users
    public function listUsers() {
        $users = $this->userModel->getAllUsers();
        include 'views/users/list.php'; // View for displaying users
    }

    // Show the form for adding a new user
    public function showAddForm() {
        include 'views/users/add.php'; // View for adding a new user
    }

    // Handle the form submission to add a new user
    public function addUser() {
        // Retrieve user input from POST request
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone = $_POST['phone'];
        $office = $_POST['office'];
        $description = $_POST['description'];

        // Pass the data to the model to create the new user
        $this->userModel->addUser($name, $surname, $email, $phone, $office, $description, $password);

        // Redirect to the user list
        header("Location: index.php?controller=user&action=list");
    }

    // Show the form to edit an existing user
    public function showEditForm($id) {
        $user = $this->userModel->getUserById($id);
        include 'views/users/edit.php'; // View for editing the user
    }

    // Handle the form submission to update an existing user
    public function updateUser($id) {
        // Retrieve updated data from POST request
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $office = $_POST['office'];
        $description = $_POST['description'];

        // Pass the updated data to the model
        $this->userModel->updateUser($id, $name, $surname, $email, $phone, $office, $description);

        // Redirect to the user list
        header("Location: index.php?controller=user&action=list");
    }

    // Handle user deletion
    public function deleteUser($id) {
        header('Content-Type: application/json');

        // Check if the request method is DELETE
        if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            try {
                // Attempt to delete the user using the model
                $this->userModel->deleteUser($id);
                echo json_encode(['status' => 'success']);
            } catch (Exception $e) {
                // Return error if deletion fails
                http_response_code(500); // Internal Server Error
                echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
            }
            exit;
        }

        // Fallback redirect if request is not DELETE
        header("Location: index.php?controller=user&action=list");
    }
}
?>
