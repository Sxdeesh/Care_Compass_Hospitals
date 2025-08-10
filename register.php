<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["Regusername"];
    $email = $_POST["Regemail"];
    $password = $_POST["Regpassword"];

    $check_sql = "SELECT email FROM user WHERE email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "<script>
                alert('This email is already registered. Please use a different email.');
                window.history.back(); 
              </script>";
        exit();
    } else {
        $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            header("Location: login.html");
            exit();
        } else {
            echo "Registration Failed";
        }
        $stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>
