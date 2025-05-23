<?php
session_start();

require_once 'dbConnect.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_event'])) {
    $title = trim($_POST['eventname'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $datetime = trim($_POST['eventdatetime'] ?? '');

    if (empty($title) || empty($description) || empty($datetime)) {
        $error = 'Please fill in all fields.';
    } else {
        try {
            $pdo = getDbConnection();

            $stmt = $pdo->prepare("INSERT INTO eventt (eventname, description, eventdatetime) VALUES (:eventname, :description, :eventdatetime)");
            $stmt->execute([
                'eventname' => $title,
                'description' => $description,
                'eventdatetime' => $datetime
            ]);

            $message = 'New promotional event created successfully.';
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
    <title>Create New Promotional Event</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f9; margin: 0; padding: 0; }
        .container { max-width: 500px; margin: 50px auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(111, 70, 133, 0.2); }
        h1 { color: #6f4685; text-align: center; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="date"], textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; }
        textarea { resize: vertical; height: 100px; }
        button { background: #6f4685; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; }
        button:hover { background: #59366f; }
        .message { margin-bottom: 15px; padding: 10px; border-radius: 5px; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
        .back-link { display: block; margin-top: 20px; text-align: center; }
        .back-link a { color: #6f4685; text-decoration: none; font-weight: bold; }
        .back-link a:hover { text-decoration: underline; }
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }
        .header { background: #e0b0ff; color: white; text-align: center; padding: 50px 20px; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; color: white; text-decoration: none; border-radius: 5px; }
        .btn-light { background: #f8f9fa; color: #6f4685; }
        .btn-outline-light { border: 2px solid white; }
        .footer { background: #6f4685; color: white; text-align: center; padding: 10px; position: relative; bottom: 0; width: 100%; }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="aiSolutionsSite.php"img src="../images/Logo.png"> </a>
        <a href="aiSolutionsSite.php">Home</a>
        <a href="about.php">About</a>
        <a href="solutions.php">Solutions</a>
        <a href="demo.php">Request a Demo</a>
        <a href="events.php">Events</a>
        <a href="contact.php">Contact</a>

    </div>


    <div class="container">
        <h1>Create New Promotional Event</h1>

        <?php if ($message): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="createNewEvent.php">
            <div class="form-group">
                <label for="title">Event Title</label>
                <input type="text" id="title" name="eventname" required />
            </div>
            
            
            <div class="form-group">
                <label for="description">Event Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <label for="date">Event Date</label>
                <input type="datetime-local"  id="date" name="eventdatetime" required />
            </div>

            <button type="submit" name="create_event">Create Event</button>
        </form>
    
        <div class="back-link">
            <a href="adminDashboard.php">&larr; Back to Admin Dashboard</a>
        </div>
    </div>
</body>
</html>
