<?php
$conn = mysqli_connect("localhost", "root", "", "mydb");

$query ="SELECT email FROM user ";
$result = mysqli_query($conn,$query);

?>