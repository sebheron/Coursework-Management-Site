<?php
    require "db.php";
    require "message.php";
    require "verify.php";

    //Check book exists in database.
    $query = "SELECT id, title FROM books WHERE id = ? LIMIT 1";
    if($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $stmt->bind_result($id, $title);
        while($stmt->fetch()) {
            $bookid = $id;
            $booktitle = $title;
        }
        $stmt->close();
    }

    if (isset($bookid) && is_numeric($bookid)) {
        //Remove book from database.
        $query = "DELETE FROM orders WHERE bookid = ? LIMIT 1";
        if($stmt = $conn->prepare($query)) {
            $stmt->bind_param("i", $bookid);
            $stmt->execute();
            $stmt->close();

            //Display message to user.
            displayMessage("Remove", "Book \"$booktitle\" removed from order.", "orders.php");
        }
        else {
            displayMessage("Remove", "Error connecting to database.", "../");
            exit();
        }
    }
    else {
        displayMessage("Remove", "Book is not currently ordered.", "../");
    }
?>