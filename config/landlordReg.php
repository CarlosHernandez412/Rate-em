<?php
// 3-25-22 Leny: Start working on registeration for landlord accounts
// TO DO: LINE 52 + GET MESSAGES TO PRINT ON SCREEN (ANY ERRORS ON REGISTRATION ATTEMPTS) + TEST

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
        // If registeration fails, then the input values will be saved so user does not have to re-type.
        // In HTML: add value="<?php echo $--- (question mark)>"
        // Account info
        //$FName = $_POST['fname'];
        //$MI = $_POST['mname'];
        //$LName = $_POST['lname'];
        //$PhoneNumber = $_POST['phonenum'];
        //$Email = $_POST['email'];
        //$Password = $_POST['psw'];
        // Property info
        //$State = $_POST['state'];
        //$City = $_POST['city'];
        //$Zipcode = $_POST['zip'];
        //$NumOfBathrooms = $_POST['numOfBathrooms'];
        //$NumOfBedrooms = $_POST['numOfBedrooms'];
        //$Price = $_POST['price'];
        //$Type = $_POST['type'];
        $_SESSION["error"] = "Please enter a valid choice!";
        header("Location: ../views/register.php");
    }
    if (
        strlen($FName) == 0 || strlen($LName) == 0 || strlen($PhoneNumber) == 0 || strlen($Email) == 0 ||
        strlen($Password) == 0 || strlen($State) == 0 || strlen($City) == 0 || strlen($Zipcode) == 0 || 
        strlen($NumOfBathrooms) == 0 || strlen($NumOfBedrooms) == 0 || strlen($Price) == 0 || strlen($Type) == 0
    ) {
        // Account info
        //$FName = $_POST['fname'];
        //$MI = $_POST['mname'];
        //$LName = $_POST['lname'];
        //$PhoneNumber = $_POST['phonenum'];
        //$Email = $_POST['email'];
        //$Password = $_POST['psw'];
        // Property info
        //$State = $_POST['state'];
        //$City = $_POST['city'];
        //$Zipcode = $_POST['zip'];
        //$NumOfBathrooms = $_POST['numOfBathrooms'];
        //$NumOfBedrooms = $_POST['numOfBedrooms'];
        //$Price = $_POST['price'];
        //$Type = $_POST['type'];
        $_SESSION["error"] = "Please fill out all (*) required fields!";
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
                //$FName = $_POST['fname'];
                //$MI = $_POST['mname'];
                //$LName = $_POST['lname'];
                //$PhoneNumber = $_POST['phonenum'];
                //$Email = $_POST['email'];
                //$Password = $_POST['psw'];
                // Property info
                //$State = $_POST['state'];
                //$City = $_POST['city'];
                //$Zipcode = $_POST['zip'];
                //$NumOfBathrooms = $_POST['numOfBathrooms'];
                //$NumOfBedrooms = $_POST['numOfBedrooms'];
                //$Price = $_POST['price'];
                //$Type = $_POST['type'];
                //$_SESSION["error"] = "Error: Email " . $Email . " already registered";
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
                    // Account info
                    //$FName = $_POST['fname'];
                    //$MI = $_POST['mname'];
                    //$LName = $_POST['lname'];
                    //$PhoneNumber = $_POST['phonenum'];
                    //$Email = $_POST['email'];
                    //$Password = $_POST['psw'];
                    // Property info
                    //$State = $_POST['state'];
                    //$City = $_POST['city'];
                    //$Zipcode = $_POST['zip'];
                    //$NumOfBathrooms = $_POST['numOfBathrooms'];
                    //$NumOfBedrooms = $_POST['numOfBedrooms'];
                    //$Price = $_POST['price'];
                    //$Type = $_POST['type'];
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