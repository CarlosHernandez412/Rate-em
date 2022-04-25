<?php
// 4-16-22 Keben: Created the form to update the settings page
// 4-21-22 Keben, Leny: Worked on account updates and tested
// 4-25-22 Keben, Leny: Worked on deleting an account and tested
session_start();
print_r($_SESSION);
require_once "../config/.config.php";

//Update Settings
if (isset($_POST['update'])) {
    unset($_POST['update']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PhoneNumber = $_POST['phonenum'];
    $FName = $_POST['fname'];
    $MI = $_POST['mname'];
    $LName = $_POST['lname'];
    $newPassword = $_POST['newpsw'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    $Type = $_SESSION['Type'];
    //Verify user with password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if (empty($MI))
            $MI = NULL;
        // Determine if password is being updated, if so then hash the new password
        if (!empty($newPassword)) {
            $hash = password_hash($newPassword, PASSWORD_DEFAULT);
            $AccountPW = $hash;
        } else {
            if($PhoneNumber !== $_SESSION['loggedProfile']['PhoneNumber']){
                $phoneValidation = $db->prepare("SELECT PhoneNumber FROM User Where PhoneNumber =?");
                $phoneValidation->bind_param('s', $PhoneNumber);
                $phoneValidation->execute();
                $phone_count = 0;
                while ($phoneValidation->fetch()) {
                    $phone_count++;
                }
                if ($phone_count > 0) {
                    $_SESSION["error"] = "An account has already been registered with the phone number '" . $PhoneNumber . "'";
                    header("Location: ../views/settings.php");
                }
            }
            $update = $db->prepare("UPDATE User SET FName =?, MI =?, LName =?, PhoneNumber =?, Password =? WHERE Email =?");
            $update->bind_param('ssssss', $FName, $MI, $LName, $PhoneNumber, $AccountPW, $Email);
            if ($update->execute()) {
                // Get new updated account information under the session
                $updatedAcc = $db->prepare("SELECT * FROM User Where Email =?");
                $updatedAcc->bind_param('s', $Email);
                if ($updatedAcc->execute()) {
                    $Account = $updatedAcc->get_result();
                    $Acc = [];
                    while ($row = $Account->fetch_assoc()) {
                        $Acc[] = $row;
                    }
                    $_SESSION['loggedProfile'] = $Acc[0];
                    $_SESSION['success'] = 'Account successfully updated!';
                    header("Location: ../views/settings.php");
                } else {
                    echo "Error executing query: " . mysqli_error($db);
                    die();
                }
            } else {
                echo "Error executing query: " . mysqli_error($db);
                die();
            }
        }
    } else {
        $_SESSION["error"] = "Cannot update, password incorrect!";
        header("Location: ../views/settings.php");
    }
}

//Delete Existing Account
if (isset($_POST['delete'])) {
    unset($_POST['delete']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PhoneNumber = $_POST['phonenum'];
    $FName = $_POST['fname'];
    $MI = $_POST['mname'];
    $LName = $_POST['lname'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    $Type = $_SESSION['Type'];
    //Verify user with password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if (empty($MI))
            $MI = NULL;
        if ($Type === 'Landlord') {
            $delete = $db->prepare("CALL deleteLandlord(?)");
            $delete->bind_param('s', $Email);
            if ($delete->execute()) {
                session_destroy();
                session_start();
                $_SESSION['success'] = 'Successfully deleted!';
                header("Location: ../views/register.php");
            } else {
                echo "Error executing query: " . mysqli_error($db);
                die();
            }
        } elseif ($Type === 'Tenant') {
            $delete = $db->prepare("CALL deleteTenant(?)");
            $delete->bind_param('s', $Email);
            if ($delete->execute()) {
                session_destroy();
                session_start();
                $_SESSION['success'] = 'Successfully deleted!';
                header("Location: ../views/register.php");
            } else {
                echo "Error executing query: " . mysqli_error($db);
                die();
            }
        }
    } else {
        $_SESSION["error"] = "Cannot delete, password incorrect!";
        header("Location: ../views/settings.php");
    }
}
