<?php
// 3-17-22 LENY: Start working on login
// 4-4-22 Keben: Login Sessions and Logout Work and got logout working
// 4-08-22 LENY: Also get a logged in account's information (including landlord's properties)
// 4/10/22 Keben: Worked on displaying error message when registering with existing email

// TO DO: Get the account comments/ratings - LINE 77

session_start();
print_r($_SESSION);
require_once "../config/.config.php";

// User login
if (isset($_POST['login'])) {
    unset($_POST['login']);
    $db = getConnected();
    $Email = $_POST['email'];
    $Password = $_POST['psw'];
    $validation = $db->prepare("SELECT * FROM User Where Email =?");
    $validation->bind_param('s', $Email);
    if ($validation->execute()) {
        $Account = $validation->get_result();
        $Acc = [];
        while ($row = $Account->fetch_assoc()) {
            $Acc[] = $row;
        }
        $noAccount = is_null($Acc);
        if ($noAccount) {
            $_SESSION["emailAttempt"] = $_POST['email'];
            $_SESSION["error"] = "Error: Email and/or password is incorrect!";
            header("Location: ../views/login.php");
        } else {
            // Check if it is a tenant account, otherwise it will be a landlord account
            $accType = $db->prepare("SELECT Landlord.Email FROM Landlord Where Email =?");
            $accType->bind_param('s', $Acc[0]["Email"]);
            if ($accType->execute()) {
                if (mysqli_stmt_bind_result($accType, $res_LEmail)) {
                    $landlordAcc = 0;

                    while ($accType->fetch()) {
                        $landlordAcc++;
                    }
                    if ($landlordAcc !== 0) {
                        $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType
                            Where LEmail =?");
                        $query->bind_param('s', $res_LEmail);
                        $query->execute();
                        $properties = $query->get_result();

                        $propertyList = [];
                        while ($row = $properties->fetch_assoc()) {
                            $propertyList[] = $row;
                        }
                        $query = $db->prepare("SELECT Occupies.* FROM Property NATURAL JOIN Occupies WHERE Property.LEmail =?");
                        $query->bind_param('s', $res_LEmail);
                        $query->execute();
                        $myRenters = $query->get_result();

                        $myRentersList = [];
                        while ($row = $myRenters->fetch_assoc()) {
                            $myRentersList[] = $row;
                        };
                        echo json_encode($propertyList);
                        echo json_encode($myRentersList);
                    } else {
                        $query = $db->prepare("SELECT DISTINCT Property.*, PropertyType.Type, Occupies.Stars FROM Property 
                            NATURAL JOIN PropertyType NATURAL JOIN Occupies INNER JOIN Tenant ON Occupies.TEmail =?");
                        $query->bind_param('s', $Email);
                        $query->execute();
                        $properties = $query->get_result();

                        $propertyList = [];
                        while ($row = $properties->fetch_assoc()) {
                            $propertyList[] = $row;
                        }
                        $query = $db->prepare("SELECT Property.LEmail, PropertyType.Type, Occupies.* FROM Property 
                            NATURAL JOIN PropertyType NATURAL JOIN Occupies WHERE Occupies.TEmail =?");
                        $query->bind_param('s', $Email);
                        $query->execute();
                        $properties = $query->get_result();
                        
                        $allRentals = [];
                        while ($row = $properties->fetch_assoc()) {
                            $allRentals[] = $row;
                        }
                        // Get Comments/Ratings for Accounts


                    }
                }
            }
            //Verify user with password
            $pass = password_verify($Password, $Acc[0]["Password"]);
            if ($pass) {
                session_start();
                if ($landlordAcc == 0) {
                    $_SESSION['loggedProfile'] = $Acc[0];
                    $_SESSION['previousRentals'] = $propertyList;
                    $_SESSION['allRentals'] = $allRentals;
                    $_SESSION['Type'] = "Tenant";
                } else {
                    $_SESSION['loggedProfile'] = $Acc[0];
                    $_SESSION['myProperties'] = $propertyList;
                    $_SESSION['myRenters'] = $myRentersList;
                    $_SESSION['Type'] = "Landlord";
                }
                //Route to their profile pages
                header("Location: ../views/myProfile.php");
            } else {
                $_SESSION["emailAttempt"] = $_POST['email'];
                $_SESSION["error"] = "Sorry, Email and/or password is incorrect! :(";
                header("Location: ../views/login.php");
            }
        }
    } else {
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}
if (isset($_POST['logout'])) {
    unset($_POST['logout']);
    session_start();
    echo 'Logout Successfully';
    session_destroy();
    header("Location: ../views/login.php");
}
