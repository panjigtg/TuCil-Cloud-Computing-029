<?php
$hostname = gethostname();
$instance = getenv('INSTANCE_NAME') ?: 'Unknown';

echo "<!DOCTYPE html>
<html>
<head>
    <title>Load Balancer Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .container {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 10px;
        }
        h1 { font-size: 3em; margin: 0; }
    </style>
</head>
<body>
    <div class='container'>
        <h1> Hello from {$instance}!</h1>
        <p>Container: {$hostname}</p>
        <p>Refresh untuk test load balancing</p>
        <p><small>Powered by PHP + Apache</small></p>
    </div>
</body>
</html>";
?>