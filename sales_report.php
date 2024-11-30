<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$admin_username = $_SESSION['username'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "milk_tea_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define default date range for the report
$start_date = date('Y-m-01'); // Default start date: first day of current month
$end_date = date('Y-m-d'); // Default end date: today

// Filter report by date range
if (isset($_POST['generate_report'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
}

// Fetch sales data from the database based on the selected date range
$sql = "SELECT order_date, SUM(total_amount) AS total_sales, SUM(total_items) AS total_items FROM sales WHERE order_date BETWEEN '$start_date' AND '$end_date' GROUP BY order_date";
$result = $conn->query($sql);
$sales_data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sales_data[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report - Milk Tea Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
        }

        .form-container {
            margin-bottom: 30px;
        }

        .report-table {
            margin-top: 20px;
        }

        .report-table th,
        .report-table td {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-center">Sales Report - Milk Tea Shop</h1>
        <p class="text-center">Welcome, <?php echo $admin_username; ?>!</p>

        <!-- Filter Form -->
        <div class="form-container">
            <h3>Filter Sales Report by Date</h3>
            <form method="POST" action="sales_report.php">
                <div class="row">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo $start_date; ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo $end_date; ?>" required>
                    </div>
                </div>
                <button type="submit" name="generate_report" class="btn btn-primary mt-3">Generate Report</button>
            </form>
        </div>

        <!-- Sales Report Table -->
        <div class="report-table">
            <h3>Sales Report from <?php echo $start_date; ?> to <?php echo $end_date; ?></h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Total Sales ($)</th>
                        <th>Total Items Sold</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sales_data)) : ?>
                        <tr>
                            <td colspan="3" class="text-center">No sales data found for the selected date range.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($sales_data as $data) : ?>
                            <tr>
                                <td><?php echo $data['order_date']; ?></td>
                                <td>$<?php echo number_format($data['total_sales'], 2); ?></td>
                                <td><?php echo $data['total_items']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
