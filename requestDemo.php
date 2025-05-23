<?php
session_start();
require_once 'dbConnect.php';  // Ensure this file is in the same directory or adjust the path

$success_message = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $company = htmlspecialchars($_POST['company'] ?? '');
    $solution = htmlspecialchars($_POST['solution'] ?? '');
    $interest = htmlspecialchars($_POST['interest'] ?? '');
    $join_events = isset($_POST['join_events']) ? 'Yes' : 'No';

    // Create customer ID (in real use, you'd fetch or insert customer info separately)
    $customerid = uniqid('cust_');

    // Set requested demo date as today + 3 days
    $requestDate = date('Y-m-d', strtotime('+3 days'));
    $submissionDate = date('Y-m-d');

    // Insert into database
    $inserted = insertDemoRequest($customerid, $phone, $solution, $requestDate, $submissionDate);

    if ($inserted) {
        $success_message = "Thank you, $name! Your demo request for $solution has been received.";
    } else {
        $error_message = "Failed to submit demo request. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Request a Demo</title>
    <style>
    
       <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }
        .header { background: #e0b0ff; color: white; text-align: center; padding: 50px 20px; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; color: white; text-decoration: none; border-radius: 5px; }
        .btn-light { background: #f8f9fa; color: #6f4685; }
        .btn-outline-light { border: 2px solid white; }
        .container { width: 90%; margin: auto; padding: 20px 0; text-align: center; }
        .footer { background: #6f4685; color: white; text-align: center; padding: 10px; position: relative; bottom: 0; width: 100%; }
    </style>
    
    </style>
</head>
<body>
<div class="container">
    <h2>Request a Demo</h2>

    <?php if ($success_message): ?>
        <div class="success"><?php echo $success_message; ?></div>
    <?php elseif ($error_message): ?>
        <div class="error"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="name">Full Name:</label>
        <input type="text" name="name" required>

        <label for="email">Email Address:</label>
        <input type="email" name="email" required>

        <label for="phone">Phone Number:</label>
        <input type="text" name="phone" required>

        <label for="company">Company Name:</label>
        <input type="text" name="company" required>

        <label for="solution">Solution of Interest:</label>
        <select name="solution" required>
            <option value="">-- Select a Solution --</option>
            <option value="AI-Powered Virtual Assistant">AI-Powered Virtual Assistant</option>
            <option value="AI-Based Rapid Prototyping">AI-Based Rapid Prototyping</option>
            <option value="AI-Driven Business Intelligence">AI-Driven Business Intelligence</option>
            <option value="AI-Enhanced Cybersecurity">AI-Enhanced Cybersecurity</option>
        </select>

        <label for="interest">What are you interested in?</label>
        <textarea name="interest" rows="4" required></textarea>

        <label><input type="checkbox" name="join_events"> I want to join promotional events</label>

        <button type="submit">Submit Request</button>
    </form>
</div>
</body>
</html>