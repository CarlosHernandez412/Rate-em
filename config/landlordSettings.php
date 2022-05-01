<?php
// 4-22-22 Leny: Allow landlords to list any new renters
// 4-25-22 Leny: Allow landlords to add new properties
// 4-28-22 Leny: Allow landlords to delete or update property and renter rows 
// 4-30-22 Leny, Keben: Tested Lanaldord Settings
session_start();
require_once "../config/.config.php";

//Add a new tenant
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
                        $_SESSION['success'] = "Renter has been successfully added!";
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

// Add a new property
if (isset($_POST['addProperty'])) {
    unset($_POST['addProperty']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $State = $_POST['state'];
    $City = $_POST['city'];
    $Zipcode = substr($_POST['zip'], 0, 5);
    $NumOfBathrooms = $_POST['numOfBathrooms'];
    $NumOfBedrooms = $_POST['numOfBedrooms'];
    $Price = $_POST['price'];
    $Type = $_POST['type'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    //Verify user with password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if (
            strlen($State) == 0 || strlen($City) == 0 || strlen($Zipcode) == 0 || strlen($NumOfBathrooms) == 0 || strlen($NumOfBedrooms) == 0 ||
            strlen($Price) == 0 || strlen($Type) == 0
        ) {
            $_SESSION["st"] = $State;
            $_SESSION["cty"] = $City;
            $_SESSION["zip"] = $Zipcode;
            $_SESSION["baths"] = $NumOfBathrooms;
            $_SESSION["rms"] = $NumOfBedrooms;
            $_SESSION["cost"] = $Price;
            $_SESSION["ptype"] = $Type;
            $_SESSION["error"] = "Please fill out all (*) required fields!";
            header("Location: ../views/property.php");
        } else {
            $propertyTypes = ['Apartment', 'House', 'Mobile Home', 'Trailer Home', 'Condo', 'Studio'];
            if (in_array($Type, $propertyTypes)) {
                $addProperty = $db->prepare("CALL addProperty(?, ?, ?, ?, ?, ?, ?, ?)");
                $addProperty->bind_param('siidssis', $Email, $NumOfBedrooms, $NumOfBathrooms, $Price, $State, $City, $Zipcode, $Type);
                if ($addProperty->execute()) {
                    // Get any new properties under the session
                    $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType Where LEmail =?");
                    $query->bind_param('s', $Email);
                    if ($query->execute()) {
                        $properties = $query->get_result();
                        $propertyList = [];
                        while ($row = $properties->fetch_assoc()) {
                            $propertyList[] = $row;
                        };
                        $_SESSION['myProperties'] = $propertyList;
                        $_SESSION['success'] = "Property has been successfully added!";
                        header("Location: ../views/property.php");
                    } else {
                        echo "Error executing query: " . mysqli_error($db);
                        die();
                    }
                } else {
                    echo "Error executing query: " . mysqli_error($db);
                    die();
                }
            } else {
                $_SESSION["st"] = $State;
                $_SESSION["cty"] = $City;
                $_SESSION["zip"] = $Zipcode;
                $_SESSION["baths"] = $NumOfBathrooms;
                $_SESSION["rms"] = $NumOfBedrooms;
                $_SESSION["cost"] = $Price;
                $_SESSION["ptype"] = $Type;
                $_SESSION["error"] = "Please enter a valid choice for property type!";
                header("Location: ../views/property.php");
            }
        }
    } else {
        $_SESSION["st"] = $State;
        $_SESSION["cty"] = $City;
        $_SESSION["zip"] = $Zipcode;
        $_SESSION["baths"] = $NumOfBathrooms;
        $_SESSION["rms"] = $NumOfBedrooms;
        $_SESSION["cost"] = $Price;
        $_SESSION["ptype"] = $Type;
        $_SESSION["error"] = "Password incorrect, please try again!";
        header("Location: ../views/property.php");
    }
}

