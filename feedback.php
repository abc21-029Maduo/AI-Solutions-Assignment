<?php
require_once 'dbConnect.php';

session_start();

$insertError = null;
$insertSuccess = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerid = isset($_POST['customerid']) ? trim($_POST['customerid']) : '';
    $interestarea = isset($_POST['interestarea']) ? trim($_POST['interestarea']) : '';
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;
    $comments = isset($_POST['comments']) ? trim($_POST['comments']) : '';
    $submissionDate = date('Y-m-d');

    // Basic validation
    if (empty($customerid) || empty($interestarea) || $rating < 1 || $rating > 5) {
        $insertError = "Please fill in all required fields and provide a rating between 1 and 5.";
    } else {
        $result = insertFeedback($customerid, $interestarea, $rating, $comments, $submissionDate);
        if ($result === true) {
            $insertSuccess = "Thank you for your feedback!";
        } else {
            $insertError = "Failed to submit feedback. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Feedback | AI-Solutions</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif;}
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }
        .container { width: 90%; margin: 40px auto; padding: 30px 40px; text-align: left; background: #f4e1ff; border-radius: 10px; box-shadow: 0 4px 8px rgba(111, 70, 133, 0.2); max-width: 500px; }
        .footer { background: #6f4685; color: white; text-align: center; padding: 10px; position: relative; bottom: 0; width: 100%; }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { display: block; margin-bottom: 5px; }
        input[type="email"], select, textarea, input[type="number"] { width: 100%; padding: 8px; border-radius: 5px; border: 1px solid #ccc; }
        button[type="submit"] { display: block; margin-left: 0; padding: 10px 20px; background-color: #6f4685; border: none; color: white; border-radius: 5px; cursor: pointer; }
        button[type="submit"]:hover { background-color: #c9a0ff; }
        .message-success { color: green; margin-bottom: 15px; }
        .message-error { color: red; margin-bottom: 15px; }
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
        <h2>Customer Feedback</h2>
        <p>Please provide your feedback and rate our demos.</p>

        <?php if (!empty($insertSuccess)) : ?>
            <p class="message-success"><?php echo $insertSuccess; ?></p>
        <?php elseif (!empty($insertError)) : ?>
            <p class="message-error"><?php echo $insertError; ?></p>
        <?php endif; ?>

        <form action="feedback.php" method="post">
            <div class="form-group">
                <label for="customerid">Email Address</label>
                <input type="email" id="customerid" name="customerid" required />
            </div>
            <div class="form-group">
                <a href="feedbackFollowup.php" style="display: inline-block; margin-top: 10px; padding: 8px 15px; background-color: #6f4685; color: white; border-radius: 5px; text-decoration: none;">View Follow-up on Your Feedback</a>
            </div>

            <div class="form-group">
                <label for="interestarea">Area Of Interest</label>
                <select id="interestarea" name="interestarea" required>
                    <option value="">-Select-</option>
                    <option value="virtual assistant">AI-Powered Virtual Assistant</option>
                    <option value="bi">AI-Driven Business Intelligence</option>
                    <option value="cybersecurity">AI-Enhanced Cybersecurity</option>
                    <option value="hr">AI for HR & Workforce Optimization</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rating">Rating (1 to 5)</label>
                <input type="number" id="rating" name="rating" min="1" max="5" required />
            </div>

            <div class="form-group">
                <label for="comments">Comments (optional)</label>
                <textarea id="comments" name="comments" rows="4"></textarea>
            </div>

            <button type="submit">Submit Feedback</button>
        </form>
    </div>
</body>
</html>
