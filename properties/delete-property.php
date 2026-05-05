<?php
/** @var mysqli $link */
require_once '../config.php';

if(!isset($_SESSION['user_id'])){
    header('location: ../auth/login.php');
    exit();
}

$id = $_GET['id'];

$property = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM properties WHERE id=$id AND user_id=".$_SESSION['user_id']));

if(!$property){
    echo "Property not found.";
    exit();
}

mysqli_query($link, "DELETE FROM properties WHERE id=$id");
header('location: ../index.php');
exit();
?>