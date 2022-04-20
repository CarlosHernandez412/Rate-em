<?php
// 4-16-22 Keben: Created the form to update the settings page
// TO DO: Test
session_start();
print_r($_SESSION);
require_once "../config/.config.php";

//Update Settings
if (isset($_POST['update'])) {
    unset($_POST['update']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PhoneNumber= $_POST['phonenum'];
    $FName = $_POST['fname'];
    $MI = $_POST['mname'];
    $LName = $_POST['lname'];
    $newPassword = $_POST['newpsw'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    //Verify user with password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        $update = $db->prepare("UPDATE User SET FName =? AND MI =? AND LName =? AND PhoneNumber =? AND 'Password' =? WHERE Email =?");
        $update->bind_param('ssssss', $FName, $MI, $LName, $PhoneNumber, $Password, $Email);
        if($update->execute())
            header("Location: ../views/settings.php");
        else {
            $_SESSION['error'] = $Email;
            echo "Error executing query: " . mysqli_error($db);
            die();
        }
    }else {
        $_SESSION["error"] = "Cannot update, password incorrect!";
        header("Location: ../views/settings.php");
    }
}