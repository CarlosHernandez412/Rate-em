<?php
// 3-17-22 LENY: Start working on login

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
                header("Location: login.html");
            } else {
                //Verify user with password
                //Uncomment following two lines to verify hashed passwords
                $pass = password_verify($Password, $res_Password);
                if ($pass) {
                /*if ($Password == $res_Password) {*/
                    $_SESSION['FName'] = $res_FName;
                    $_SESSION['Email'] = $res_Email;
                
                    header("Location: home.html");
                } else {
                    $_SESSION["error"] = "Error: Email and/or password is incorrect!";
                    header("Location: login.html");
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