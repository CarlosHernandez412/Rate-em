<?php
// 4-22-22 Leny: Allow landlords to list any new renters
// TO DO: Line 53 + Allow landlords to add/delete/update properties
session_start();
print_r($_SESSION);
require_once "../config/.config.php";

//Update Settings
if (isset($_POST['addTenant'])) {
    unset($_POST['addTenant']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PropertyID = $_POST['propID'];
    $TenantEmail = $_POST['tEmail'];
    $StartDate = $_POST['startDate'];
    $EndDate = $_POST['endDate'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    $Type = $_SESSION['Type'];
    //Verify user with password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if (empty($EndDate))
            $EndDate = NULL;   
        if (strlen($PropertyID) == 0 || strlen($TenantEmail) == 0 || strlen($StartDate) == 0) {
            $_SESSION["PropID"] = $PropertyID;
            $_SESSION["TEmail"] = $TenantEmail;
            $_SESSION["StartDate"] = $StartDate;
            $_SESSION["EndDate"] = $EndDate;
            $_SESSION["error"] = "Please fill out all (*) required fields!";
            header("Location: ../views/property.php");
        } else {
            $db->query("SET @outCome = 0");
            $addRenter = $db->prepare("CALL addOccupant(?, ?, ?, ?, ?, @outCome)");
            $addRenter->bind_param('sisss', $TenantEmail, $PropertyID, $StartDate, $EndDate, $Email);
            if($addRenter->execute()){
                $result = $db->query("SELECT @outCome as outcome");
                $outcome = $result->fetch_assoc();
                $addedRenter = $outcome['outcome'];
                if ($addedRenter > 0) {
                    // Get any new added tenants under the session
                    $query = $db->prepare("SELECT Occupies.* FROM Property NATURAL JOIN Occupies WHERE Property.LEmail =?");
                    $query->bind_param('s', $Email);
                    if ($query->execute()) {
                        $myRenters = $query->get_result();
                        $myRentersList = [];
                        while ($row = $myRenters->fetch_assoc()) {
                            $myRentersList[] = $row;
                        };
                        $_SESSION['myRenters'] = $myRentersList;
                        header("Location: ../views/property.php");
                    } else {
                        // Some cases can be that a landlord is trying to register a renter with the same date and property
                        // Try making StartDate, PropertyID, and Tenant Email primary (unique) keys?
                        echo "Error executing query: " . mysqli_error($db);
                        die();
                    }
                } else {
                    $_SESSION["PropID"] = $PropertyID;
                    $_SESSION["TEmail"] = $TenantEmail;
                    $_SESSION["StartDate"] = $StartDate;
                    $_SESSION["EndDate"] = $EndDate;
                    $_SESSION["error"] = "Invalid property ID, please try again!";
                    header("Location: ../views/property.php");
                }
            } else {
                echo "Error executing query: " . mysqli_error($db);
                die();
            }
        }
    } else {
        $_SESSION["PropID"] = $PropertyID;
        $_SESSION["TEmail"] = $TenantEmail;
        $_SESSION["StartDate"] = $StartDate;
        $_SESSION["EndDate"] = $EndDate;
        $_SESSION["error"] = "Password incorrect, please try again!";
        header("Location: ../views/property.php");
    }
}
