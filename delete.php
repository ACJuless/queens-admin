<?php
include("config.php");
error_reporting(0);

$id = $_GET['rn'];
$query = "DELETE FROM users WHERE id= '$id'";

$data = mysqli_query($conn, $query);

if($data)
{
    echo "<font color = 'green'><script>alert('Record Updated')</script>";
} else {
    echo "<font color = 'red'>Failed to Delete from Database!";
}

?>