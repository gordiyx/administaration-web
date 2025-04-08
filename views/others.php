<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center mb-4">Hello Others</h1>

    <!-- Users List Section -->
    <div id="users-list" class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title mb-0">Users List</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="users-table" class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Office</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic rows will be appended here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JS libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    // Load user data via AJAX
    $.ajax({
        url: 'http://localhost/rest.api.json.php',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            console.log('Data received:', data);
            const tableBody = $('#users-table tbody');
            tableBody.empty();
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(function (user) {
                    tableBody.append(`
                        <tr>
                            <td>${user.id}</td>
                            <td>${user.name}</td>
                            <td>${user.surname}</td>
                            <td>${user.email}</td>
                            <td>${user.phone || 'N/A'}</td>
                            <td>${user.office || 'N/A'}</td>
                        </tr>
                    `);
                });
            } else {
                tableBody.append('<tr><td colspan="6" class="text-center text-muted">No users found</td></tr>');
            }
        },
        error: function (xhr, status, error) {
            console.error('Error loading data:', error);
            console.error('Status:', status);
            console.error('Response:', xhr.responseText);
            const tableBody = $('#users-table tbody');
            tableBody.empty();
            tableBody.append(`
                <tr>
                    <td colspan="6" class="text-center text-danger">
                        Error loading data. Please try again later.
                    </td>
                </tr>
            `);
            alert(`Error: ${error}\nStatus: ${status}\nResponse: ${xhr.responseText}`);
        }
    });
});
</script>

</body>
</html>
