<?php

session_start();
print_r($_SESSION);

if (!($_SESSION))
    header("Location: ../views/login.php");
else {
    if (!($_SESSION['loggedProfile']))
        header("Location: ../views/login.php");
}
?>
<html>
<!-- 03-26-22 Keben created the landlord settings page -->
<!-- 04-21-22 Keben, Leny: Worked on account updates and tested -->
<!-- 4-25-22 Keben, Leny: Worked on deleting an account and tested -->
<title>Settings</title>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="style.css" rel="stylesheet">

    <script>
        function logout() {
            args = {
                "logout": true
            };
            $.post("../config/accLogin.php", args)
                .done(function(result, status, xhr) {
                    if (status == "success") {
                        console.log(result);
                    } else {
                        console.error(result);
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error(error);
                });
        }

        function update() {
            args = {
                "update": true
            };
            $.post("../config/updateAcc.php", args)
                .done(function(result, status, xhr) {
                    if (status == "success") {
                        console.log(result);
                    } else {
                        console.error(result);
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error(error);
                });
            args = {
                "delete": true
            };
            $.post("../config/updateAcc.php", args)
                .done(function(result, status, xhr) {
                    if (status == "success") {
                        console.log(result);
                    } else {
                        console.error(result);
                    }
                })
                .fail(function(xhr, status, error) {
                    console.error(error);
                });
        }
    </script>

    <style>
        body {
            font-family: "Roboto", sans-serif;
            margin: auto;
            background-image: linear-gradient(to bottom, black, #3dbaff);
            background-attachment: fixed;
            background-size: 100% 100%;
        }

        * {
            box-sizing: border-box;
        }

        /* style inputs andlink buttons */
        input,
        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 20px;
            margin: 5px 0;
            opacity: 0.85;
            display: inline-block;
            font-size: 17px;
            line-height: 20px;
            text-decoration: none;
            /* remove underline from anchors*/
        }

        input:hover,
        .btn:hover {
            opacity: 1;
        }

        /* style the submit button */
        input[type=submit] {
            background-color: #FFFFFF;
            color: black;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #3dbaff;
        }

        /* Responsive layout - when the screen is less than 650px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 650px) {
            .col {
                width: 100%;
                margin-top: 0;
            }

            /* hide the vertical line */
            .vl {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="w3-top">
        <div class="w3-bar w3-theme-d2 w3-left-align w3-large text-color:black">
            <div class="w3-bar w3-top w3-left-align w3-large" style="background-color: #E5F2FF; color: black;">
                <div class="w3-bar-item w3-hide-small"><img src="../images/myicon.png" height="45px"></div>
                <?php if ($_SESSION['Type'] === 'Landlord') {
                    echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
                    <a href=\"../views/myProfile.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Profile</a>
                    <a href=\"../views/settings.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Settings</a>
                    <a href=\"../views/property.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Properies</a>
                    <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
                    <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>
                    <form class=\".logoutLblPos\" action=\"../config/accLogin.php\" method=\"post\">
                        <div class= \"w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right\"><button id=\"logout\" type=\"submit\" name=\"logout\">Logout</button></div>
                    </form>";
                } else if ($_SESSION['Type'] === 'Tenant') {
                    echo "<a href=\"../views/home.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Home</a>
                    <a href=\"../views/myProfile.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Profile</a>
                    <a href=\"../views/settings.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Settings</a>
                    <a href=\"../views/rentals.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">My Rentals</a>
                    <a href=\"../views/aboutus.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">About Us</a>
                    <a href=\"../views/contact.php\" class=\"w3-bar-item w3-button w3-hide-small w3-hover-white\">Contact</a>
                    <form class=\".logoutLblPos\" action=\"../config/accLogin.php\" method=\"post\">
                        <div class= \"w3-bar-item w3-button w3-hide-small w3-hover-light-blue w3-right\"><button id=\"logout\" type=\"submit\" name=\"logout\">Logout</button></div>
                    </form>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <form method="post" class="w3-container2" style="margin: 95px; color: whitesmoke;" action="../config/updateAcc.php">
        <div class="w3-section">
            <div class="w3-center">
                <h6><i><b>Password required</b> to update any account information.</i></h6>
                <h6><i>That includes deleting the account!</i></h6>
                <div style="color: red; font-weight: bold;"><?php if (isset($_SESSION["error"])) {
                                                                print($_SESSION["error"]);
                                                                unset($_SESSION["error"]);
                                                            } ?></div>
                <div style="color: green; font-weight: bold;"><?php if (isset($_SESSION["success"])) {
                                                                    print($_SESSION["success"]);
                                                                    unset($_SESSION["success"]);
                                                                } ?></div>
                <h4><b>Account Settings:</b></h4>
            </div>
            <label>
                <h6>First Name</h6>
            </label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter First Name" value="<?php print_r($_SESSION['loggedProfile']['FName']); ?>" name="fname">
            <label>
                <h6>Middle Name</h6>
            </label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Middle Name" value="<?php print_r($_SESSION['loggedProfile']['MI']); ?>" name="mname">
            <label>
                <h6>Last Name</h6>
            </label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Last Name" value="<?php print_r($_SESSION['loggedProfile']['LName']); ?>" name="lname">
            <label>
                <h6>Phone Number</h6>
            </label>
            <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Phone Number" value="<?php print_r($_SESSION['loggedProfile']['PhoneNumber']); ?>" name="phonenum">
            <label>
                <h6>New Password</h6>
            </label>
            <input class="w3-input w3-border w3-margin-bottom" type="password" placeholder="Enter a New Password" name="newpsw">
            <div class="w3-container">
                <div class="w3-section" style="padding-left: 35%;">
                    <label>
                        <h6>*Current Password</h6>
                    </label>
                    <input class="w3-input w3-border w3-margin-bottom" style="width:50%" type="password" placeholder="Enter Current Password" name="psw" required>
                    <button class="w3-button w3-green w3-center w3-round-xxlarge w3-section w3-padding" style="width:50%" type="submit" name="update">Submit</button>
                    <button class="w3-button w3-red w3-center w3-round-xxlarge w3-section w3-padding" style="width:50%" type="submit" name="delete">DELETE ACCOUNT</button>
                </div>
            </div>
        </div>
    </form>
    <!-- END MAIN -->
    <!--Footer-->
    <footer id="myFooter">
        <div class="w3-container" style="background-color: #E5F2FF; color: black;">
            <!-- w3-theme-l1"> -->
            <h4>Rate 'Em</h4>
            <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
        </div>
    </footer>
</body>

</html>