// Update tenant information
if (isset($_POST['updateTenant'])) {
    unset($_POST['updateTenant']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PropertyID = $_POST['propertyID'];
    $TenantEmail = $_POST['TEmail'];
    $StartDate = $_POST['startDate'];
    $EndDate = $_POST['endDate'];
    $Stars = $_POST['Stars'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    //Verify password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if (empty($EndDate))
            $EndDate = NULL;
        if (empty($Stars))
            $Stars = NULL;
        if (strlen($PropertyID) == 0 || strlen($TenantEmail) == 0 || strlen($StartDate) == 0) {
            $_SESSION["error"] = "Please fill out all fields to update tenant row!";
            header("Location: ../views/property.php");
        } else {
            $update = $db->prepare("CALL updateOccupies(?, ?, ?, ?, ?)");
            $update->bind_param('sissi', $TenantEmail, $PropertyID, $StartDate, $EndDate, $Stars);
            if ($update->execute()) {
                // Get new updated rows information under the session
                $updatedRenter = $db->prepare("SELECT Occupies.* FROM Property NATURAL JOIN Occupies WHERE Property.LEmail =?");
                $updatedRenter->bind_param('s', $Email);
                if ($updatedRenter->execute()) {
                    $myRenters = $updatedRenter->get_result();
                    $myRentersList = [];
                    while ($row = $myRenters->fetch_assoc()) {
                        $myRentersList[] = $row;
                    }
                    $_SESSION['myRenters'] = $myRentersList;
                    $_SESSION['success'] = 'Renter information successfully updated!';
                    header("Location: ../views/property.php");
                } else {
                    $_SESSION["error"] = mysqli_error($db);
                    header("Location: ../views/property.php");
                }
            } else {
                $_SESSION["error"] = mysqli_error($db);
                header("Location: ../views/property.php");
            }
        }
    } else {
        $_SESSION["error"] = "Cannot update, password incorrect!";
        header("Location: ../views/property.php");
    }
}

// Update property information
if (isset($_POST['updateProperty'])) {
    unset($_POST['updateProperty']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PropertyID = $_POST['propertyID'];
    $State = $_POST['state'];
    $City = $_POST['city'];
    $Zipcode = substr($_POST['zipcode'], 0, 5);
    $NumOfBathrooms = $_POST['rooms'];
    $NumOfBedrooms = $_POST['baths'];
    $Price = $_POST['price'];
    $Type = $_POST['type'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    //Verify password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if ($pass) {
            if (
                strlen($State) == 0 || strlen($City) == 0 || strlen($Zipcode) == 0 || strlen($NumOfBathrooms) == 0 || strlen($NumOfBedrooms) == 0 ||
                strlen($Price) == 0 || strlen($Type) == 0
            ) {
                $_SESSION["error"] = "Please fill out all fields to update property row!";
                header("Location: ../views/property.php");
            } else {
                $propertyTypes = ['Apartment', 'House', 'Mobile Home', 'Trailer Home', 'Condo', 'Studio'];
                if (in_array($Type, $propertyTypes)) {
                    $update = $db->prepare("CALL updateProperty( ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $update->bind_param('siiidssis', $Email, $PropertyID, $NumOfBedrooms, $NumOfBathrooms, $Price, $State, $City, $Zipcode, $Type);
                    if ($update->execute()) {
                        // Get new updated rows information under the session
                        $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType Where LEmail =?");
                        $query->bind_param('s', $Email);
                        if ($query->execute()) {
                            $properties = $query->get_result();

                            $propertyList = [];
                            while ($row = $properties->fetch_assoc()) {
                                $propertyList[] = $row;
                            }
                            $_SESSION['myProperties'] = $propertyList;
                            $_SESSION['success'] = 'Property successfully updated!';
                            header("Location: ../views/property.php");
                        } else {
                            echo "Error executing query: " . mysqli_error($db);
                            die();
                        }
                    } else {
                        echo "Error executing query: " . mysqli_error($db);
                        die();
                    }
                } else {
                    $_SESSION["error"] = "Cannot update, please enter a valid choice for property type!";
                    header("Location: ../views/property.php");
                }
            }
        } else {
            $_SESSION["error"] = "Cannot update, password incorrect!";
            header("Location: ../views/property.php");
        }
    }
}

// Delete tenant
if (isset($_POST['deleteTenant'])) {
    unset($_POST['deleteTenant']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PropertyID = $_POST['propertyID'];
    $TenantEmail = $_POST['TEmail'];
    $StartDate = $_POST['startDate'];
    $EndDate = $_POST['endDate'];
    $Stars = $_POST['Stars'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    //Verify password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        if (empty($EndDate))
            $EndDate = NULL;
        if (empty($Stars))
            $Stars = NULL;
        $delete = $db->prepare("CALL deleteTenant(?, ?, ?, ?, ?)");
        $delete->bind_param('sissi', $TenantEmail, $PropertyID, $StartDate, $EndDate, $Stars);
        if ($delete->execute()) {
            // Get rows after deleted row under session
            $query = $db->prepare("SELECT Occupies.* FROM Property NATURAL JOIN Occupies WHERE Property.LEmail =?");
            $query->bind_param('s', $Email);
            if ($query->execute()) {
                $myRenters = $query->get_result();
                $myRentersList = [];
                while ($row = $myRenters->fetch_assoc()) {
                    $myRentersList[] = $row;
                }
                $_SESSION['myRenters'] = $myRentersList;
                $_SESSION['success'] = 'Renter successfully deleted!';
                header("Location: ../views/property.php");
            } else {
                echo "Error executing query: " . mysqli_error($db);
                die();
            }
        } else {
            $_SESSION["error"] = "Cannot delete, " . mysqli_error($db);
        }
    } else {
        $_SESSION["error"] = "Cannot delete, password incorrect!";
        header("Location: ../views/property.php");
    }
}

// Delete property
if (isset($_POST['deleteProperty'])) {
    unset($_POST['deleteProperty']);
    $db = getConnected();
    $Email = $_SESSION['loggedProfile']['Email'];
    $PropertyID = $_POST['propertyID'];
    $State = $_POST['state'];
    $City = $_POST['city'];
    $Zipcode = substr($_POST['zipcode'], 0, 5);
    $NumOfBathrooms = $_POST['rooms'];
    $NumOfBedrooms = $_POST['baths'];
    $Price = $_POST['price'];
    $Type = $_POST['type'];
    $Password = $_POST['psw'];
    $AccountPW = $_SESSION['loggedProfile']['Password'];
    //Verify password
    $pass = password_verify($Password, $AccountPW);
    if ($pass) {
        $db->query("SET @outCome = 0");
        $delete = $db->prepare("CALL deleteProperty(?, ?, @outCome)");
        $delete->bind_param('si', $Email, $PropertyID);
        if($delete->execute()){
            $result = $db->query("SELECT @outCome as outcome");
            $outcome = $result->fetch_assoc();
            $deleteSuccess = $outcome['outcome'];
            $deleteSuccess = intval($deleteSuccess);
            if ($deleteSuccess > 1) {
                // Get rows after deleted row under session
                $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType Where LEmail =?");
                $query->bind_param('s', $Email);
                if ($query->execute()) {
                    $properties = $query->get_result();

                    $propertyList = [];
                    while ($row = $properties->fetch_assoc()) {
                        $propertyList[] = $row;
                    }
                    $_SESSION['myProperties'] = $propertyList;
                    $_SESSION['success'] = 'Property successfully updated!';
                    header("Location: ../views/property.php");
                } else {
                    echo "Error executing query: " . mysqli_error($db);
                    die();
                }
            } else {
                $_SESSION["error"] = "Cannot delete property, must have at least 1 property listed!";
                header("Location: ../views/property.php");
            }
        } else {
            $_SESSION["error"] = "Cannot delete, " . mysqli_error($db);
        }
    } else {
        $_SESSION["error"] = "Cannot delete property, password incorrect!";
        header("Location: ../views/property.php");
    }
}
