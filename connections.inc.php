<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "hms_software");

if (!$conn) {
  die("Database connection failed: " . mysqli_connect_error());
}
?>
