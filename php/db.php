<?php
    /*
    Contains basic information for connecting to the database and establishes a connection (conn).
    */

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "x1f52";

    //Connect to the mysql database.
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn)
    {
        //If the connection failed, die and display an error message.
        die("Connection failed: " . mysqli_connect_error());
    }
?>