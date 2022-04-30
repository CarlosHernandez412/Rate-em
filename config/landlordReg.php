<?php
// 03/25/2022 Leny: Start working on registeration for landlord accounts
// 04/10/2022 Keben: Worked on displaying error message when registering with existing email
// 03/18/2022 Leny: Registration works with validation

session_start();
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
    $Zipcode = substr($_POST['zip'],0,5);
    $NumOfBathrooms = $_POST['numOfBathrooms'];
    $NumOfBedrooms = $_POST['numOfBedrooms'];
    $Price = $_POST['price'];
    $Type = $_POST['type'];
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
    $propertyTypes = ['Apartment', 'House', 'Mobile Home', 'Trailer Home', 'Condo', 'Studio'];
    if (in_array($Type, $propertyTypes)) {
        $validation = $db->prepare("SELECT Email FROM User Where Email =?");
        $validation->bind_param('s', $Email);
        if ($validation->execute()) {
            if (mysqli_stmt_bind_result($validation, $res_Email)) {
                $result_count = 0;
                while ($validation->fetch()) {
                    $result_count++;
                }
                $phoneValidation = $db->prepare("SELECT PhoneNumber FROM User Where PhoneNumber =?");
                $phoneValidation->bind_param('s', $PhoneNumber);
                $phoneValidation->execute();
                $phone_count = 0;
                while ($phoneValidation->fetch()) {
                    $phone_count++;
                }
                if ($result_count > 0 || $phone_count > 0) {
                    if ($result_count > 0)
                        $_SESSION["lreg_error"] = "Email '".$Email."' already registered!";
                    elseif ($phone_count > 0)
                        $_SESSION["lreg_error"] = "An account has already been registered with the phone number '".$PhoneNumber."'";
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
                    $_SESSION["reg_error"] = "Something went wrong, please try again!";
                    header("Location: ../views/register.php");
                } else {
                    echo "Registering!";
                    $hash = password_hash($Password, PASSWORD_DEFAULT);
                    $statement = $db->prepare("CALL landlordRegister(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $statement->bind_param(
                        'ssssssiidssis',
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
                        $_SESSION['success'] = 'Successfully registered!';
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
    } else {
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
}
