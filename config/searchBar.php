<?php
// 3-17-22 LENY: Created a separate file with Laura's work 
// from the homepage for the searches

// 4/04/2022 Laura: Redirecting the user to desired results page
// + connect with database

// 04/08/22 LENY: Helped retrieve data for searches 
// 04/14/22 LENY: Worked on results by landlord/tenant name

// 4/25/2022 Laura & Leny: Retrieving data from filtered searches, only got properties working

// 04/29/2022 Leny: Retrieve the account comments/ratings (There is a better way to do this in the actual views files)

require_once "../config/.config.php";
/* if user enters zipcode redirect them to propertySearch */
if (isset($_POST["search"])) {
    unset($_POST["search"]);
    $db = getConnected();
    if (isset($_POST["zipcode"]) && !empty($_POST["zipcode"]) && is_numeric($_POST["zipcode"])) {
        $Zipcode = $_POST["zipcode"];

        $user = $db->prepare("SELECT DISTINCT User.* FROM Property JOIN User
        Where Property.Zipcode =? AND Property.LEmail = User.Email");
        $user->bind_param('i', $Zipcode);
        $user->execute();
        $Landlord = $user->get_result();
        $LandlordResult = [];
        while ($row = $Landlord->fetch_assoc()) {
            $LandlordResult[] = $row;
        }

        if ($LandlordResult) {
            $property = $db->prepare("SELECT DISTINCT * FROM Property NATURAL JOIN PropertyType
            Where Property.Zipcode =?");
            $property->bind_param('i', $Zipcode);
            $property->execute();
            $Property = $property->get_result();
            $PropertyResult = [];
            while ($row = $Property->fetch_assoc()) {
                $PropertyResult[] = $row;
            }

            // Get comments
            $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
            $Comments->bind_param('s', $LandlordResult[0]['Email']);
            $Comments->execute();
            $GetComments = $Comments->get_result();
            $comments = [];
            while ($row = $GetComments->fetch_assoc()) {
                $comments[] = $row;
            }
            // Get likes/dislikes for each comment that has a rating
            $totalComments = count($comments);
            for ($i = 0; $i < $totalComments; $i++) {
                $commentIDs[] = $comments[$i]['CommentID'];
            }
            $cRatings = [];
            foreach ($commentIDs as $commentID) {
                $commentRatings = $db->prepare("SELECT * FROM CommentRates Where CommentID =?");
                $commentRatings->bind_param('i', $commentID);
                $commentRatings->execute();
                $commentRtes = $commentRatings->get_result();
                while ($row = $commentRtes->fetch_assoc()) {
                    $cRatings[] = $row;
                }
            }
            // Get account rating
            $getRating = $db->prepare(
                "SELECT ForEmail, TotalRating 
                    FROM User INNER JOIN
                    (
                        SELECT AVG(Stars) AS TotalRating, ForEmail
                        FROM UserRates NATURAL JOIN User 
                        GROUP BY ForEmail
                        ) AS Ratings
                        ON Ratings.ForEmail = User.Email
                        WHERE User.Email = ?"
            );
            $getRating->bind_param('s', $LandlordResult[0]['Email']);
            $getRating->execute();
            $Rating = $getRating->get_result();
            $accRating = $Rating->fetch_assoc();

            if($_SESSION['loggedProfile']) {
                $myRates = $db->prepare("SELECT * FROM UserRates WHERE UEmail = ?");
                $myRates->bind_param('s', $_SESSION['loggedProfile']['Email']);
                $myRates->execute();
                $Rating = $myRates->get_result();
                $myRating = $Rating->fetch_assoc();

                $_SESSION['loggedProfileRated'] = $myRating;
            }

            $_SESSION['resultUserCom.'] = $comments;
            $_SESSION['resultComRates'] = $cRatings;
            $_SESSION['resultUserRating'] = $accRating;
            $_SESSION["resultsProperties"] = $PropertyResult;
            $_SESSION["usersResults"] = $LandlordResult;
            $_SESSION['resultType'] = "Landlord";
            header("Location: ../views/propertySearch.php");
        } else {
            $_SESSION['resultUserCom.'] = null;
            $_SESSION['resultComRates'] = null;
            $_SESSION['resultUserRating'] = null;
            $_SESSION["resultsProperties"] = null;
            $_SESSION["usersResults"] = null;
            $_SESSION['resultType'] = null;
            header("Location: ../views/propertySearch.php");
        }
    } else if (isset($_POST["user"]) && !empty($_POST["user"]) && !(is_numeric($_POST["user"]))) {
        $UserSearch = $_POST["user"];
        $query = $db->prepare("SELECT * FROM User Where FName =?");
        $query->bind_param('s', $UserSearch);
        $query->execute();
        $Account = $query->get_result();

        $result = [];
        while ($row = $Account->fetch_assoc()) {
            $result[] = $row;
        }
        if ($result) {
            // Get comments
            $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
            $Comments->bind_param('s', $result[0]['Email']);
            $Comments->execute();
            $GetComments = $Comments->get_result();
            $comments = [];
            while ($row = $GetComments->fetch_assoc()) {
                $comments[] = $row;
            }
            // Get likes/dislikes for each comment that has a rating
            $totalComments = count($comments);
            for ($i = 0; $i < $totalComments; $i++) {
                $commentIDs[] = $comments[$i]['CommentID'];
            }
            $cRatings = [];
            foreach ($commentIDs as $commentID) {
                $commentRatings = $db->prepare("SELECT * FROM CommentRates Where CommentID =?");
                $commentRatings->bind_param('i', $commentID);
                $commentRatings->execute();
                $commentRtes = $commentRatings->get_result();
                while ($row = $commentRtes->fetch_assoc()) {
                    $cRatings[] = $row;
                }
            }
            // Get account rating
            $getRating = $db->prepare(
                "SELECT ForEmail, TotalRating 
                    FROM User INNER JOIN
                    (
                        SELECT AVG(Stars) AS TotalRating, ForEmail
                        FROM UserRates NATURAL JOIN User 
                        GROUP BY ForEmail
                        ) AS Ratings
                        ON Ratings.ForEmail = User.Email
                        WHERE User.Email = ?"
            );
            $getRating->bind_param('s', $result[0]['Email']);
            $getRating->execute();
            $Rating = $getRating->get_result();
            $accRating = $Rating->fetch_assoc();

            if($_SESSION['loggedProfile']) {
                $myRates = $db->prepare("SELECT * FROM UserRates WHERE UEmail = ?");
                $myRates->bind_param('s', $_SESSION['loggedProfile']['Email']);
                $myRates->execute();
                $Rating = $myRates->get_result();
                $myRating = $Rating->fetch_assoc();

                $_SESSION['loggedProfileRated'] = $myRating;
            }

            $accType = $db->prepare("SELECT Landlord.Email FROM Landlord Where Email =?");
            $accType->bind_param('s', $result[0]["Email"]);
            $accType->execute();
            $landlordAcc = 0;

            while ($accType->fetch()) {
                $landlordAcc++;
            }
            if ($landlordAcc == 0) {
                $query = $db->prepare("SELECT DISTINCT Property.*, PropertyType.Type, Occupies.Stars FROM Property 
            NATURAL JOIN PropertyType NATURAL JOIN Occupies NATURAL JOIN Tenant NATURAL JOIN User 
            Where Occupies.TEmail = Tenant.Email AND User.FName =?");
                $query->bind_param('s', $UserSearch);
                $query->execute();
                $prevRentals = $query->get_result();

                $resultsPrevRentals = [];
                while ($row = $prevRentals->fetch_assoc()) {
                    $resultsPrevRentals[] = $row;
                }
                $_SESSION['resultUserCom.'] = $comments;
                $_SESSION['resultComRates'] = $cRatings;
                $_SESSION['resultUserRating'] = $accRating;
                $_SESSION["usersResults"] = $result;
                $_SESSION["resultsPrevRentals"] = $resultsPrevRentals;
                $_SESSION['resultType'] = "Tenant";
                header("Location: ../views/userSearch.php");
            } else if ($landlordAcc > 0) {
                $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType Where LEmail =?");
                $query->bind_param('s', $result[0]["Email"]);
                $query->execute();
                $properties = $query->get_result();

                $propertyList = [];
                while ($row = $properties->fetch_assoc()) {
                    $propertyList[] = $row;
                }
                $_SESSION['resultUserCom.'] = $comments;
                $_SESSION['resultComRates'] = $cRatings;
                $_SESSION['resultUserRating'] = $accRating;
                $_SESSION["usersResults"] = $result;
                $_SESSION["resultsProperties"] = $propertyList;
                $_SESSION['resultType'] = "Landlord";
                header("Location: ../views/userSearch.php");
            }
        } else {
            $_SESSION['resultUserCom.'] = NULL;
            $_SESSION['resultComRates'] = NULL;
            $_SESSION['resultUserRating'] = NULL;
            $_SESSION["usersResults"] = NULL;
            $_SESSION["resultsProperties"] = NULL;
            $_SESSION['resultType'] = NULL;
            header("Location: ../views/userSearch.php");
        }
    } else {
        header("Location: ../views/home.php");
    }
} else {
    header("Location: ../views/home.php");
}

if (isset($_POST["zipcodeAgain"]) && !empty($_POST["zipcodeAgain"]) && is_numeric($_POST["zipcodeAgain"])) {
    $db = getConnected();
    $Zipcode = $_POST["zipcodeAgain"];
    $typeList = $_POST['propertyType'];
    //Filter Search by Property Type
    if (isset($typeList)) {
        foreach ($typeList as $propertyType) {
            $user = $db->prepare("SELECT DISTINCT User.* FROM Property JOIN User JOIN PropertyType
            Where Property.Zipcode =? AND PropertyType.Type =? AND Property.LEmail = User.Email");
            $user->bind_param('is', $Zipcode, $propertyType);
            $user->execute();
            $Landlord = $user->get_result();
            $LandlordResult = [];
            while ($row = $Landlord->fetch_assoc()) {
                $LandlordResult[] = $row;
            }
    
            if ($LandlordResult) {
                $property = $db->prepare("SELECT DISTINCT * FROM Property NATURAL JOIN PropertyType
                Where Property.Zipcode =? AND PropertyType.Type =?");
                $property->bind_param('is', $Zipcode, $propertyType);
                $property->execute();
                $Property = $property->get_result();

                $PropertyResult = [];
                while ($row = $Property->fetch_assoc()) {
                    $PropertyResult[] = $row;
                }

                // Get comments
                $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
                $Comments->bind_param('s', $LandlordResult[0]['Email']);
                $Comments->execute();
                $GetComments = $Comments->get_result();
                $comments = [];
                while ($row = $GetComments->fetch_assoc()) {
                    $comments[] = $row;
                }
                // Get likes/dislikes for each comment that has a rating
                $totalComments = count($comments);
                for ($i = 0; $i < $totalComments; $i++) {
                    $commentIDs[] = $comments[$i]['CommentID'];
                }
                $cRatings = [];
                foreach ($commentIDs as $commentID) {
                    $commentRatings = $db->prepare("SELECT * FROM CommentRates Where CommentID =?");
                    $commentRatings->bind_param('i', $commentID);
                    $commentRatings->execute();
                    $commentRtes = $commentRatings->get_result();
                    while ($row = $commentRtes->fetch_assoc()) {
                        $cRatings[] = $row;
                    }
                }
                // Get account rating
                $getRating = $db->prepare(
                    "SELECT ForEmail, TotalRating 
                    FROM User INNER JOIN
                    (
                        SELECT AVG(Stars) AS TotalRating, ForEmail
                        FROM UserRates NATURAL JOIN User 
                        GROUP BY ForEmail
                        ) AS Ratings
                        ON Ratings.ForEmail = User.Email
                        WHERE User.Email = ?"
                );
                $getRating->bind_param('s', $LandlordResult[0]['Email']);
                $getRating->execute();
                $Rating = $getRating->get_result();
                $accRating = $Rating->fetch_assoc();

                if($_SESSION['loggedProfile']) {
                    $myRates = $db->prepare("SELECT * FROM UserRates WHERE UEmail = ?");
                    $myRates->bind_param('s', $_SESSION['loggedProfile']['Email']);
                    $myRates->execute();
                    $Rating = $myRates->get_result();
                    $myRating = $Rating->fetch_assoc();
    
                    $_SESSION['loggedProfileRated'] = $myRating;
                }

                $_SESSION['resultUserCom.'] = $comments;
                $_SESSION['resultComRates'] = $cRatings;
                $_SESSION['resultUserRating'] = $accRating;
                $_SESSION["resultsProperties"] = $PropertyResult;
                $_SESSION["usersResults"] = $LandlordResult;
                $_SESSION['resultType'] = "Landlord";
                header("Location: ../views/propertySearch.php");
            } else {
                $_SESSION['resultUserCom.'] = null;
                $_SESSION['resultComRates'] = null;
                $_SESSION['resultUserRating'] = null;
                $_SESSION["resultsProperties"] = null;
                $_SESSION["usersResults"] = null;
                $_SESSION['resultType'] = null;
                header("Location: ../views/propertySearch.php");
            }
        }
    } else {
        $user = $db->prepare("SELECT DISTINCT User.* FROM Property JOIN User
        Where Property.Zipcode =? AND Property.LEmail = User.Email");
        $user->bind_param('i', $Zipcode);
        $user->execute();
        $Landlord = $user->get_result();
        $LandlordResult = [];
        while ($row = $Landlord->fetch_assoc()) {
            $LandlordResult[] = $row;
        }

        if ($LandlordResult) {
            $property = $db->prepare("SELECT DISTINCT * FROM Property NATURAL JOIN PropertyType
            Where Property.Zipcode =?");
            $property->bind_param('i', $Zipcode);
            $property->execute();
            $Property = $property->get_result();
            $PropertyResult = [];
            while ($row = $Property->fetch_assoc()) {
                $PropertyResult[] = $row;
            }

            // Get comments
            $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
            $Comments->bind_param('s', $LandlordResult[0]['Email']);
            $Comments->execute();
            $GetComments = $Comments->get_result();
            $comments = [];
            while ($row = $GetComments->fetch_assoc()) {
                $comments[] = $row;
            }
            // Get likes/dislikes for each comment that has a rating
            $totalComments = count($comments);
            for ($i = 0; $i < $totalComments; $i++) {
                $commentIDs[] = $comments[$i]['CommentID'];
            }
            $cRatings = [];
            foreach ($commentIDs as $commentID) {
                $commentRatings = $db->prepare("SELECT * FROM CommentRates Where CommentID =?");
                $commentRatings->bind_param('i', $commentID);
                $commentRatings->execute();
                $commentRtes = $commentRatings->get_result();
                while ($row = $commentRtes->fetch_assoc()) {
                    $cRatings[] = $row;
                }
            }
            // Get account rating
            $getRating = $db->prepare(
                "SELECT ForEmail, TotalRating 
                    FROM User INNER JOIN
                    (
                        SELECT AVG(Stars) AS TotalRating, ForEmail
                        FROM UserRates NATURAL JOIN User 
                        GROUP BY ForEmail
                        ) AS Ratings
                        ON Ratings.ForEmail = User.Email
                        WHERE User.Email = ?"
            );
            $getRating->bind_param('s', $LandlordResult[0]['Email']);
            $getRating->execute();
            $Rating = $getRating->get_result();
            $accRating = $Rating->fetch_assoc();

            if($_SESSION['loggedProfile']) {
                $myRates = $db->prepare("SELECT * FROM UserRates WHERE UEmail = ?");
                $myRates->bind_param('s', $_SESSION['loggedProfile']['Email']);
                $myRates->execute();
                $Rating = $myRates->get_result();
                $myRating = $Rating->fetch_assoc();

                $_SESSION['loggedProfileRated'] = $myRating;
            }

            $_SESSION['resultUserCom.'] = $comments;
            $_SESSION['resultComRates'] = $cRatings;
            $_SESSION['resultUserRating'] = $accRating;
            $_SESSION["resultsProperties"] = $PropertyResult;
            $_SESSION["usersResults"] = $LandlordResult;
            $_SESSION['resultType'] = "Landlord";
            header("Location: ../views/propertySearch.php");
        } else {
            $_SESSION['resultUserCom.'] = null;
            $_SESSION['resultComRates'] = null;
            $_SESSION['resultUserRating'] = null;
            $_SESSION["resultsProperties"] = null;
            $_SESSION["usersResults"] = null;
            $_SESSION['resultType'] = null;
            header("Location: ../views/propertySearch.php");
        }
    }
}

if (isset($_POST["userSearchAgain"]) && !empty($_POST["userSearchAgain"]) && !(is_numeric($_POST["userSearchAgain"]))) {
    $db = getConnected();
    $userAgain = $_POST["userSearchAgain"];
    $query = $db->prepare("SELECT * FROM User Where FName =?");
    $query->bind_param('s', $userAgain);
    $query->execute();
    $Account = $query->get_result();

    $result = [];
    while ($row = $Account->fetch_assoc()) {
        $result[] = $row;
    }
    if ($result) {
        // Get comments
        $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
        $Comments->bind_param('s', $result[0]['Email']);
        $Comments->execute();
        $GetComments = $Comments->get_result();
        $comments = [];
        while ($row = $GetComments->fetch_assoc()) {
            $comments[] = $row;
        }
        // Get likes/dislikes for each comment that has a rating
        $totalComments = count($comments);
        for ($i = 0; $i < $totalComments; $i++) {
            $commentIDs[] = $comments[$i]['CommentID'];
        }
        $cRatings = [];
        foreach ($commentIDs as $commentID) {
            $commentRatings = $db->prepare("SELECT * FROM CommentRates Where CommentID =?");
            $commentRatings->bind_param('i', $commentID);
            $commentRatings->execute();
            $commentRtes = $commentRatings->get_result();
            while ($row = $commentRtes->fetch_assoc()) {
                $cRatings[] = $row;
            }
        }
        // Get account rating
        $getRating = $db->prepare(
            "SELECT ForEmail, TotalRating 
                    FROM User INNER JOIN
                    (
                        SELECT AVG(Stars) AS TotalRating, ForEmail
                        FROM UserRates NATURAL JOIN User 
                        GROUP BY ForEmail
                        ) AS Ratings
                        ON Ratings.ForEmail = User.Email
                        WHERE User.Email = ?"
        );
        $getRating->bind_param('s', $result[0]['Email']);
        $getRating->execute();
        $Rating = $getRating->get_result();
        $accRating = $Rating->fetch_assoc();

        if($_SESSION['loggedProfile']) {
            $myRates = $db->prepare("SELECT * FROM UserRates WHERE UEmail = ?");
            $myRates->bind_param('s', $_SESSION['loggedProfile']['Email']);
            $myRates->execute();
            $Rating = $myRates->get_result();
            $myRating = $Rating->fetch_assoc();

            $_SESSION['loggedProfileRated'] = $myRating;
        }
        
        $accType = $db->prepare("SELECT Landlord.Email FROM Landlord Where Email =?");
        $accType->bind_param('s', $result[0]["Email"]);
        $accType->execute();
        $landlordAcc = 0;

        while ($accType->fetch()) {
            $landlordAcc++;
        }
        if ($landlordAcc == 0) {
            $query = $db->prepare("SELECT DISTINCT Property.*, PropertyType.Type, Occupies.Stars FROM Property 
            NATURAL JOIN PropertyType NATURAL JOIN Occupies NATURAL JOIN Tenant NATURAL JOIN User 
            Where Occupies.TEmail = Tenant.Email AND User.FName =?");
            $query->bind_param('s', $UserSearch);
            $query->execute();
            $prevRentals = $query->get_result();

            $resultsPrevRentals = [];
            while ($row = $prevRentals->fetch_assoc()) {
                $resultsPrevRentals[] = $row;
            }
            $_SESSION['resultUserCom.'] = $comments;
            $_SESSION['resultComRates'] = $cRatings;
            $_SESSION['resultUserRating'] = $accRating;
            $_SESSION["usersResults"] = $result;
            $_SESSION["resultsPrevRentals"] = $resultsPrevRentals;
            $_SESSION['resultType'] = "Tenant";
            header("Location: ../views/userSearch.php");
        } else if ($landlordAcc > 0) {
            $query = $db->prepare("SELECT * FROM Property NATURAL JOIN PropertyType Where LEmail =?");
            $query->bind_param('s', $result[0]["Email"]);
            $query->execute();
            $properties = $query->get_result();

            $propertyList = [];
            while ($row = $properties->fetch_assoc()) {
                $propertyList[] = $row;
            }
            $_SESSION['resultUserCom.'] = $comments;
            $_SESSION['resultComRates'] = $cRatings;
            $_SESSION['resultUserRating'] = $accRating;
            $_SESSION["usersResults"] = $result;
            $_SESSION["resultsProperties"] = $propertyList;
            $_SESSION['resultType'] = "Landlord";
            header("Location: ../views/userSearch.php");
        }
    } else {
        $_SESSION['resultUserCom.'] = NULL;
        $_SESSION['resultComRates'] = NULL;
        $_SESSION['resultUserRating'] = NULL;
        $_SESSION["usersResults"] = NULL;
        $_SESSION["resultsProperties"] = NULL;
        $_SESSION['resultType'] = NULL;
        header("Location: ../views/userSearch.php");
    }
}

?>