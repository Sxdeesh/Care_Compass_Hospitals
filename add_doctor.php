<?php
include "connect.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $docname = $_POST["docname"];
    $speciality = $_POST["speciality"];

    $sql = "INSERT INTO doctors (docname, speciality) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $docname, $speciality);
    if ($stmt->execute()) {
        echo "Doctor Added Successfully";
    } else {
        echo "Failed to add doctor";
    }
    $stmt->close();

    $sql = "SELECT id, docname, speciality FROM doctors";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["docname"] . "</td>";
            echo "<td>" . $row["speciality"] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No doctors found</td></tr>";
    }

    $conn->close();
    $conn->close();
}
?>