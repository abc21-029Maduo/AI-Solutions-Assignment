<?php
session_start();
require_once 'dbConnect.php';

try {
    $pdo = getDbConnection();

    // Query to join customer and demorequest tables on CUSTOMERID
    $stmt = $pdo->prepare("
        SELECT c.FULLNAME, c.EMAIL, c.COMPANYNAME, d.INTERESTAREA, d.REQUESTEDDATE, d.REQUESTSUBMISSIONDATE
        FROM customer c
        INNER JOIN demorequest d ON c.CUSTOMERID = d.CUSTOMERID
        ORDER BY d.REQUESTEDDATE DESC
    ");
    $stmt->execute();
    $demoRequests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Demo Requests Report</title>
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
    <h1>Demo Requests Report</h1>
    <?php if (count($demoRequests) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company Name</th>
                <th>Interest Area</th>
                <th>Request Date</th>
                <th>Request Submission Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($demoRequests as $request): ?>
            <tr>
                <td><?php echo htmlspecialchars($request['FULLNAME']); ?></td>
                <td><?php echo htmlspecialchars($request['EMAIL']); ?></td>
                <td><?php echo htmlspecialchars($request['COMPANYNAME']); ?></td>
                <td><?php echo htmlspecialchars($request['INTERESTAREA']); ?></td>
                <td><?php echo htmlspecialchars($request['REQUESTEDDATE']); ?></td>
                <td><?php echo htmlspecialchars($request['REQUESTSUBMISSIONDATE']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>No demo requests found.</p>
    <?php endif; ?>
</body>
</html>
