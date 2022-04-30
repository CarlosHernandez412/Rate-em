<?php
// 4-29-22 Leny: Test to see if users rating input is read
// 4-29-22 Leny: Users can now leave ratings and comments
// 4-29-22 Leny: Users can now like/dislike comments even undo those dislikes or likes
session_start();
require_once "../config/.config.php";

// Give rating
if (isset($_POST["stars"]) && !empty($_POST["stars"]) && is_numeric($_POST["stars"])) {
    $db = getConnected();
    $userEmail = $_SESSION['loggedProfile']['Email'];
    $ForEmail = $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'];
    $Stars = $_POST['stars'];

    if (strlen($userEmail) == 0 && strlen($ForEmail) == 0 && strlen($Stars) == 0) {
        $_SESSION["error"] = "Make sure you are logged in and leaving a rating for a valid user!";
        header("Location: ../views/resultProfile.php");
    } else {
        $leaveRating = $db->prepare("CALL accountRating(?, ?, ?);");
        $leaveRating->bind_param('sss', $userEmail, $ForEmail, $Stars);
        if ($leaveRating->execute()) {
            // Get new left ratings under session
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
            $getRating->bind_param('s', $ForEmail);
            $getRating->execute();
            $Rating = $getRating->get_result();
            $accRating = $Rating->fetch_assoc();


            $myRates = $db->prepare("SELECT * FROM UserRates WHERE UEmail = ?");
            $myRates->bind_param('s', $userEmail);
            $myRates->execute();
            $Rating = $myRates->get_result();
            $myRating = $Rating->fetch_assoc();

            $_SESSION['loggedProfileRated'] = $myRating;
            $_SESSION['resultUserRating'] = $accRating;
            $_SESSION['success'] = 'Rating successful!';
            header("Location: ../views/resultProfile.php");
        } else {
            $_SESSION['error'] = mysqli_error($db);
            header("Location: ../views/resultProfile.php");
        }
    }
}

if (isset($_POST["leaveComment"])) {
    unset($_POST["leaveComment"]);
    $db = getConnected();
    $userEmail = $_SESSION['loggedProfile']['Email'];
    $ForEmail = $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'];
    $Message = $_POST['message'];

    if (strlen($userEmail) == 0 && strlen($ForEmail) == 0 && strlen($Message) == 0) {
        $_SESSION["error"] = "Make sure you are logged in and leaving a comment for a valid user!";
        header("Location: ../views/resultProfile.php");
    } else {
        $leaveComment = $db->prepare("CALL addComment(?, ?, ?)");
        $leaveComment->bind_param('sss', $userEmail, $ForEmail, $Message);
        if ($leaveComment->execute()) {
            // Get comments
            $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
            $Comments->bind_param('s', $ForEmail);
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
            $_SESSION['resultUserCom.'] = $comments;
            $_SESSION['resultComRates'] = $cRatings;
            $_SESSION['success'] = 'Comment successfully posted!';
            header("Location: ../views/resultProfile.php");
        } else {
            echo "Error executing query: " . mysqli_error($db);
            die();
        }
    }
}


if (isset($_POST["like"])) {
    unset($_POST["like"]);
    $db = getConnected();
    $userEmail = $_SESSION['loggedProfile']['Email'];
    $commentID = $_POST["commentID"];
    $ForEmail = $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'];

    $aLike = 1;
    // Leave like
    $like = $db->prepare("INSERT INTO CommentRates VALUES (?, ?, ?)");
    $like->bind_param('sii', $userEmail, $commentID, $aLike);
    if ($like->execute()) {
        // Get comments
        $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
        $Comments->bind_param('s', $ForEmail);
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
        $_SESSION['resultUserCom.'] = $comments;
        $_SESSION['resultComRates'] = $cRatings;
        $_SESSION['success'] = 'Comment liked!';
        header("Location: ../views/resultProfile.php");
    } else {
        echo "UEmail: ", $userEmail,"\n";
        echo "CommentID: ", $commentID,"\n";
        echo "ForEmai: ", $ForEmail,"\n";
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}

if (isset($_POST["dislike"])) {
    unset($_POST["dislike"]);
    $db = getConnected();
    $userEmail = $_SESSION['loggedProfile']['Email'];
    $commentID = $_POST["commentID"];
    $ForEmail = $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'];

    $aDislike = -1;
    // Leave a dislike
    $dislike = $db->prepare("INSERT INTO CommentRates VALUES (?, ?, ?)");
    $dislike->bind_param('sii', $userEmail, $commentID, $aDislike);
    if ($dislike->execute()) {
        // Get comments
        $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
        $Comments->bind_param('s', $ForEmail);
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
        $_SESSION['resultUserCom.'] = $comments;
        $_SESSION['resultComRates'] = $cRatings;
        $_SESSION['success'] = 'Comment disliked!';
        header("Location: ../views/resultProfile.php");
    } else {
        echo "UEmail: ", $userEmail,"\n";
        echo "CommentID: ", $commentID,"\n";
        echo "ForEmai: ", $ForEmail,"\n";
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}

if (isset($_POST["undo-like"])) {
    unset($_POST["undo-like"]);
    $db = getConnected();
    $userEmail = $_SESSION['loggedProfile']['Email'];
    $commentID = $_POST["commentID"];
    $ForEmail = $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'];

    // Undo a like
    $undo_like = $db->prepare("DELETE FROM CommentRates WHERE UEmail =? AND CommentID =?");
    $undo_like->bind_param('si', $userEmail, $commentID);
    if ($undo_like->execute()) {
        // Get comments
        $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
        $Comments->bind_param('s', $ForEmail);
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
        $_SESSION['resultUserCom.'] = $comments;
        $_SESSION['resultComRates'] = $cRatings;
        $_SESSION['success'] = 'Like undone.';
        header("Location: ../views/resultProfile.php");
    } else {
        echo "UEmail: ", $userEmail,"\n";
        echo "CommentID: ", $commentID,"\n";
        echo "ForEmai: ", $ForEmail,"\n";
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}

if (isset($_POST["undo-dislike"])) {
    unset($_POST["undo-dislike"]);
    $db = getConnected();
    $userEmail = $_SESSION['loggedProfile']['Email'];
    $commentID = $_POST["commentID"];
    $ForEmail = $_SESSION['usersResults'][$_SESSION['selectProfile']]['Email'];

    // Undo a dislike
    $undo_dislike = $db->prepare("DELETE FROM CommentRates WHERE UEmail =? AND CommentID =?");
    $undo_dislike->bind_param('si', $userEmail, $commentID);
    if ($undo_dislike->execute()) {
        // Get comments
        $Comments = $db->prepare("SELECT * FROM User NATURAL JOIN Comment Where Comment.ForEmail =? AND User.Email=Comment.UEmail");
        $Comments->bind_param('s', $ForEmail);
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
        $_SESSION['resultUserCom.'] = $comments;
        $_SESSION['resultComRates'] = $cRatings;
        $_SESSION['success'] = 'Dislike undone.';
        header("Location: ../views/resultProfile.php");
    } else {
        echo "UEmail: ", $userEmail,"\n";
        echo "CommentID: ", $commentID,"\n";
        echo "ForEmai: ", $ForEmail,"\n";
        echo "Error executing query: " . mysqli_error($db);
        die();
    }
}
