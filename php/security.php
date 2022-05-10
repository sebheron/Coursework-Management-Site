<?php
    /*
    Loops through the $_GET array and sanitizes the data.
    */
    foreach ($_GET as $key => $value) {
        $_GET[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    }
?>