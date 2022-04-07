<?php
// 3-17-22 LENY: Start working on login
// TO DO: GET MESSAGES TO PRINT ON SCREEN (ANY ERRORS FOR LOGIN ATTEMPTS)
// 4-4-22 Keben: Login Sessions and Logout Work and got logout working
session_start();
print_r($_SESSION);
require_once "../config/.config.php";

// User login
if (isset($_POST['login'])) {
    unset($_POST['login']);
    $db = getConnected();
    $Email = $_POST['email'];
    $Password = $_POST['psw'];
    $validation = $db->prepare("SELECT User.Email, User.Password FROM User Where Email =?");
    $validation->bind_param('s', $Email);
    if ($validation->execute()) {
        if (mysqli_stmt_bind_result($validation, $res_Email, $res_Password)) {

            $result_count = 0;

            while ($validation->fetch()) {
                $result_count++;
            }

            if ($result_count == 0) {
                $_SESSION["error"] = "Error: Email and/or password is incorrect!";
                header("Location: ../views/login.php");
            } else {
                // Check if it is a tenant account, otherwise it will be a landlord account
                $accType = $db->prepare("SELECT Tenant.Email FROM Tenant Where Email =?");
                $accType->bind_param('s', $Email);
                if ($accType->execute()) {
                    if (mysqli_stmt_bind_result($accType, $res_TEmail)) {
                        $tenantAcc = 0;

                        while ($accType->fetch()) {
                            $tenantAcc++;
                        }
                    }
                }
                //Verify user with password
                $pass = password_verify($Password, $res_Password);
                if ($pass) {
                    session_start();
                    if ($tenantAcc == 0){
                        $_SESSION['Email'] = $res_Email;
                        $_SESSION['Type'] = "Landlord";
                    }
                    else{
                        $_SESSION['Email'] = $res_Email;
                        $_SESSION['Type'] = "Tenant";
                    }
                    //Route to their profile pages
                    header("Location: ../views/profile.php");
                } else {
                    // If login fails, then the input values will be saved so user
                    // does not have to re-type email/password. 
                    // In HTML: add value="<?php echo $--- (question mark)>"
                    //$Email = $_POST['email'];
                    //$Password = $_POST['psw'];
                    $_SESSION["error"] = "Error: Email and/or password is incorrect!";
                    header("Location: ../views/login.php");
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
if (isset($_POST['logout'])) {
    unset($_POST['logout']);
    session_start();
    echo 'Logout Successfully';
    session_destroy();
    header("Location: ../views/login.php");
}
?>