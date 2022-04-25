<?php
// 3-26-22 Leny: Start working on registeration for tenant accounts
// 4/10/22 Keben: Worked on displaying error message when registering with existing email
// 3-18-22 Leny: Registration works with validation

session_start();
print_r($_SESSION);
require_once "../config/.config.php";

// Landlord user registeration with validation
if (isset($_POST['tenantReg'])) {
    unset($_POST['tenantReg']);
    $db = getConnected();
    // Account info
    $FName = $_POST['fname'];
    $MI = $_POST['mname'];
    $LName = $_POST['lname'];
    $PhoneNumber = $_POST['phonenum'];
    $Email = $_POST['email'];
    $Password = $_POST['psw'];
    if (
        strlen($FName) == 0 || strlen($LName) == 0 || strlen($PhoneNumber) == 0 || strlen($Email) == 0 ||
        strlen($Password) == 0
    ) {
        $_SESSION["Tfirst"] = $_POST['fname'];
        $_SESSION["Tmid"] = $_POST['mname'];
        $_SESSION["Tlast"] = $_POST['lname'];
        $_SESSION["Tnum"] = $_POST['phonenum'];
        $_SESSION["TeAddress"] = $_POST['email'];
        $_SESSION["Tpass"] = $_POST['psw'];
        $_SESSION["treg_error"] = "Please fill out all (*) required fields!";
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
            $phoneValidation = $db->prepare("SELECT PhoneNumber FROM User Where PhoneNumber =?");
            $phoneValidation->bind_param('s', $PhoneNumber);
            $phoneValidation->execute();
            $phone_count = 0;
            while ($phoneValidation->fetch()) {
                $phone_count++;
            }
            if ($result_count > 0 || $phone_count > 0) {
                if ($result_count > 0)
                    $_SESSION["treg_error"] = "Email '".$Email."' already registered!";
                elseif ($phone_count > 0)
                    $_SESSION["treg_error"] = "An account has already been registered with the phone number '".$PhoneNumber."'";
                $_SESSION["Tfirst"] = $_POST['fname'];
                $_SESSION["Tmid"] = $_POST['mname'];
                $_SESSION["Tlast"] = $_POST['lname'];
                $_SESSION["Tnum"] = $_POST['phonenum'];
                $_SESSION["TeAddress"] = $_POST['email'];
                $_SESSION["Tpass"] = $_POST['psw'];
                $_SESSION["reg_error"] = "Something went wrong, please try again!";
                header("Location: ../views/register.php");
            } else {
                echo "Registering!";
                $hash = password_hash($Password, PASSWORD_DEFAULT);
                $statement = $db->prepare("CALL tenantRegister(?, ?, ?, ?, ?, ?)");
                $statement->bind_param(
                    'ssssss',
                    $Email,
                    $PhoneNumber,
                    $FName,
                    $MI,
                    $LName,
                    $hash
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
}
