<?php
require_once 'dbConnect.php';

session_start();

$customerid = '';
$feedbacks = [];
$error = '';

if (isset($_GET['email'])) {
    $customerid = trim($_GET['email']);
} elseif (isset($_POST['email'])) {
    $customerid = trim($_POST['email']);
}

if ($customerid) {
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare("SELECT interestarea, rating, comments, submissiondate, COALESCE(followup_status, 'pending') AS followup_status, COALESCE(followup_notes, '') AS followup_notes FROM feedback WHERE customerid = :customerid ORDER BY submissiondate DESC");
        $stmt->execute(['customerid' => $customerid]);
        $feedbacks = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error = "Error fetching feedback follow-up data: " . $e->getMessage();
    }
} else {
    $error = "Please provide your email address to view follow-up information.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Feedback Follow-up | AI-Solutions</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f4f4f9; }
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }
        .container { width: 90%; margin: 40px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(111, 70, 133, 0.2); max-width: 700px; }
        h1 { color: #6f4685; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; vertical-align: top; }
        th { background-color: #6f4685; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .no-data, .error { text-align: center; padding: 20px; color: #666; }
        form { margin-bottom: 20px; text-align: center; }
        input[type="email"] { width: 300px; padding: 8px; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #6f4685; color: white; border: none; padding: 8px 16px; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #59366f; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="aiSolutionsSite.php">Home</a>
        <a href="feedback.php">Submit Feedback</a>
       
    </div>
    <div class="container">
        <h1>Feedback Follow-up</h1>
        <form method="get" action="feedbackFollowup.php">
            <label for="email">Enter your email address to view follow-up:</label><br />
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customerid); ?>" required />
            <button type="submit">View Follow-up</button>
        </form>
        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php elseif (count($feedbacks) === 0): ?>
            <p class="no-data">No feedback or follow-up found for this email address.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Area of Interest</th>
                        <th>Rating</th>
                        <th>Comments</th>
                        <th>Submission Date</th>
                        <th>Follow-up Status</th>
                        <th>Follow-up Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $fb): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fb['interestarea']); ?></td>
                            <td><?php echo htmlspecialchars($fb['rating']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($fb['comments'])); ?></td>
                            <td><?php echo htmlspecialchars($fb['submissiondate']); ?></td>
                            <td><?php echo htmlspecialchars($fb['followup_status']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($fb['followup_notes'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
