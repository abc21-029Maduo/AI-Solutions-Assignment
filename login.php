<?php
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Connect to database
        $conn = new mysqli('127.0.0.1', 'root', '', 'ai_solutions', 3307);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query admin table directly
        $stmt = $conn->prepare("SELECT email, password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if ($password === $user['password']) {
                // Login successful
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_type'] = 'admin';
                $_SESSION['admin_logged_in'] = true;  // Add this session variable for admin login check
                $success = "Login successful! Welcome, " . htmlspecialchars($user['email']) . ".";
                header("Location: adminDashboard.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Admin not found.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }
        .header { background: #e0b0ff; color: white; text-align: center; padding: 50px 20px; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; color: white; text-decoration: none; border-radius: 5px; }
        .btn-light { background: #f8f9fa; color: #6f4685; }
        .btn-outline-light { border: 2px solid white; }
        .container {
            width: 90%;
            margin: 40px auto;
            padding: 30px 40px;
            text-align: left;
            background: #f4e1ff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(111, 70, 133, 0.2);
            max-width: 500px;
            flex-grow: 1;
        }
        .footer {
            background: #6f4685;
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
            position: static;
        }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { display: block; margin-bottom: 5px; }
        button[type="submit"] { display: block; margin-left: 0; padding: 10px 20px; background-color: #6f4685; border: none; color: white; border-radius: 5px; cursor: pointer; }
        button[type="submit"]:hover { background-color: #c9a0ff; }
    </style>
</head>
<body>

<div class="navbar">
    <a href="aiSolutionsSite.php"><img src="../images/Logo.png" alt="Logo"></a>
    <a href="aiSolutionsSite.php">Home</a>
    <a href="about.php">About</a>
    <a href="solutions.php">Solutions</a>
    <a href="demo.php">Request a Demo</a>
    <a href="events.php">Events</a>
    <a href="contact.php">Contact</a>
</div>

<div class="container">
    <h1>Admin Login</h1>
    <?php if (!empty($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php elseif (!empty($success)): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required />
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
        </div>
        <button type="submit">Login</button>
    </form>
</div>

<div class="footer">
    &copy; <?php echo date("Y"); ?> AI Solutions. All rights reserved.
</div>

</body>
</html>