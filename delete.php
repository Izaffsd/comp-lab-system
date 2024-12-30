<?php
require_once 'config/database.php';
session_start(); // Start the session

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input
    $query = "DELETE FROM makmal_tpp WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        $_SESSION['message'] = "Rekod makmal berjaya dibuang!"; // Set the success message
        header("Location: index.php");
        exit(); // Exit after redirecting
    } else {
        // Optionally handle errors here
        $_SESSION['message'] = "Ralat semasa membuang rekod!";
        header("Location: index.php");
        exit();
    }
}
?>
