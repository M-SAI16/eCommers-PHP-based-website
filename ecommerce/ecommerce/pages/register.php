<?php
include('../includes/db.php');  // Database connection
session_start();

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $role = 'user'; // Default role for users

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "<script>alert('Email is already registered!');</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$email, $password, $role]);

        // Log the user in after successful registration
        $_SESSION['user_id'] = $conn->lastInsertId();
        header("Location: ../pages/login.php"); // Redirect to the login page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #00b894, #8e44ad);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }

        .register-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 420px;
            transition: transform 0.3s ease;
        }

        .register-container:hover {
            transform: scale(1.02);
        }

        h2 {
            text-align: center;
            font-size: 2rem;
            margin-bottom: 20px;
            color: #4A90E2;
        }

        label {
            font-size: 1.1em;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        .input-container {
            position: relative;
            margin-bottom: 18px;
        }

        .input-container input {
            width: 100%;
            padding: 14px;
            padding-right: 40px; /* reserve space for icon */
            border: 1.5px solid #ccc;
            border-radius: 8px;
            font-size: 1.1em;
            transition: border 0.3s ease, box-shadow 0.3s ease;
            box-sizing: border-box;
        }

        .input-container input:focus {
            border-color: #4A90E2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
            outline: none;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 14px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 18px;
        }

        .toggle-password:hover {
            color: #555;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #4A90E2;
            color: white;
            font-size: 1.2em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #357ABD;
            transform: translateY(-2px);
        }

        button:active {
            background-color: #357ABD;
            transform: translateY(0);
        }

        .error-message {
            color: #e74c3c;
            font-size: 1em;
            text-align: center;
            margin-top: 10px;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
            font-size: 1em;
            color: #555;
        }

        .login-link a {
            color: #4A90E2;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px;
            }
            h2 {
                font-size: 1.6rem;
            }
            .input-container input {
                font-size: 1em;
            }
            button {
                font-size: 1.1em;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Create an Account</h2>
        <form method="POST">
            <!-- Email Input -->
            <div class="input-container">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>

            <!-- Password Input -->
            <div class="input-container">
                <label>Password:</label>
                <input type="password" name="password" id="password" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <button type="submit" name="register">Register</button>
        </form>

        <div class="login-link">
            Do you have an account? <a href="login.php">Login here</a>
        </div>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-password');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

