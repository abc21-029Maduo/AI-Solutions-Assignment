<?php
require_once 'dbConnect.php';

session_start();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['followup_submit'])) {
    $feedback_id = intval($_POST['feedback_id']);
    $followup_status = $_POST['followup_status'] ?? 'pending';
    $followup_notes = trim($_POST['followup_notes'] ?? '');

    if ($feedback_id > 0) {
        $result = updateFeedbackFollowup($feedback_id, $followup_status, $followup_notes);
        if ($result) {
            $message = "Follow-up updated successfully.";
        } else {
            $error = "Failed to update follow-up. Please try again.";
        }
    } else {
        $error = "Invalid feedback ID.";
    }
}

try {
    $pdo = getDbConnection();
    $stmt = $pdo->query("SELECT feedbackID, customerid, interestarea, rating, comments, submissiondate, COALESCE(followup_status, 'pending') AS followup_status, COALESCE(followup_notes, '') AS followup_notes FROM feedback ORDER BY submissiondate DESC");
    $feedbacks = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching feedback data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Customer Feedback Report | AI-Solutions</title>
    <style>
        body { margin: 0; padding: 0; font-family: Arial, sans-serif; background: #f4f4f9; }
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }
        .container { width: 90%; margin: 40px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(111, 70, 133, 0.2); }
        h1 { color: #6f4685; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; vertical-align: top; }
        th { background-color: #6f4685; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .no-data { text-align: center; padding: 20px; color: #666; }
        textarea { width: 100%; height: 60px; border-radius: 5px; border: 1px solid #ccc; padding: 5px; }
        select { border-radius: 5px; border: 1px solid #ccc; padding: 5px; }
        button { background-color: #6f4685; color: white; border: none; padding: 6px 12px; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #59366f; }
        .message-success { color: green; margin-bottom: 15px; }
        .message-error { color: red; margin-bottom: 15px; }
        form { margin: 0; }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="adminDashboard.php">Admin Dashboard</a>
        <a href="feedback.php">Submit Feedback</a>
    </div>
    <div class="container">
        <h1>Customer Feedback Report</h1>
        <?php if ($message): ?>
            <p class="message-success"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p class="message-error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (count($feedbacks) === 0): ?>
            <p class="no-data">No feedback entries found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Email Address</th>
                        <th>Area of Interest</th>
                        <th>Rating</th>
                        <th>Comments</th>
                        <th>Submission Date</th>
                        <th>Follow-up Status</th>
                        <th>Follow-up Notes</th>
                        <th>Update Follow-up</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $fb): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($fb['customerid']); ?></td>
                            <td><?php echo htmlspecialchars($fb['interestarea']); ?></td>
                            <td><?php echo htmlspecialchars($fb['rating']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($fb['comments'])); ?></td>
                            <td><?php echo htmlspecialchars($fb['submissiondate']); ?></td>
                            <td><?php echo htmlspecialchars($fb['followup_status']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($fb['followup_notes'])); ?></td>
                            <td>
                                <form method="post" action="feedbackReport.php">
                                    <input type="hidden" name="feedback_id" value="<?php echo $fb['feedbackID']; ?>" />
                                    <select name="followup_status" required>
                                        <option value="pending" <?php if ($fb['followup_status'] === 'pending') echo 'selected'; ?>>Pending</option>
                                        <option value="done" <?php if ($fb['followup_status'] === 'done') echo 'selected'; ?>>Done</option>
                                    </select>
                                    <textarea name="followup_notes" placeholder="Add notes..."><?php echo htmlspecialchars($fb['followup_notes']); ?></textarea>
                                    <button type="submit" name="followup_submit">Save</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
