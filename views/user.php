<!doctype html>
<html lang="en">

<head>
  <title>Simple Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php if ($isAdmin): ?>
    <?php
    if ($controller == 'user') {
        switch ($action) {
            case 'list':
                $userController->listUsers();
                break;
            case 'showAddForm':
                $userController->showAddForm();
                break;
            case 'addUser':
                $userController->addUser();
                break;
            case 'showEditForm':
                $id = $_GET['id'] ?? null;
                $userController->showEditForm($id);
                break;
            case 'updateUser':
                $id = $_GET['id'] ?? null;
                $userController->updateUser($id);
                break;
            case 'deleteUser':
                // When the delete request is made via AJAX, we need to handle it.
                if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                    $id = $_GET['id'] ?? null;
                    $userController->deleteUser($id);
                    echo json_encode(['status' => 'success']);
                } else {
                    $id = $_GET['id'] ?? null;
                    $userController->deleteUser($id);
                    header("Location: index.php?controller=user&action=list");
                }
                break;
            default:
                echo "Action not recognized.";
        }
    }
    ?>
<?php else: ?>
    <p>You do not have permission to view this page.</p>
<?php endif; ?>

<script src="./bootstrap.js"></script>
</body>
</html>
