<?php
session_start();
require_once 'dbConnect.php';

try {
    $pdo = getDbConnection();

    // Query to join customer and eventparticipation tables on EMAIL and CUSTOMEREMAIL
    $stmt = $pdo->prepare("
        SELECT c.CUSTOMERID, c.FULLNAME, c.EMAIL, c.COMPANYNAME, e.EVENTNAME, e.REGISTRATIONDATETIME
        FROM customer c
        INNER JOIN eventtparticipation e ON c.EMAIL = e.CUSTOMEREMAIL
        ORDER BY e.REGISTRATIONDATETIME DESC
    ");
    $stmt->execute();
    $eventParticipants = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Promotional Event Participants Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f9; }
        h1 { color: #6f4685; }
        table { border-collapse: collapse; width: 100%; background: white; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px 15px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #6f4685; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        tr:hover { background-color: #f1e6ff; }
    </style>
</head>
<body>
    <h1>Promotional Event Participants Report</h1>
    <?php if (count($eventParticipants) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Company Name</th>
                <th>Event ID</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($eventParticipants as $participant): ?>
            <tr>
                <td><?php echo htmlspecialchars($participant['CUSTOMERID']); ?></td>
                <td><?php echo htmlspecialchars($participant['FULLNAME']); ?></td>
                <td><?php echo htmlspecialchars($participant['EMAIL']); ?></td>
                <td><?php echo htmlspecialchars($participant['COMPANYNAME']); ?></td>
                <td><?php echo htmlspecialchars($participant['EVENTNAME']); ?></td>
                <td><?php echo htmlspecialchars($participant['REGISTRATIONDATETIME']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No event participants found.</p>
    <?php endif; ?>
</body>
</html>
