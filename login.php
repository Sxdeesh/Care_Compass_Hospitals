<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['loginemail']);
    $password = trim($_POST['loginpassword']);
    $admin_email = "sadeeshweerasekara@gmail.com";  
    $admin_password = "3092";        

    if ($email == $admin_email && $password == $admin_password) {
        $_SESSION['loggedin'] = true;
        $_SESSION["email"] = $email;
        header("Location: dashboard.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, username, email, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $username, $email, $db_password);
        $stmt->fetch();

        if ($password == $db_password) {
            $_SESSION['loggedin'] = true;
            $_SESSION["id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["email"] = $email;
            header("Location: index.html");
            exit();
        }
        else {
            echo "<script>
                alert('Invalid password'); 
              </script>";
        }
    } else {
        echo "<script>
                alert('Invalid email'); 
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
