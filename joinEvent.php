<?php
require_once 'dbConnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['eventname'] ?? '';
    $customerEmail = $_POST['customeremail'] ?? '';

    if (empty($eventName) || empty($customerEmail)) {
        $error = "Please fill in all required fields.";
    } else {
        try {
            $pdo = getDbConnection();

            // Insert registration into eventtparticipation table
            $stmt = $pdo->prepare("INSERT INTO eventtparticipation (EVENTNAME, CUSTOMEREMAIL, REGISTRATIONDATETIME) VALUES (?, ?, NOW())");
            $stmt->execute([$eventName, $customerEmail]);

            $success = "You have successfully registered for the event.";
        } catch (PDOException $e) {
            $error = "Error registering for event: " . $e->getMessage();
        }
    }
} else {
    // GET request, show registration form
    $eventName = $_GET['eventname'] ?? '';
    if (empty($eventName)) {
        die("Invalid event name.");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join Event</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .navbar {
            background: #6f4685;
            padding: 10px;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: inline-block;
        }
        .navbar a:hover {
            background: #c9a0ff;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            color: #6f4685;
            text-align: center;
            margin-bottom: 30px;
        }
        form label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
            color: #6f4685;
        }
        form input[type="text"], form input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1em;
        }
        form button {
            margin-top: 30px;
            padding: 12px 20px;
            background-color: #6f4685;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }
        form button:hover {
            background-color: #5a3668;
        }
        .message {
            max-width: 600px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 6px;
            font-size: 1em;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .back-link {
            display: block;
            max-width: 600px;
            margin: 30px auto 0;
            text-align: center;
        }
        .back-link a {
            background-color: #6f4685;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .back-link a:hover {
            background-color: #5a3668;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="aiSolutionsSite.php">Home</a>
        <a href="about.php">About</a>
        <a href="solutions.php">Solutions</a>
        <a href="demo.php">Request a Demo</a>
        <a href="events.php">Events</a>
        <a href="contact.php">Contact</a>
        <a href="feedback.php">Feedback</a>
    </div>

    <div class="container">
        <h1>Join Event</h1>

        <?php if (!empty($success)): ?>
            <div class="message success"><?php echo htmlspecialchars($success); ?></div>
            <div class="back-link"><a href="events.php">Back to Events</a></div>
        <?php else: ?>
            <?php if (!empty($error)): ?>
                <div class="message error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="post" action="joinEvent.php">
                <label for="eventname">Event Name:</label>
                <input type="text" id="eventname" name="eventname" value="<?php echo htmlspecialchars($eventName ?? ''); ?>" required>

                <label for="customeremail">Email:</label>
                <input type="email" id="customeremail" name="customeremail" required>

                <button type="submit">Register</button>
            </form>
            <div class="back-link"><a href="events.php">Back to Events</a></div>
        <?php endif; ?>
    </div>
</body>
</html>
