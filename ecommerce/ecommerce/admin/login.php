<?php
include '../includes/db.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email belongs to an admin
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Start admin session and redirect to dashboard
        $_SESSION['admin_id'] = $user['id'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<p style='color:red; text-align:center;'>Invalid credentials or not an admin.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(45deg, #4e73df, #1cc88a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            transition: background 0.5s ease-in-out;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            color: #333;
            transform: scale(1);
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: scale(1.05);
        }

        h2 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #666;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1em;
            box-sizing: border-box; /* Ensure padding doesn't affect the width */
            transition: border 0.3s ease;
        }

        input:focus {
            border-color: #4e73df;
            box-shadow: 0 0 10px rgba(78, 115, 223, 0.5);
            outline: none;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .toggle-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            opacity: 0.6;
            transition: opacity 0.3s ease;
        }

        .toggle-icon:hover {
            opacity: 1;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff; /* Professional blue button color */
            border: none;
            color: white;
            font-size: 1.1em;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3; /* Darker shade for hover effect */
        }

        .forgot-password {
            margin-top: 10px;
            font-size: 0.9em;
            color: #888;
        }

        .forgot-password a {
            color: #4e73df;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <form method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required>
                <i class="fas fa-eye toggle-icon" onclick="togglePassword()"></i>
            </div>

            <button type="submit" name="login">Login</button>
            <div class="forgot-password">
                <a href="#">Forgot Password?</a>
            </div>
        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const toggleIcon = document.querySelector('.toggle-icon');

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

