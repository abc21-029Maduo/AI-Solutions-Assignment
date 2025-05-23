<?php
require_once 'dbConnect.php';

session_start();

$requestDemo = null;
$insertError = null;
$insertSuccess = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $interestarea = isset($_POST['interestarea']) ? $_POST['interestarea'] : '';
    $demodate = isset($_POST['demodate']) ? $_POST['demodate'] : '';
    $currentDate = isset($_POST['currentDate']) ? $_POST['currentDate'] : '';
    $result = insertDemoRequest($id, $phone, $interestarea, $demodate, $currentDate);
    if ($result === true) {
        $insertSuccess = "Demo request submitted successfully.";
    } else {
        $insertError = "Failed to submit demo request. Error: " . (is_string($result) ? $result : '');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Request a Demo | AI-Solutions</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif;}
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }
        .header { background: #e0b0ff; color: white; text-align: center; padding: 50px 20px; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; color: white; text-decoration: none; border-radius: 5px; }
        .btn-light { background: #f8f9fa; color: #6f4685; }
        .btn-outline-light { border: 2px solid white; }
        .container { width: 90%; margin: 40px auto; padding: 30px 40px; text-align: left; background: #f4e1ff; border-radius: 10px; box-shadow: 0 4px 8px rgba(111, 70, 133, 0.2); max-width: 500px; }
        .footer { background: #6f4685; color: white; text-align: center; padding: 10px; position: relative; bottom: 0; width: 100%; }
        .form-group { margin-bottom: 20px; text-align: left; }
        label { display: block; margin-bottom: 5px; }
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
    </div>

    <div class="container">
        <h2>Request a Demo</h2>
        <p>Fill out the form below to schedule a demo with us.</p>

        <?php if (!empty($insertSuccess)) : ?>
            <p class="message-success"><?php echo $insertSuccess; ?></p>
        <?php elseif (!empty($insertError)) : ?>
            <p class="message-error"><?php echo $insertError; ?></p>
        <?php endif; ?>

        <form action="demo.php" method="post">
            <div class="form-group">
                <label for="customerid">Email Address</label>
                <input type="email" id="id" name="id" required />
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required />
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
                <label for="date">Requested Date:</label>
                <input type="date" id="date" name="demodate" required min="" />
            </div>

            <div class="form-group">
                <label for="date">Request Submission Date:</label>
                <input type="date" id="currentDate" name="currentDate" required />
            </div>

            <script>
                const dateInput = document.getElementById('currentDate');
                const today = new Date();
                dateInput.value = today.toISOString().slice(0, 10);

                // Set min attribute of requested date to tomorrow's date
                const requestedDateInput = document.getElementById('date');
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                requestedDateInput.min = tomorrow.toISOString().slice(0, 10);
            </script>

            <button type="submit">Submit Request</button>
        </form>
    </div>
</body>
</html>
