<?php
require_once 'dbConnect.php';

try {
    $pdo = getDbConnection();

    // Fetch column names from eventt table for debugging
    // Uncomment below lines to debug column names and fetched data
    // $columnsStmt = $pdo->query("SHOW COLUMNS FROM eventt");
    // $columns = $columnsStmt->fetchAll(PDO::FETCH_COLUMN);
    // echo "<pre>Eventt table columns: " . print_r($columns, true) . "</pre>";

    // Fetch all events from eventt table
    $stmt = $pdo->query("SELECT * FROM eventt");
    $events = $stmt->fetchAll();

    // Debug output of fetched events
    // echo "<pre>Fetched events: " . print_r($events, true) . "</pre>";
} catch (PDOException $e) {
    die("Error fetching events: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Events</title>
    <style>
       body {
        
        font-family: Arial, sans-serif;
       }
       
        .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }

       .navbar { background: #6f4685; padding: 10px; }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; }
        .navbar a:hover { background: #c9a0ff; }

        .container {
            width: 80%;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            
        }
        .event {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .event h2 {
            margin-top: 0;
        }
        .event-date {
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
        <div class="navbar">
       <!-- <a href="aiSolutionsSite.php"img src="../images/Logo.png"> </a>-->
        <a href="aiSolutionsSite.php">Home</a>
        <a href="about.php">About</a>
        <a href="solutions.php">Solutions</a>
        <a href="demo.php">Request a Demo</a>
        <a href="events.php">Events</a>
        <a href="contact.php">Contact</a>
        <a href="feedback.php">Feedback</a>
      
        <!--</div>-->

    </div>

    <div class="container">
        <h1>Events</h1>
        <?php if (count($events) > 0): ?>
            <?php foreach ($events as $event): ?>
                <div class="event">
                    <h2><?php echo htmlspecialchars($event['EVENTNAME'] ?? 'No Title'); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($event['DESCRIPTION'] ?? 'No Description')); ?></p>
                    <div class="event-date"><?php echo htmlspecialchars($event['EVENTDATETIME'] ?? 'No Date'); ?></div>
                   
                        
                    <a href="joinEvent.php?eventname=<?php echo urlencode($event['EVENTNAME']); ?>" style="display:inline-block; margin-top:10px; padding: 6px 12px; background-color: #6f4685; color: white; text-decoration: none; border-radius: 4px;">Join Event</a>
                   
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
