<?php

include 'connect.php';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $doctor = $_POST['doctor'];

    $stmt = $conn->prepare("INSERT INTO appointment (fullname, email, phone, date, doctor) VALUES (?,?,?,?,?)");
    $stmt->bind_param('sssss', $fullname, $email,$phone, $date, $doctor);
    if($stmt->execute()){
        echo "<script>
                alert('Appointment booked successfully');
                window.history.back(); 
              </script>";
    }else{
        echo "Appointment Booking Failed";
    }
    $stmt->close();
}
$conn->close();

?>