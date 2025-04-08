<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
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
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Add New User</h2>

    <!-- Notifikace -->
    <div id="notification" class="notification">User successfully added!</div>

    <div class="row justify-content-center">
    <div class="col-md-6">
        <form id="addUserForm" action="index.php?controller=user&action=addUser" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="surname" class="form-label">Surname</label>
                <input type="text" id="surname" name="surname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" id="phone" name="phone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="office" class="form-label">Office</label>
                <input type="text" id="office" name="office" class="form-control">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div id="passwordError" class="error"></div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add User</button>
        </form>
    </div>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Funkce pro validaci hesla
    function validatePassword(password) {
        const errors = [];

        if (password.length < 8) {
            errors.push("Password must be at least 8 characters long.");
        }
        if (!/[A-Z]/.test(password)) {
            errors.push("Password must contain at least one uppercase letter.");
        }
        if (!/[a-z]/.test(password)) {
            errors.push("Password must contain at least one lowercase letter.");
        }
        if (!/[0-9]/.test(password)) {
            errors.push("Password must contain at least one digit.");
        }
        if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            errors.push("Password must contain at least one special character.");
        }

        return errors;
    }

    // Validace formuláře před odesláním
    document.getElementById('addUserForm').addEventListener('submit', function (e) {
        const form = e.target;
        const email = form.email.value;
        const password = form.password.value;

        // Validace emailu
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
            alert('Please enter a valid email address.');
            e.preventDefault();
            return;
        }

        // Rozšířená validace hesla
        const passwordErrors = validatePassword(password);
        const passwordErrorDiv = document.getElementById('passwordError');

        if (passwordErrors.length > 0) {
            passwordErrorDiv.innerHTML = passwordErrors.join('<br>');
            e.preventDefault(); // Zabrání odeslání formuláře
            return;
        } else {
            passwordErrorDiv.innerHTML = ''; // Vyčistit chyby, pokud nejsou
        }

        // Zobrazení notifikace po úspěšném vložení (simulace)
        const notification = document.getElementById('notification');
        notification.style.display = 'block';
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000); // Notifikace zmizí po 3 sekundách
    });
</script>

</body>
</html>
