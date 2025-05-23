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
        <a href="aiSolutionsSite.php">Home</a>
        <a href="about.php">About</a>
        <a href="solutions.php">Solutions</a>
        <a href="demo.php">Request a Demo</a>
        <a href="events.php">Events</a>
        <a href="contact.php">Contact</a>
    </div>

    <div class="header">
        <h1>About AI-Solutions</h1>
        <p>Providing AI-driven solutions to the digital workspace.</p>
    </div>

    <div class="container">
   
   <h2>Who We Are</h2> 
   <p> 
   AI-Solutions is a  company based in Sunderland. AI-Solutions leverages AI to assist
    various industries with software solutions to rapidly and proactively address issues that can impact
    the digital employee experience, thus speeding up design, engineering, and innovation. AI-Solutions
    has distinguished itself by integrating an AI-powered virtual assistant that responds to users' inquiries
    and provides AI-based, affordable prototyping solutions. 
    </p>

    <h2>Our Mission</h2>
    <p>
    The company's mission is to innovate,
    promote, and deliver the future of the digital employee experience, with a strong focus on supporting
    people at work. 
    </p> 

    <h2>Why Choose Us?</h2>
            <ul style="list-style-position: inside; padding-left: 0";>
            <li>AI-driven solutions tailored to industry needs</li>
            <li>Affordable and scalable AI-based prototyping</li>
            <li>Global reach with a focus on digital transformation</li>
            </ul>
    
    </div>

    <div class="footer">
        <p>&copy; <?php echo date('Y'); ?> AI-Solutions. All Rights Reserved.</p>
    </div>
</body>
</html>
