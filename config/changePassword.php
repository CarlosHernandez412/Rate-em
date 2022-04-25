<?php
// 4-23-22 Leny: Allow users to update their passwords
session_start();
print_r($_SESSION);
require_once "../config/.config.php";

if (isset($_POST['changePass'])) {
    unset($_POST['changePass']);
    $db = getConnected();
    $Email = $_POST['email'];
    $Phone = $_POST['phonenum'];
    $FName = $_POST['fname'];
    $MI = $_POST['mname'];
    $LName = $_POST['lname'];
    $newPass = $_POST['newPSW'];
    $confirmPass = $_POST['confirmPSW'];
    // Get user info by email
    $validation = $db->prepare("SELECT * FROM User Where Email =?");
    $validation->bind_param('s', $Email);
    if ($validation->execute()) {
        $Account = $validation->get_result();
        $Acc = [];
        while ($row = $Account->fetch_assoc()) {
            $Acc[] = $row;
        }
        if (empty($MI))
            $MI = NULL;
        if (
            strlen($Email) == 0 || strlen($Phone) == 0 || strlen($FName) == 0 || strlen($LName) == 0
            || strlen($newPass) == 0 || strlen($confirmPass) == 0
        ) {
            $_SESSION["first"] = $FName;
            $_SESSION["mi"] = $MI;
            $_SESSION["last"] = $LName;
            $_SESSION["num"] = $Phone;
            $_SESSION["email"] =  $Email;
            $_SESSION["error"] = "Please fill out all (*) required fields!";
            header("Location: ../views/login.php");
        } else {
            // Validate the stored user and the user input
            if ($Acc[0]["PhoneNumber"] === $Phone && $Acc[0]["FName"] === $FName && $Acc[0]["MI"] === $MI && $Acc[0]["LName"] === $LName) {
                // Make sure new password matches confirmation password
                if ($newPass === $confirmPass) {
                    //Update password
                    $updatedPass = password_hash($newPass, PASSWORD_DEFAULT);
                    $updatePW = $db->prepare("UPDATE User SET Password =? WHERE Email =?");
                    $updatePW->bind_param('ss', $updatedPass, $Acc[0]["Email"]);
                    if ($updatePW->execute()) {
                        $_SESSION["success"] = "Password has been sucessfully updated!";
                        header("Location: ../views/login.php");
                    } else {
                        echo "Error executing query: " . mysqli_error($db);
                        die();
                    }
                } else {
                    $_SESSION["first"] = $FName;
                    $_SESSION["mi"] = $MI;
                    $_SESSION["last"] = $LName;
                    $_SESSION["num"] = $Phone;
                    $_SESSION["email"] =  $Email;
                    $_SESSION["error"] = "Passwords do not match.";
                    header("Location: ../views/login.php");
                }
            } else {
                $_SESSION["first"] = $FName;
                $_SESSION["mi"] = $MI;
                $_SESSION["last"] = $LName;
                $_SESSION["num"] = $Phone;
                $_SESSION["email"] =  $Email;
                $_SESSION["error"] = "We could not verify you, please try again.";
                header("Location: ../views/login.php");
            }
        }
    } else {
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}
