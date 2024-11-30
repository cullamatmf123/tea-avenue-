<?php
session_start();
session_unset(); // Remove all session variables
session_destroy(); // Destroy the session
header('Location: index.php'); // Redirect to the homepage
exit();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <style>
        body {
            background-image: url(./8a2aeede1bc82312ae56b8fb186c8444.jpg);
            background-size: cover;
            background-position: center;
            margin: 0;
            font-family: 'Cursive', sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .logout-container {
            background: rgba(0, 0, 0, 0.8);
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
            width: 90%;
            max-width: 400px;
            transition: transform 0.3s;
        }

        .logout-container:hover {
            transform: translateY(-5px);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 30px;
            font-weight: bold;
        }

        p {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            width: 48%; /* Use 48% to have space between buttons */
        }

        .btn.logout {
            background-color: #c04040;
            color: white;
        }

        .btn.logout:hover {
            background-color: #a03030;
            transform: scale(1.05);
        }

        .btn.cancel {
            background-color: #4CAF50;
            color: white;
        }

        .btn.cancel:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="logout-container">
        <h1>Log Out Confirmation</h1>
        <p>Are you sure you want to log out? Your session will be ended, and you will need to log in again to continue.</p>
        <div class="buttons">
            <form action="login.php" method="post" style="width: 100%;">
                <button class="btn logout" type="submit">Log Out</button>
            </form>
            <a href="index.php" class="btn cancel">Cancel</a>
        </div>
    </div>
</body>

</html>
