<?php
include('../includes/db.php');
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: ../pages/index.php");
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 420px;
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: scale(1.02);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
            font-weight: bold;
        }

        label {
            font-size: 1.05em;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        .input-container input {
            width: 100%;
            padding: 12px;
            padding-right: 40px; /* Space for icon */
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1em;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .input-container input:focus {
            border-color: #6c63ff;
            box-shadow: 0 0 8px rgba(108, 99, 255, 0.3);
            outline: none;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 12px;
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
            padding: 12px;
            background: linear-gradient(to right, #667eea, #764ba2);
            color: white;
            font-size: 1.1em;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background: linear-gradient(to right, #5a67d8, #6b46c1);
        }

        .error-message {
            color: #e74c3c;
            font-size: 1em;
            text-align: center;
            margin-top: 10px;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95em;
        }

        .register-link a {
            color: #6c63ff;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Secure Login</h2>
        <form method="POST">
            <label for="email">Email:</label>
            <div class="input-container">
                <input type="email" id="email" name="email" required>
            </div>

            <label for="password">Password:</label>
            <div class="input-container">
                <input type="password" id="password" name="password" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <button type="submit" name="login">Login</button>
        </form>

        <?php if (isset($error_message)): ?>
            <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <div class="register-link">
            <p>Don't have an account? <a href="../pages/register.php">Register here</a></p>
        </div>
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



