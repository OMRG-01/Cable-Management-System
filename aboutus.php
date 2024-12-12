<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background: url('home2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            padding: 40px;
            margin: 0;
        }

        .container {
            border-radius: 20px;
            max-width: 960px;
            margin: 0 auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            margin-bottom: 15px;
            font-size: 2rem;
            color: #333;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 15px;
            color: #555;
        }

        ul {
            list-style: disc;
            margin-left: 30px;
            font-size: 1.1rem;
            color: #555;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .header .navbar {
            font-size: 20px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .header .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .header .navbar li {
            margin-top: 10px;
            padding: 0 10px;
            margin-right: 20px;
        }

        .header .navbar a {
            font-size: 25px;
            color: white;
            text-decoration: none;
            border: 1px solid black;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .header .navbar a:hover {
            background-color: #007bff;
            color: white;
        }

        h2 {
            margin-top: 20px;
            font-size: 1.5rem;
            color: #333;
        }

        /* Styling for developed by section */
        .developer-info {
            margin-top: 40px;
            font-size: 1.3rem;
            text-align: center;
            color: #333;
        }

        .developer-info b {
            font-size: 1.5rem;
        }
        
    </style>
    <title>About Us - Cable Management System</title>
</head>
<body>

    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="CustomerPage.php">Return</a></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <h1>About Us</h1>
        <p>Welcome to DIGI Cable Network,<br> your premier source for innovative cable management solutions. We're dedicated to providing the very best products to help you organize, protect, and optimize your cable setups. Our focus is on quality, reliability, and customer satisfaction.</p>
        
        <h2>Our Mission</h2>
        <p>At CableTech, our mission is to simplify your cable management challenges. We strive to offer cutting-edge solutions that streamline cable organization, enhance safety, and improve overall efficiency for both residential and commercial applications.</p>
        
        <h2>Why Choose DIGI Cable Network?</h2>
        <p>We take pride in our commitment to excellence. When you choose us, you're choosing:</p>
        <ul>
            <li>High-quality, durable cable management products</li>
            <li>Innovative designs tailored to your needs</li>
            <li>Outstanding customer support</li>
            <li>Fast and reliable shipping</li>
        </ul>

        <h2>Developed By...</h2>
        <div class="developer-info">
            <b>Mr. GAWALI OM RAJENDRA</b><br>
            (OWNER) <br>
            (DIGI CABLE NETWORK)
        </div>
    </div>

</body>
</html>
