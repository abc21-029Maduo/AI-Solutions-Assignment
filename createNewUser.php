<?php
session_start();

require_once 'dbConnect.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $username = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $pdo = getDbConnection();

            // Check if username already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM admin WHERE email = :email");
            $stmt->execute(['email' => $username]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $error = 'Username already exists. Please choose another.';
            } else {
                // Hash the password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Insert new admin user
                $insertStmt = $pdo->prepare("INSERT INTO admin (email, password, confirmpassword) VALUES (:email, :password, :confirmpassword)");
                $insertStmt->execute(['email' => $username, 'password' => $passwordHash, 'confirmpassword' => $passwordHash]);

                $message = 'New admin user created successfully.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create New Admin User</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(111, 70, 133, 0.2); }
        h1 { color: #6f4685; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
        button { background: #6f4685; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; }
        button:hover { background: #59366f; }
        .message { margin-bottom: 15px; padding: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .back-link { display: block; margin-top: 20px; text-align: center; }
        .back-link a { color: #6f4685; text-decoration: none; font-weight: bold; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Create New Admin User</h1>

        <?php if ($message): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="createNewUser.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required />
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required />
            </div>
            <button type="submit" name="create_admin">Create Admin</button>
        </form>

        <div class="back-link">
            <a href="adminDashboard.php">&larr; Back to Admin Dashboard</a>
        </div>
    </div>
</body>
</html>
