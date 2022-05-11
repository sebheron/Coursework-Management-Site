<?php
    require "db.php";
    require "message.php";
    require "verify.php";

    //Gets book name from database using the book id.
    $query = "SELECT title FROM books WHERE id = ? LIMIT 1";
    if($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();
        $stmt->bind_result($name);
        while($stmt->fetch()) {
            $bookname = $name;
        }
        $stmt->close();
    }

    $oid = $_GET['id'];
    $uid = $_SESSION['uid'];

    if (isset($oid) && isset($uid) && is_numeric($oid) && is_numeric($uid)) {
        //Adds the order to the database.
        $query = "INSERT INTO orders (bookid, userid) VALUES (?, ?)";
        if($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ii", $oid, $uid);
            $stmt->execute();
            $stmt->close();
        }
        else {
            displayMessage("Order", "Error connecting to database.", "display.php?id=$oid");
            exit();
        }
        //Displays a message to the user.
        displayMessage("Order", "Order for \"$bookname\" added successfully.", "orders.php");
    }
    else {
        displayMessage("Order", "Error adding order.", "display.php?id=$oid");
    }
?>