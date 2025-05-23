<?php
// Start session and include database connection
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit;
}

require_once 'dbConnect.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_admin'])) {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        try {
            $pdo = getDbConnection();

            // Check if username already exists
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $error = 'Username already exists. Please choose another.';
            } else {
                // Hash the password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Insert new admin user
                $insertStmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
                $insertStmt->execute(['username' => $username, 'password' => $passwordHash]);

                $message = 'New admin user created successfully.';
            }
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

$dashboardData = fetchDashboardData();

$totalDemoRequests = $dashboardData['totalDemoRequests'] ?? 0;
$totalEventSignups = $dashboardData['totalEventSignups'] ?? 0;
$mostRequestedSolution = $dashboardData['mostRequestedSolution'] ?? null;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: linear-gradient(135deg, #e0b0ff, #6f4685); }
        .navbar { background: #4b2e66; padding: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); }
        .navbar a { color: white; text-decoration: none; padding: 10px; display: inline-block; font-weight: 600; }
        .navbar a:hover { background: #c9a0ff; border-radius: 5px; }
        .container {
            width: 90%;
            margin: 30px auto;
            padding: 30px 40px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(111, 70, 133, 0.4);
            max-width: 600px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .section { margin-bottom: 25px; }
        .section h3 {
            color: #6f4685;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 2px solid #c9a0ff;
            padding-bottom: 5px;
        }
        .stat {
            font-size: 28px;
            font-weight: 700;
            color: #4b2e66;
            margin-left: 10px;
        }
        .form-section {
            margin-top: 50px;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(111, 70, 133, 0.3);
        }
        .form-section h2 {
            color: #6f4685;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 26px;
        }
        .form-group { margin-bottom: 20px; }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: #4b2e66;
            font-size: 16px;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1.5px solid #c9a0ff;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #6f4685;
            outline: none;
        }
        button {
            background: #6f4685;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background: #59366f;
        }
        .message {
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
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
        h1 {
            text-align: center;
            color: #4b2e66;
            
            margin-top: 30px;
            font-weight: 800;
            font-size: 36px;
            text-shadow: 1px 1px 2px rgba(201, 160, 255, 0.7);
        }
        /* Added styles for reports divs */
        .containerr {
            display: flex;
            gap: 20px;
            margin-top: 30px;
        }
        .reports {
            background: #fff;
            border: 1.5px solid #c9a0ff;
            border-radius: 12px;
            padding: 20px;
            flex: 1;
            box-shadow: 0 6px 15px rgba(111, 70, 133, 0.25);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .reports:hover {
            box-shadow: 0 10px 25px rgba(111, 70, 133, 0.4);
            transform: translateY(-5px);
        }
        .reports h4 {
            color: #6f4685;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 20px;
        }
        .reports a {
            color: #6f4685;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: color 0.3s ease;
        }
        .reports a:hover {
            color: #4b2e66;
            text-decoration: underline;
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

</div>

        <h1>Admin Dashboard</h1>
    
    <div class="container">
        
    <div class="section">
            <h3>Total Demo Requests: </h3>
            <p class="stat"><?php echo $totalDemoRequests; ?></p>
        </div>
       
        <div class="section">
            <h3>Number of Promotional Event Sign-ups: </h3>
            <p class="stat"><?php echo $totalEventSignups; ?></p>
        </div>
       
        <div class="section">
            <h3>Most Requested AI Solution: </h3>
            <p class="stat">
                <?php 
                echo $mostRequestedSolution ? 
                    $mostRequestedSolution['INTERESTAREA'] . " (" . $mostRequestedSolution['count'] . " requests)" : 
                    "No data available"; 
                ?>
            </p>
        </div>

    </div>
    

    <br>
    <h2 style="text-align:center; color: white;">Reports </h2>
    <div class="containerr">
        
        <div class="reports">
            <h4>Demo Requests Report</h4>
            <a href="demoRequestsReport.php" style="color: #6f4685; text-decoration: none;">View Report</a>
        </div>
        
        <div class="reports">
            <h4>Promotional Event Report</h4>
            <a href="promotionalEventReport.php" style="color: #6f4685; text-decoration: none;">View Report</a>
        </div>
    </div>

    <div class="section" style="margin-top: 40px; clear: both; text-align: center;">
            <a href="createNewUser.php" style="margin-left: 40px; display: inline-block; padding: 10px 20px; background: #6f4685; color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">Create New Admin User</a>
        
            <a href="createNewEvent.php" style="margin-left: 40px; display: inline-block; padding: 10px 20px; background: #6f4685; color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">Create New Event</a>

            <a href="feedbackReport.php" style="margin-left: 40px; display: inline-block; padding: 10px 20px; background: #6f4685; color: white; border-radius: 5px; text-decoration: none; font-weight: bold;">View Customer Feedback</a>
    </div>

</body>
</html>

