<?php

include 'connect.php';
if($_SERVER['REQUEST_METHOD']=="POST"){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $stmt = $conn->prepare("INSERT INTO message (fullname, email, phone, message) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $fullname, $email, $phone, $message);
    if( $stmt->execute() ){
        $msg = "Thank you for your feedback!";
        echo "<script type='text/javascript'>alert('$msg');
        window.history.back();
        </script>";
    }
    else{
        echo "Message Sending Failed";
    }
    $stmt->close();
}
$conn->close();
?>