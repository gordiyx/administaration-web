<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styl pro notifikaci */
        .notification {
            background-color: #4caf50;
            color: white;
            padding: 15px;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: none;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .notification.error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Users List</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="index.php?controller=user&action=showAddForm" class="btn btn-primary">
                Add New User
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr id="user-<?php echo $user['id']; ?>">
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['surname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td>
                                    <a href="index.php?controller=user&action=showEditForm&id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm me-2">
                                        Edit
                                    </a>
                                    <button class="btn btn-danger btn-sm delete-user" data-id="<?php echo $user['id']; ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notifikace pro úspěch nebo chybu -->
    <div id="deleteNotification" class="notification"></div>

    <script>
    // Funkce pro zobrazení notifikace
    function showNotification(message, isError = false) {
        const notification = document.getElementById('deleteNotification');
        notification.textContent = message;
        notification.classList.toggle('error', isError);
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }

    // Asynchronní mazání uživatelů
    document.querySelectorAll('.delete-user').forEach(button => {
        button.addEventListener('click', async function () {
            const userId = this.getAttribute('data-id');

        if (confirm('Are you sure you want to delete this user?')) {
            try {
                const response = await fetch(`index.php?controller=user&action=deleteUser&id=${userId}`, {
                    method: 'DELETE',
                });

                
                if (response.status === 200) {
                    
                    const userRow = document.getElementById(`user-${userId}`);
                    if (userRow) userRow.remove();
                    showNotification('User deleted successfully!');
                } else {
                    showNotification('Failed to delete user.', true);
                }
            } catch (error) {
                showNotification('An error occurred.', true);
            }
        }
    });
});


</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
