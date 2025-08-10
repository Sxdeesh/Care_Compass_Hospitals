<?php
include "connect.php";

session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.html");
    exit;
}

$sql_doctors_count = "SELECT COUNT(*) AS doctors_count FROM doctors";
$result_doctors_count = $conn->query($sql_doctors_count);
$doctors_count = 0;

if ($result_doctors_count->num_rows > 0) {
    $row = $result_doctors_count->fetch_assoc();
    $doctors_count = $row['doctors_count'];
}

$sql_users_count = "SELECT COUNT(*) AS users_count FROM user";
$result_users_count = $conn->query($sql_users_count);
$users_count = 0;

if ($result_users_count->num_rows > 0) {
    $row = $result_users_count->fetch_assoc();
    $users_count = $row['users_count'];
}

$sql_appointments_count = "SELECT COUNT(*)AS appointments_count FROM appointment";
$result_appointments_count = $conn->query($sql_appointments_count);
$appointments_count = 0;

if ($result_appointments_count->num_rows > 0) {

    $row = $result_appointments_count->fetch_assoc();
    $appointments_count = $row['appointments_count'];

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar ul li a:hover {
            background: #34495e;
        }

        .main-content {
            flex: 1;
            padding: 20px;
            background: #ecf0f1;
        }

        .dashboard {
            display: flex;
            gap: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="admin_panel">
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="manage_users.php">Manage Patients</a></li>
            <li><a href="manage_doctors.php">Manage Doctors</a></li>
            <li><a href="manage_appointments.php">Appointments</a></li>
            <li><a href="manage_feedback.php">Feedback Management</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <h1>Welcome Care Compass Admin Dashboard</h1>
        <div class="dashboard">
            <div class="card">Total Patients : <?php echo $doctors_count; ?></div>
            <div class="card">Total Doctors : <?php echo $users_count; ?> </div>
            <div class="card">Appointments : <?php echo $appointments_count; ?></div>
        </div>
    </div>
</body>

</html>