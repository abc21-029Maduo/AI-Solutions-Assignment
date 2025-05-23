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
        .solutions-container { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; margin-top: 20px;}
        .solution-box {width: 30%; background: #f4f4f4; padding: 15px; border-radius: 8px; text-align: center; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);}
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

    <div class="header">
        
    </div>

    <div class="container">
   
        <div class="solutions-container">
            <div class="solution-box">
            <a href="demo.php"><h3>AI-Powered Virtual Assistant</h3></a>
                <p>Automates responses to employee and customer inquiries, increasing productivity in the company.</p>
            </div>

            <div class="solution-box">
            <a href="demo.php"><h3>AI-Driven Business Intelligence</h3></a>
                
            <p>Uses AI to analyze data, predict market trends, and automate reporting.</p>
            </div>

            <div class="solution-box">
            <a href="demo.php"><h3>AI-Enhanced Cybersecurity</h3></a>   
                <p>AI-based threat detection and automated security monitoring to prevent cyberattacks.</p>
            </div>

            <div class="solution-box">
            <a href="demo.php"><h3>AI for HR & Workforce Optimization</h3></a> 
                <p>AI-powered hiring tools, employee performance tracking, and chatbots for HR tasks.</p>
            </div>
</div>

    </div>

    <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> AI-Solutions. All Rights Reserved.</p>
    </div>
</body>
</html>
