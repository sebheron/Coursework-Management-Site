<?php
    /*
    Attempts to logout a user by destroying the session.
    */

    require "message.php";

    session_start();
    session_destroy();

    displayMessage("Logout", "Successfully logged out.", "../");
?>