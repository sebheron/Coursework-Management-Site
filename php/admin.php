<?php
    /*
    Restful service for retrieving all information about an order using an order id.
    */

    require "db.php";
    require "verify.php";

    if (isset($_GET['id'])){
        $id = $_GET['id'];
    }
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
    }
    if (isset($_GET['password'])) {
        $password = $_GET['password'];
    }

    //Login user.
    if (isset($username) && isset($password)) {
        $query = "SELECT password, admin FROM users WHERE email = ? LIMIT 1";
        if($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($dbpassword, $dbadmin);
            while($stmt->fetch()) {
                $loggedin = true;
                if(password_verify($password, $dbpassword)) {
                    $admin = $dbadmin == "Y" ? true : false;
                    if (!$admin) {
                        exit("You are not an admin.");
                    }
                }
                else {
                    exit("Incorrect password.");
                }
            }
            if (isset($loggedin) && !$loggedin) {
                exit("Incorrect username.");
            }
            $stmt->close();
        }
    }
    else if (!isset($response["admin"])) {
        exit("You are not logged in.");
    }
    else if (!$response["admin"]) {
        exit("You are not an admin.");
    }

    //Returns order information.
    function returnOrder($conn, $query, $id = -1) {
        //Build json array.
        $json = array();
        if($stmt = $conn->prepare($query)) {
            if ($id != -1) {
                $stmt->bind_param("i", $id);
            }
            $stmt->execute();
            $stmt->bind_result($oid, $bookid, $title, $author, $price, $userid, $name, $phone, $email);
            while($stmt->fetch()) {
                //Add json attributes to array.
                $json["order"] = array(
                    "id" => $oid,
                );
                $json["book"] = array(
                    "id" => $bookid,
                    "title" => $title,
                    "author" => $author,
                    "price" => $price
                );
                $json["user"] = array(
                    "id" => $userid,
                    "name" => $name,
                    "phone" => $phone,
                    "email" => $email
                );
            }
            $stmt->close();
            //Encode json array.
            echo json_encode($json, JSON_PRETTY_PRINT);
        }
    }

    //Returns order information.
    function returnOrders($conn, $query) {
        //Build json array.
        $json = array();
        if($stmt = $conn->prepare($query)) {
            $stmt->execute();
            $stmt->bind_result($oid);
            while($stmt->fetch()) {
                $json[] = $oid;
            }
            $stmt->close();
            //Encode json array.
            echo json_encode($json, JSON_PRETTY_PRINT);
        }
    }
    
    //Checks if user is an admin.
    if (isset($id) && is_numeric($id) && $id != -1) {
        //Gets all information about the order.
        $query = "SELECT orders.id, orders.bookid, books.title, books.author, books.price, orders.userid, users.name, users.phone, users.email FROM orders INNER JOIN books ON orders.bookid = books.id INNER JOIN users ON orders.userid = users.id WHERE orders.id = ? LIMIT 1";
        returnOrder($conn, $query, $id);
    }
    if (isset($id) && is_numeric($id) && $id == -1) {
        //Gets all order ids.
        $query = "SELECT id FROM orders";    
        returnOrders($conn, $query);
    }
?>