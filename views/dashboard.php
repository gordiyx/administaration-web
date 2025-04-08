<!doctype html>
<html lang="en">

<head>
    <title>Simple Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            height: 100vh;
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }

        .main-content {
            margin-left: 250px;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        .header-icon {
            margin-right: 10px;
            color: #6c757d;
        }

        .admin-badge {
            font-size: 0.85em;
        }
    </style>
</head>

<body>


<div class="container-fluid">
    <div class="row">
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 pt-3 pb-3">
        <h1 class="pb-3 border-bottom">Dashboard</h1>
        
        <!-- Users Table Section -->
        <section class="mt-5">
                    <h2>Last 10 Logged In Users</h2>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Last Login</th>
                                    <th>Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                        
                                function displayLastLoggedInUsers() {
                                    global $conn;
                                    $result = $conn->query("SELECT * FROM users ORDER BY last_login DESC LIMIT 10");

                                    // Check if the query returned users
                                    if ($result && $result->num_rows > 0) {
                                        while ($user = $result->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($user['id']) . '</td>';
                                            echo '<td>' . htmlspecialchars($user['name']) . '</td>';
                                            echo '<td>' . htmlspecialchars($user['surname']) . '</td>';
                                            echo '<td>' . htmlspecialchars($user['last_login']) . '</td>';
                                            echo '<td>';
                                            if ($user['is_admin']) {
                                                echo '<span class="badge bg-success admin-badge">Yes</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary admin-badge">No</span>';
                                            }
                                            echo '</td>';
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="5" class="text-center text-muted">No users found.</td></tr>';
                                    }
                                }

                                displayLastLoggedInUsers();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>

      </main>
    </div>
  </div>
  

  <script src="./bootstrap.js"></script>
</body>
</html>
