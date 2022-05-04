<?php

session_start();

// Contact form submission
if (isset($_POST['submit'])) {
    unset($_POST['submit']);
    $Email = $_POST['email'];
    $Name = $_POST['name'];
    $Subject = $_POST['subject'];
    $Message = $_POST['message'];
	// Validate email adress
	if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
		$_SESSION["error"] = 'Email is not valid!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
	}
	else if (strlen($Email) == 0 || strlen($Name) == 0 || strlen($Subject) == 0 || strlen($Message) == 0) {
		$_SESSION["error"] = 'Please fill out all fields!';
        header('Location: ' . $_SERVER['HTTP_REFERER']);
	} else {
        $to = 'rate.em2022@gmail.com';
        $from = 'noreply@example.com';
        $Body = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $Email . "\r\n" . 'Name: ' . $Name . "\r\n" . 'Message: ' . $Message . "\r\n" . 'X-Mailer: PHP/' . phpversion();
        if (mail($to, $Subject, $Body)) {
            $_SESSION["success"] = 'Email has been sent!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            $_SESSION["error"] = 'Email could not be sent! Please try again!';
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}

?>