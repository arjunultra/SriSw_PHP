<?php
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];
// Database Connection
$conn = new mysqli("localhost", "root", "", "mydb");
if ($conn->connect_error) {
    die("Connection Failed" . $conn->connect_error);
} else {
    $stmt = $conn->prepare("insert into surveyform(name,email,age)values(?,?,?)");
    $stmt->bind_param("ssi", $name, $email, $age);
    $stmt->execute();
    echo "Registration Successful";
    $stmt->close();
    $conn->close();

}