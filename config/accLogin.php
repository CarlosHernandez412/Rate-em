<?php
// 3-17-22 LENY: Start working on login
// TO DO: GET MESSAGES TO PRINT ON SCREEN (ANY ERRORS FOR LOGIN ATTEMPTS)

require_once "../config/.config.php";

// User login
if (isset($_POST['login'])) {
    unset($_POST['login']);
    $db = getConnected();
    $Email = $_POST['email'];
    $Password = $_POST['psw'];
    $validation = $db->prepare("SELECT User.Email, User.Password, User.FName FROM User Where Email =?");
    $validation->bind_param('s', $Email);
    if ($validation->execute()) {
        if (mysqli_stmt_bind_result($validation, $res_Email, $res_Password, $res_FName)) {
            
            $result_count = 0;

            while ($validation->fetch()) {
                $result_count++;
            }

            if ($result_count == 0) {
                $_SESSION["error"] = "Error: Email and/or password is incorrect!";
                header("Location: ../views/login.html");
            } else {
                //Verify user with password
                $pass = password_verify($Password, $res_Password);
                if ($pass) {
                    $_SESSION['FName'] = $res_FName;
                    $_SESSION['Email'] = $res_Email;
                    //Route to their profile pages
                    header("Location: ../views/home.html");
                } else {
                    $_SESSION["error"] = "Error: Email and/or password is incorrect!";
                    header("Location: ../views/login.html");
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