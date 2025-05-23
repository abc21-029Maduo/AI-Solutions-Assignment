<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI-Solutions | Home</title>
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

        <!--<div class="navbar-right" align="right">-->
            
            <a href="login.php" align="right">Login</a>
        <!--</div>-->

    </div>

    <div class="header">
        <h1>AI-Powered Innovation for a Smarter Workplace</h1>
        <p>Transforming digital employee experiences with AI-driven solutions.</p>
        <a href="demo.php" class="btn btn-light">Request a Demo</a>
        <a href="events.php" class="btn btn-outline-light">Join Our Events</a>
    </div>

    <div class="container">
        <h2>Our Solutions</h2>
        <div>
            <h4>AI Virtual Assistant</h4>
            <p>Enhance productivity with our smart AI-powered assistant.</p>
        </div>
        <div>
            <h4>Prototyping Solutions</h4>
            <p>Affordable AI-based prototyping to speed up innovation.</p>
        </div>
        <div>
            <h4>Business Intelligence</h4>
            <p>Leverage AI-driven analytics for better decision-making.</p>
        </div>
    </div>

    <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> AI-Solutions. All Rights Reserved.</p>
    </div>
</body>
</html>
