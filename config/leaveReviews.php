<?php
// 4-29-22 Leny: Test to see if users rating input is read
// TO DO: ALLOW USERS TO RATE USERS
session_start();
require_once "../config/.config.php";

// Update rating
if (isset($_POST["giveRating"]) && !empty($_POST["giveRating"]) && is_numeric($_POST["giveRating"])) {
    $db = getConnected();
    $Email = $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'];
    $Stars = $_POST['stars'];

    echo "Rating account:", $Email,"\n";
    echo "Stars:", $Stars;
}
?>