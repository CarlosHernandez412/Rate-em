<?php
// 3-25-22 Leny: Start working on registeration for landlord accounts
// TO DO: TEST
// 4/10/22 Keben: Worked on displaying error message when registering with existing email

session_start();
print_r($_SESSION);
require_once "../config/.config.php";

// Landlord user registeration with validation
if (isset($_POST['landlordReg'])) {
    unset($_POST['landlordReg']);
    $db = getConnected();
    // Account info
    $FName = $_POST['fname'];
    $MI = $_POST['mname'];
    $LName = $_POST['lname'];
    $PhoneNumber = $_POST['phonenum'];
    $Email = $_POST['email'];
    $Password = $_POST['psw'];
    // Property info
    $State = $_POST['state'];
    $City = $_POST['city'];
    $Zipcode = $_POST['zip'];
    $NumOfBathrooms = $_POST['numOfBathrooms'];
    $NumOfBedrooms = $_POST['numOfBedrooms'];
    $Price = $_POST['price'];
    $Type = $_POST['type'];
    if ( 
        $Type !== "Apartment" || $Type !== "House" || $Type !== "Mobile Home" || 
        $Type !== "Trailer Home" || $Type !== "Condo" || $Type !== "Studo"
    ) {
        // Account info
        $_SESSION["Lfirst"] = $_POST['fname'];
        $_SESSION["Lmid"] = $_POST['mname'];
        $_SESSION["Llast"] = $_POST['lname'];
        $_SESSION["Lnum"] = $_POST['phonenum'];
        $_SESSION["LeAddress"] = $_POST['email'];
        $_SESSION["Lpass"] = $_POST['psw'];
        // Property info
        $_SESSION["St"] = $_POST['state'];
        $_SESSION["Cty"] = $_POST['city'];
        $_SESSION["Zpcode"] = $_POST['zip'];
        $_SESSION["Bathrms"] = $_POST['numOfBathrooms'];
        $_SESSION["Rms"] = $_POST['numOfBedrooms'];
        $_SESSION["Cost"] = $_POST['price'];
        $_SESSION["PType"] = $_POST['type'];
        $_SESSION["lreg_error"] = "Please enter a valid choice for property type!";
        $_SESSION["reg_error"] = "Something went wrong, please try again!";
        header("Location: ../views/register.php");
    }
    if (
        strlen($FName) == 0 || strlen($LName) == 0 || strlen($PhoneNumber) == 0 || strlen($Email) == 0 ||
        strlen($Password) == 0 || strlen($State) == 0 || strlen($City) == 0 || strlen($Zipcode) == 0 || 
        strlen($NumOfBathrooms) == 0 || strlen($NumOfBedrooms) == 0 || strlen($Price) == 0 || strlen($Type) == 0
    ) {
        // Account info
        $_SESSION["Lfirst"] = $_POST['fname'];
        $_SESSION["Lmid"] = $_POST['mname'];
        $_SESSION["Llast"] = $_POST['lname'];
        $_SESSION["Lnum"] = $_POST['phonenum'];
        $_SESSION["LeAddress"] = $_POST['email'];
        $_SESSION["Lpass"] = $_POST['psw'];
        // Property info
        $_SESSION["St"] = $_POST['state'];
        $_SESSION["Cty"] = $_POST['city'];
        $_SESSION["Zpcode"] = $_POST['zip'];
        $_SESSION["Bathrms"] = $_POST['numOfBathrooms'];
        $_SESSION["Rms"] = $_POST['numOfBedrooms'];
        $_SESSION["Cost"] = $_POST['price'];
        $_SESSION["PType"] = $_POST['type'];
        $_SESSION["lreg_error"] = "Please fill out all (*) required fields!";
        $_SESSION["reg_error"] = "Something went wrong, please try again!";
        header("Location: ../views/register.php");
    }
    $validation = $db->prepare("SELECT Email FROM User Where Email =?");
    if (!$validation) {
        echo "Error getting result: " . mysqli_error($db);
        die();
    }
    $validation->bind_param('s', $Email);
    if ($validation->execute()) {
        if (mysqli_stmt_bind_result($validation, $res_Email)) {
            $result_count = 0;
            while ($validation->fetch()) {
                $result_count++;
            }
            if ($result_count > 0) {
                // Account info
                $_SESSION["Lfirst"] = $_POST['fname'];
                $_SESSION["Lmid"] = $_POST['mname'];
                $_SESSION["Llast"] = $_POST['lname'];
                $_SESSION["Lnum"] = $_POST['phonenum'];
                $_SESSION["LeAddress"] = $_POST['email'];
                $_SESSION["Lpass"] = $_POST['psw'];
                // Property info
                $_SESSION["St"] = $_POST['state'];
                $_SESSION["Cty"] = $_POST['city'];
                $_SESSION["Zpcode"] = $_POST['zip'];
                $_SESSION["Bathrms"] = $_POST['numOfBathrooms'];
                $_SESSION["Rms"] = $_POST['numOfBedrooms'];
                $_SESSION["Cost"] = $_POST['price'];
                $_SESSION["PType"] = $_POST['type'];
                $_SESSION["lreg_error"] = "Error: Email " . $Email . " already registered";
                $_SESSION["reg_error"] = "Something went wrong, please try again!";
                header("Location: ../views/register.php");
            } else {
                echo "Registering!";
                $hash = password_hash($Password, PASSWORD_DEFAULT);
                // TO DO: PROCEDURE CALL FOR REGISTERING LANDLORD
                $statement = $db->prepare("CALL landlordRegister(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $statement->bind_param(
                    'sssssiiidssis',
                    $Email,
                    $PhoneNumber,
                    $FName,
                    $MI,
                    $LName,
                    $hash,
                    $NumOfBedrooms,
                    $NumOfBathrooms,
                    $Price,
                    $State,
                    $City,
                    $Zipcode,
                    $Type
                );
                if ($statement->execute()) {
                    echo "Registered!";
                    header("Location: ../views/login.php");
                } else {
                    echo "Registration failed: " . mysqli_error($db);
                    die();
                }
            }
        } else {
            echo "Error getting results: " . mysqli_error($db);
            die();
        }
    } else {
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}

?>