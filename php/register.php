<?php
    /*
    Attempts to register a user assuming the necessary information has been supplied.
    */

	require "db.php";
    require "message.php";
	
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$email = $_POST["email"];
	$password = $_POST["password"];

    //Makes sure all values are supplied.
    if (isset($name) && isset($phone) && isset($email) && isset($password)
    //Validates the email supplied.
    && filter_var($email, FILTER_VALIDATE_EMAIL)
    //Validates the phone number supplied.
    && preg_match("/^(\+44\s?7\d{3}|\(?07\d{3}\)?|\(?01\d{3}\)?)\s?\d{3}\s?\d{3}\$/", $phone)) {
        //Builds the check query.
        $query = "SELECT (phone) FROM users WHERE phone = ? OR email = ? LIMIT 1";
        
        //Prepares the query and executes.
        if($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ss", $phone, $email);
            $stmt->execute();
            $stmt->bind_result($dbphone);
            while($stmt->fetch()) {
                displayMessage("Register", "The email or phone number supplied is already in use.", "../register.html");
                exit();
            }
            $stmt->close();
        }


        //Builds the insert query.
        $query = "INSERT INTO users(name,phone,email,password) VALUES(?, ?, ?, ?)";
	
        //Hashes the password.
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        //Prepares the query and executes.
        if($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssss", $name, $phone, $email, $hashed_password);
            $stmt->execute();
            $stmt->close();

            displayMessage("Register", "Successfully registered.", "../login.html");
            exit();
        }
    }

    displayMessage("Register", "Error: Could not register user.", "../register.html");
?>