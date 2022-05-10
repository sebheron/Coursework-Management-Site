<?php
    /*
    Attempts to login a user assuming the necessary information has been supplied.
    */

    require "db.php";
    require "message.php";

    $phone = $_POST['phone'];
    $password = $_POST['password'];

    $loggedin = false;

    //Makes sure all values are supplied.
    if (isset($phone) && isset($password)
    //Validates the phone number supplied.
    && preg_match("/^(\+44\s?7\d{3}|\(?07\d{3}\)?|\(?01\d{3}\)?)\s?\d{3}\s?\d{3}\$/", $phone)) {
        $query = "SELECT name, password, admin FROM users WHERE phone = ? LIMIT 1";
        if($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $stmt->bind_result($dbname, $dbpassword, $dbadmin);
            while($stmt->fetch()) {
                if(password_verify($password, $dbpassword)) {
                    $loggedin = true;
                    session_start();
                    session_regenerate_id(); 
                    $_SESSION['id'] = session_id();
                    $_SESSION['name'] = $dbname;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['admin'] = $dbadmin;
                }
            }
            $stmt->close();
        }
        else {
            displayMessage("Login", "Error connecting to database.", "../login.html");
            exit();
        }
    }

    if($loggedin){
        displayMessage("Login", "Successfully logged in.", "../");
    }else{
        displayMessage("Login", "Incorrect Username or Password.", "../login.html");
    }
?>
