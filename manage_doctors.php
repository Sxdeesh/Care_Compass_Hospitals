<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["docname"], $_POST["speciality"])) {
    $docname = $_POST["docname"];
    $speciality = $_POST["speciality"];

    $sql = "INSERT INTO doctors (docname, speciality) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $docname, $speciality);

    if ($stmt->execute()) {
        header("Location: manage_doctors.php");
        exit();
    } else {
        echo "Failed to add doctor";
    }

    $stmt->close();
}

$sql_doctors_count = "SELECT COUNT(*) AS doctors_count FROM doctors";
$result_doctors_count = $conn->query($sql_doctors_count);
$doctors_count = $result_doctors_count->fetch_assoc()["doctors_count"] ?? 0;

if (isset($_GET["delete_id"])) {
    $delete_id = $_GET["delete_id"];
    $sql = "DELETE FROM doctors WHERE doc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        header("Location: manage_doctors.php");
        exit();
    } else {
        echo "Failed to delete doctor";
    }

    $stmt->close();
}

$search = "";
if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
    $sql = "SELECT doc_id, docname, speciality FROM doctors 
            WHERE doc_id LIKE ? OR docname LIKE ? OR speciality LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
} else {
    $sql = "SELECT doc_id, docname, speciality FROM doctors";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            gap: 10px;
        }

        .delete-btn {
            color: red;
            text-decoration: none;
        }

        .delete-btn:hover {
            text-decoration: underline;
        }

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

        .search-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
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
        <h2>Manage Doctors</h2>

        <div>
            <form action="manage_doctors.php" method="POST">
                <input type="text" placeholder="Enter doctor name" required name="docname">
                <select name="speciality" id="speciality" required>
                    <option value="" disabled selected>Select your doctor</option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="Oncologist">Oncologist</option>
                    <option value="Endocrinologist">Endocrinologist</option>
                    <option value="Pulmonologist">Pulmonologist</option>
                    <option value="Neurologist">Neurologist</option>
                    <option value="Nephrologist">Nephrologist</option>
                    <option value="Gastroenterologist">Gastroenterologist</option>
                    <option value="Rheumatologist">Rheumatologist</option>
                </select>
                <button type="submit">Add Doctor</button>
            </form>
        </div>

        <h2>Doctors List</h2>

        <p><strong>Total Doctors : <?php echo $doctors_count; ?></strong></p>

        <div class="search-container">
            <form action="manage_doctors.php" method="GET">
                <input type="text" name="search" placeholder="Search by name or specialty" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Search</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialization</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["doc_id"] . "</td>";
                        echo "<td>" . $row["docname"] . "</td>";
                        echo "<td>" . $row["speciality"] . "</td>";
                        echo "<td class='actions'>";
                        echo "<a href='manage_doctors.php?delete_id=" . $row["doc_id"] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this doctor?\");'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No doctors found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
